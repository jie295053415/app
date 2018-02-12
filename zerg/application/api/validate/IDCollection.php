<?php
/**
 * Created by PhpStorm.
 * User: KITL0 YUEN
 * Date: 2017/9/26
 * Time: 13:00
 */
namespace app\api\validate;


class IDCollection extends BaseValidate
{
    protected $rule = [
        'ids' => 'require|checkIDs'
    ];
    protected $message = [
        'ids' => 'ids参数必须是以逗号分隔的多个正整数'
    ];


}