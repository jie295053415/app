<?php
/**
 * Created by PhpStorm.
 * User: KITL0 YUEN
 * Date: 2017/11/05
 * Time: 14:40
 */

namespace app\lib\exception;


class ThemeException extends BaseException
{
    public $code = 404;
    public $msg = '请求的主题信息不存在';
    public $errorCode = 30000;
}
