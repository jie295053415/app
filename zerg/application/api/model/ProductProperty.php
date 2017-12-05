<?php
/**
 * Created by PhpStorm.
 * User: KITL0 YUEN
 * Date: 2017/11/14
 * Time: 21:01
 */

namespace app\api\model;


class ProductProperty extends BaseModel
{
    protected $hidden = ['update_time', 'delete_time', 'product_id', 'id'];

    public function imgUrl()
    {
        return $this->belongsTo('Image', 'img_id', 'id');
    }
}