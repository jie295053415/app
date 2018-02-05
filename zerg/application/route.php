<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
/*return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],

];*/

// 自定义路由
use think\Route;
// banner路由
Route::get('api/:version/banner/:id', 'api/:version.Banner/getBanner');

// Route::get('banner/:id', 'api/v1.Banner/getBanner');

// 某一个theme主题路由
Route::get('api/:version/theme/:id', 'api/:version.Theme/getComplexOne');
// theme路由
Route::get('api/:version/theme', 'api/:version.Theme/getSimpleList');

// product路由
// 最新商品列表
Route::get('api/:version/product/recent', 'api/:version.Product/getRecent');
// 获取分类的商品列表
Route::get('api/:version/product/by-category', 'api/:version.Product/getAllInCategory');
Route::get('api/:version/product/:id', 'api/:version.Product/getOne', [], ['id' => '\d+']);

// category路由
Route::get('api/:version/category', 'api/:version.Category/getAllCategories');
// 地址
Route::post('api/:version/address', 'api/:version.Address/createOrUpdateAddress');

// order
Route::post('api/:version/order', 'api/:version.Order/placeOrder');

// pay

Route::post('api/:version/pay/pre_order', 'api/:version.Pay/getProOrder');



// token
Route::post('api/:version/token/user', 'api/:version.Token/getToken');
