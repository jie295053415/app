<?php

namespace app\api\model;

use think\Model;

class Banner extends BaseModel
{
    //关联banner_item表  一对多关系
    public function items(){
        //                    关联那个表，      外键，     另一张表的主键
        return $this->hasMany('banner_item', 'banner_id', 'id');
    }
    //获取banner信息
    /**
     * @param $id int banner所在位置
     * @return object Banner
     *
     */
    Public static function getBannerByID($id){
        //with是链式操作的一种，叫关联预载入
        $banner = self::with(['items', 'items.img'])
           ->find($id);
        //这里的find可以换成get
       return $banner;
    }
}
