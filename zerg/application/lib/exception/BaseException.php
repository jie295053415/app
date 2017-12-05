<?php
/**
 * Created by PhpStorm.
 * User: KITL0 YUEN
 * Date: 2017/9/16
 * Time: 12:20
 */

namespace app\lib\exception;


use think\Exception;

class BaseException extends Exception
{
    //HTTP状态码
    public $code = 400;
    //错误信息
    public $msg = 'parameter error';
    //错误码
    public $errorCode = 10000;

    //初始化传参
    public function __construct($params=[])
    {
        //判断传入的是否是数组
        if(!is_array($params)) {
            return ;
        }
        //判断是否含有code key
        if(array_key_exists('code',$params)) {
            $this->code = $params['code'];
        }
        //判断是否含有msg key
        if(array_key_exists('msg',$params)) {
            $this->msg = $params['msg'];
        }
        //判断是否含有errorCode key
        if(array_key_exists('errorCode',$params)) {
            $this->errorCode = $params['errorCode'];
        }
    }


}