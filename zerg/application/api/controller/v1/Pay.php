<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/4
 * Time: 23:01
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\validate\IDCollection;

class Pay extends BaseController
{
	//    protected $beforeActionList = [
//        'checkExclusiveScope' => ['only' => 'getPreOrder']
//    ];

	public function getPreOrder()
	{
		(new IDCollection)->gocheck();
		
		
	}
}