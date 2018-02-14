<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/12
 * Time: 22:51
 */

namespace app\api\service;


use app\lib\exception\OrderException;
use app\lib\exception\TokenException;
use think\Exception;
use app\api\model\Order as OrderModel;
use app\api\service\Order as OrderService;
use think\Loader;
use think\Log;

// extend/WxPay/WxPay.Api.php
Loader::import('WxPay.WxPay', EXTEND_PATH, '.Api.php');

class Pay
{
    private $orderID;
    private $orderNO;

    public function __construct($orderID)
    {
        if (!$orderID) {
            throw new Exception('订单号不能为空');
        }

        $this->orderID = $orderID;
    }

    public function pay()
    {
        // 订单号不存在
        // 订单号存在, 但不是当前登录的用户的订单
        // 订单是否已支付
        // 检测库存量
        $this->checkOrderValid();
        $orderService = new OrderService();
        $status = $orderService->checkOrderStock($this->orderID);

        if (!$status['pass']) {
            return $status;
        }

        return $this->makeWxPreOrder($status['orderPice']);

    }

    private function makeWxPreOrder($totalPrice)
    {
        // openid
        $openid = Token::getCurrentTokenVar('openid');

        if (!$openid) {
            throw new TokenException();
        }

        $wxOrderData = new \WxPayUnifiedOrder();
        $wxOrderData->setOut_trade_no($this->orderID);
        $wxOrderData->setTrade_type('JSAPI');
        $wxOrderData->setTotal_fee($totalPrice * 100);
        $wxOrderData->setBody('kitlo');
        $wxOrderData->setOpenid($openid);
        $wxOrderData->setNotify_url('');
        return $this->getPaySignature($wxOrderData);
    }

    public function getPaySignature($wxOrderData)
    {
        $wxOrder = \WxPayApi::unifiedOrder($wxOrderData);

        if ($wxOrder['return_code'] != 'SUCCESS' || $wxOrder['result_code'] != 'SUCCESS') {
            Log::record($wxOrder, 'error');
            Log::record('获取预支付订单失败', 'error');
        }

        return null;
    }

    private function checkOrderValid()
    {
        $order = OrderModel::where('id', $this->orderID)
            ->find();

        if (!$order) {
            throw new OrderException();
        }

        if (!Token::isValidOperate($order->user_id)) {
            throw new TokenException([
                'msg'       => '传入的订单号不正确, 请检查',
                'errorCode' => 10003,
            ]);
        }

        if ($order->status != OrderModel::UNPAID) {
            throw new OrderException([
                'msg' => '订单已经支付过了',
                'errorCode' => 80003,
                'code' => 400,
            ]);
        }

        return $this->orderNO = $order->order_no;
    }


}