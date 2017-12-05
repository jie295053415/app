<?php
/**
 * Created by PhpStorm.
 * User: KITL0 YUEN
 * Date: 2017/11/6
 * Time: 22:31
 */

namespace app\api\validate;


class Count extends BaseValidate
{
    protected $rule = [
        'count' => 'isPostiveInterger|between:1,15'
    ];
    protected $message = [
        'count' => 'count参数必须是范围在1-15的正整数'
    ];

}