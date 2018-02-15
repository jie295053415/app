<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/4
 * Time: 23:01
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\service\WxNotify;
use app\api\validate\IDCollection;
use app\api\service\Pay as PayService;

class Pay extends BaseController
{
//    protected $beforeActionList = [
//        'checkExclusiveScope' => ['only' => 'getPreOrder']
//    ];

	public function getPreOrder($id = '')
	{
		(new IDCollection)->gocheck();
		
		$pay = new PayService($id);

		return $pay->pay();
	}

    public function receiveNotify()
    {
        // 通知方频率为15/15/30/180/1800/1800/1800/3600, 单位:秒
        // 1. 检查库存量
        // 2. 更新订单状态
        // 3. 减少库存
        // 如果成功处理, 我们返回微信成功处理的信息. 否则, 我们需要返回没有成功处理
        $notify = new WxNotify();
        $notify->Handle();
	}
}