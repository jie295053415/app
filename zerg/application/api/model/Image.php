<?php

namespace app\api\model;

use think\Model;

class Image extends BaseModel
{
    protected $hidden = ['id', 'from', 'delete_time', 'update_time'];
    //获取本地图片的完整路径
    public function getUrlAttr($value, $data){
        return $this->prefixImgUrl($value, $data);
    }


}
