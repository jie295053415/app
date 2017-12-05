<?php
/**
 * Created by PhpStorm.
 * User: KITL0 YUEN
 * Date: 2017/9/13
 * Time: 19:10
 */
namespace app\api\controller\v1;

use app\api\validate\IDMustBePostiveInt;
use app\api\model\Banner as BannerModel;
use app\lib\exception\BannerMissException;
use think\exception;



class Banner
{
    /**
	 * 获取指定的id的banner信息
	 * @url /banner/:id
	 * @http  GET
	 * @param  int banner的id号
	 */
	public function getBanner($id)
    {
		(new IDMustBePostiveInt())->goCheck();

		$banner = BannerModel::getBannerByID($id);
		if(!$banner) {
			throw new BannerMissException();
		}
		return $banner;
    }

}
