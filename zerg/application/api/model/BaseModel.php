<?php

namespace app\api\model;

use think\Model;

class BaseModel extends Model
{
    //完善本地、远程图片url的完整性
    protected function prefixImgUrl($value, $data){
        $finalUrl = $value;
        if($data['from'] == 1) {
            //是本地图片就拼接图片url
            $finalUrl = config('setting.img_prefix') . $value;
        }
        return $finalUrl;
    }
}
