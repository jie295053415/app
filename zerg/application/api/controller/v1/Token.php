<?php
/**
 * Created by PhpStorm.
 * User: KITL0 YUEN
 * Date: 2017/11/12
 * Time: 8:55
 */

namespace app\api\controller\v1;


use app\api\service\UserToken;
use app\api\validate\TokenGet;

class Token
{
    public function getToken($code = '')
    {
        (new TokenGet())->goCheck();

        $ut = new UserToken($code);
        $token = $ut->get();

        return [
            'token' => $token,
        ];
    }
}