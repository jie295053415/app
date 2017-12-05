<?php
/**
 * Created by PhpStorm.
 * User: KITL0 YUEN
 * Date: 2017/11/11
 * Time: 15:17
 */

namespace app\api\model;


class Category extends BaseModel
{
    protected $hidden = ['delete_time', 'update_time', 'create_time'];

    protected $table = 'category';

    public function img()
    {
        return $this->belongsTo('Image', 'topic_img_id', 'id');
    }


}