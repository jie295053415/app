<?php
/**
 * Created by PhpStorm.
 * User: KITL0 YUEN
 * Date: 2017/11/19
 * Time: 22:59
 */

namespace app\api\controller\v1;


use app\api\service\Token as TokenService;
use app\api\service\TokenException;
use app\extra\enum\ScopeEnum;
use app\lib\exception\ForbiddenException;

class Order extends BaseController
{
    protected $beforeActionList = [
        'checkPrimaryScope' => ['only' => 'createOrUpdateAddress']
    ];

    protected function checkExclusiveScope()
    {
        $scope = TokenService::getCurrentTokenVar('scope');

        if ($scope) {
            if ($scope >= ScopeEnum::USER && $scope < ScopeEnum::SUPER) {
                return true;
            } else {
                throw new ForbiddenException();
            }
        } else {
            throw new TokenException();
        }
    }

    // 用户在选择商品后, 向API提交包含它所选择商品的相关信息
    public function placeOrder()
    {

    }
    
    
    // API在接收到信息后,需要检查订单相关商品的库存量
    // 有库存, 把订单数据存入数据库中 = 下单成功了, 返回客户端消息, 告诉客户端可以支付了
    // 调用支付接口, 进行支付
    // 还需要再次进行库存量检测
    // 服务器这边就可以调用微信的支付接口进行支付
    // 微信会返回给我们一个支付的结果
    // 成功: 也需要进仓库存量的检查
    // 成功: 进行库存量的扣除, 失败: 返回一个支付失败的结果

}