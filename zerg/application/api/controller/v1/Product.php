<?php
/**
 * Created by PhpStorm.
 * User: KITL0 YUEN
 * Date: 2017/11/6
 * Time: 21:55
 */

namespace app\api\controller\v1;

use app\api\model\Product as ProductModel;
use app\api\validate\Count;
use app\api\validate\IDMustBePostiveInt;
use app\lib\exception\ProductException;

class Product
{
    /**
     * 获取最新商品
     *
     * @param int $count
     * @return false|\PDOStatement|string|\think\Collection
     * @throws ProductException
     */
    public function getRecent($count = 15)
    {
        (new Count())->goCheck();
        $products = ProductModel::getMostRecent($count);

        if($products->isEmpty()){
            throw new ProductException();
        }

        $products = $products->hidden(['summary']);
        return $products;
    }

    /**
     * 获取某个分类商品
     *
     * @param $id
     * @return false|\PDOStatement|string|\think\Collection
     * @throws ProductException
     */
    public function getAllInCategory($id)
    {
        (new IDMustBePostiveInt())->goCheck();

        $products = ProductModel::getProductsByCategoryID($id);

        if($products->isEmpty()) {
            throw new ProductException();
        }

        $products = $products->hidden(['summary']);
        return $products;
    }

    public function getOne($id)
    {
        (new IDMustBePostiveInt())->goCheck();
        $product = ProductModel::getProductDetail($id);

        if (!$product) {
            throw new ProductException();
        }

        return $product;
    }
}