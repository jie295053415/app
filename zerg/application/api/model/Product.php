<?php
/**
 * Created by PhpStorm.
 * User: KITL0 YUEN
 * Date: 2017/9/25
 * Time: 20:35
 */

namespace app\api\model;


class Product extends BaseModel
{
	protected $hidden =['delete_time', 'main_img_id', 'pivot', 'from', 'category_id', 'create_time', 'update_time'];

	public function getMainImgUrlAttr($value, $data)
	{
		return $this->prefixImgUrl($value, $data);
	}

    public function imgs()
    {
        return $this->hasMany('ProductImage', 'product_id', 'id');
	}

	public function properties()
    {
        return $this->hasMany('ProductProperty', 'product_id', 'id');
	}

    public static function getMostRecent($count = 15)
    {
        $products = self::order('create_time desc')
            ->limit($count)
            ->select();
        return $products;
	}

    public static function getProductsByCategoryID($category_id)
    {
        $products = self::where('category_id', $category_id)
            ->select();
        return $products;
	}

    public static function getProductDetail($id)
    {
        $product = self::with(['imgs.imgUrl', 'properties'])->find($id);

        return $product;
	}
}