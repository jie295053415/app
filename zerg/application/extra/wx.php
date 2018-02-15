<?php
/**
 * Created by PhpStorm.
 * User: KITL0 YUEN
 * Date: 2017/11/12
 * Time: 12:40
 */

return [
    'app_id'     => 'wx980d8431338917ae',
    'app_secret' => '25e9097f2f45ef1c20c3b2d37a3fd384',
    'login_url'  => "https://api.weixin.qq.com/sns/jscode2session?" .
        "appid=%s&secret=%s&js_code=%s&grant_type=authorization_code",
];