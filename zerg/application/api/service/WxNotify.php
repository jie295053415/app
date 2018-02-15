<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/15
 * Time: 16:26
 */

namespace app\api\service;


use app\api\model\Order as OrderModel;
use app\api\model\Product;
use app\api\service\Order as OrderService;
use app\lib\exception\OrderException;
use think\Db;
use think\Exception;
use think\Loader;
use think\Log;

Loader::import('WxPay.WxPay', EXTEND_PATH, '.Api.php');

class WxNotify extends \WxPayNotify
{
    public function NotifyProcess($data, &$msg)
    {
        if ($data['result_code'] == 'SUCCESS') {
            $orderNo = $data['out_trade_no'];

            Db::startTrans();
            try {
                $order = OrderModel::where('order_no', $orderNo)
                    ->lock(true)
                    ->find();
                if ($order->status == OrderModel::UNPAID) {
                    $orderService = new OrderService();
                    $stockStatus = $orderService->checkOrderStock($order->id);
                    if ($stockStatus['pass']) {
                        $this->updateOrderStatus($order->id, $stockStatus['pass']);
                        $this->reduceStock($stockStatus);
                    } else {
                        $this->updateOrderStatus($order->id, false);
                    }
                }

                Db::commit();
                // 表示已经正确处理完成了, 不用wechat服务器继续请求
                return true;
            } catch (Exception $e) {
                Db::rollback();
                Log::error($e);
                return false;

                throw new $e;
            }
        } else {
            return true;
        }
    }

    private function updateOrderStatus($orderID, $success)
    {
        $status = $success ? OrderModel::PAID : OrderModel::PAID_BUT_OUT_OF;

        $order = OrderModel::where('id', $orderID)->find();
        if (!$order) {
            throw new OrderException();
        }
        $order->update([
            'status' => $status,
        ]);
    }

    private function reduceStock($stockStatus)
    {
        foreach ($stockStatus['pStautsArray'] as $singlePStatus) {
//            $singlePStatus['count']
            $product = Product::where(id, $singlePStatus['id'])
                ->setDec('stock', $singlePStatus['count']);
        }
    }

}