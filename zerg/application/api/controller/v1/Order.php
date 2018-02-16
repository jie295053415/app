<?php
/**
 * Created by PhpStorm.
 * User: KITL0 YUEN
 * Date: 2017/11/19
 * Time: 22:59
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\validate\IDMustBePostiveInt;
use app\api\validate\OrderPlace;
use app\api\service\Token as TokenService;
use app\api\service\Order as OrderService;
use app\api\validate\PagingParameter;
use app\api\model\Order as OrderModel;
use app\lib\exception\OrderException;

class Order extends BaseController
{
//    protected $beforeActionList = [
//        'checkExclusiveScope' => ['only' => 'placeOrder'],
//        'checkPrimaryScope'   => ['only' => 'getSummaryByUser,getDetail'],
//    ];

    // API在接收到信息后,需要检查订单相关商品的库存量
    // 有库存, 把订单数据存入数据库中 = 下单成功了, 返回客户端消息, 告诉客户端可以支付了
    // 调用支付接口, 进行支付
    // 还需要再次进行库存量检测
    // 服务器这边就可以调用微信的支付接口进行支付
    // 小程序更加服务器返回的结果拉起微信支付
    // 微信会返回给我们一个支付的结果 (异步)
    // 成功: 也需要进仓库存量的检查
    // 成功: 进行库存量的扣除, 失败: 返回一个支付失败的结果

    public function getSummaryByUser($page = 1, $size = 15)
    {
        (new PagingParameter())->goCheck();
        $uid = TokenService::getCurrentUid();
        $orders = OrderModel::getSummaryByUser($uid, $page, $size);

        if ($orders->isEmpty()) {
            return [
                'data'         => [],
                'current_page' => $orders->getCurrentPage()
            ];
        }

        return [
            'data'         => $orders->hidden(['snap_items', 'snap_address', 'prepay_id'])
                ->toArray(),
            'current_page' => $orders->getCurrentPage()
        ];
    }

    public function getDetail($id)
    {
        (new IDMustBePostiveInt())->goCheck();

        // 用find() 也可以 find是query的方法
        $orderDetail = OrderModel::get($id);

        if (!$orderDetail) {
            throw new OrderException();
        }

        return $orderDetail->hidden(['prepay_id']);

    }

    // 用户在选择商品后, 向API提交包含它所选择商品的相关信息
    public function placeOrder()
    {
        (new OrderPlace())->goCheck();

        $products = input('post.products/a');

        $uid = TokenService::getCurrentUid();

        $order = new OrderService();

        $status = $order->place($uid, $products);

        return $status;
    }
}