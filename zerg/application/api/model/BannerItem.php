<?php

namespace app\api\model;

use think\Model;

class BannerItem extends BaseModel
{
    protected $hidden = ['id', 'img_id', 'banner_id', 'delete_time', 'update_time'];
    public function img()
    {
        //关联image表  一对一关系
        return $this->belongsTo('Image', 'img_id', 'id');
    }
}
