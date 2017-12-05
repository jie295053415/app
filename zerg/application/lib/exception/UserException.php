<?php
/**
 * Created by PhpStorm.
 * User: KITL0 YUEN
 * Date: 2017/11/18
 * Time: 22:36
 */

namespace app\lib\exception;


class UserException extends BaseException
{
    public $code = 404;
    public $msg = '用户不存在';
    public $errorCode = 60000;
}