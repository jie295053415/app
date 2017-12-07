<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/7 0007
 * Time: 23:20
 */

namespace app\api\service;

//use app\api\model\Product as ProductModel;
use app\api\model\Product;

class Order
{
    // 订单的商品列表，也就是客户端传递过来的products参数
    protected  $oProducts;

    // 真是的商品信息（包括库存量）
    protected  $products;

    protected $uid;

    public function place($uid, $oProducts)
    {
        // $oProducts 和 $products 作对比
        // products从数据库中查询出来
        $this->oProducts = $oProducts;
        $this->products = $this->getProductsByOrder($oProducts);
        $this->uid = $uid;
    }

    // 根据订单信息查找真实的库存
    private function getProductsByOrder($oProducts)
    {
        $oPIDs = [];
        foreach ($oProducts as $item) {
            array_push($oPIDs, $item['product_id']);
        }

        $products = Product::all($oPIDs)
            ->visible(['id', 'price', 'stock', 'name', 'main_img_url'])
            ->toArray();
        return $products;
    }


}