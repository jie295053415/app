<?php
/**
 * Created by PhpStorm.
 * User: KITL0 YUEN
 * Date: 2017/9/25
 * Time: 20:36
 */

namespace app\api\model;


class Theme extends BaseModel
{
    protected $hidden = ['delete_time','update_time', 'topic_img_id', 'head_img_id'];
    /**
     * 之所以在这里定义两个关联模型是因为到时再Theme控制器要用，这样关联比较简单
     *
     */
    // 首页的专题关联image表获取图片url地址
    public function topicImg()
    {
        //如果在image模型中关联就要用到$this->hasOne()
        return $this->belongsTo('image', 'topic_img_id', 'id');
    }

    // 首页专题栏跳转到专题页面关联image表获取图片url地址
    public function headImg()
    {
        return $this->belongsTo('image', 'head_img_id', 'id');
    }

    // 和商品进行多对多关联
    public function products()
    {
        return $this->belongsToMany('product', 'theme_product', 'product_id', 'theme_id');
    }

    public static function getThemeWithProducts($id)
    {
        $theme = self::with('products,topicImg,headImg')->find($id);
        return $theme;
    }
}