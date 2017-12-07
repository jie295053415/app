<?php
/**
 * Created by PhpStorm.
 * User: KITL0 YUEN
 * Date: 2017/9/14
 * Time: 21:15
 */

namespace app\api\validate;


class IDMustBePostiveInt extends BaseValidate
{
    protected $rule    = [
        'id' => 'require|isPostiveInterger'
    ];
    protected $message = [
        'id' => 'id必须是正整数'
    ];
}