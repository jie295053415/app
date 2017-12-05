<?php
/**
 * Created by PhpStorm.
 * User: KITL0 YUEN
 * Date: 2017/9/19
 * Time: 15:20
 */


//appid  $url $secret
$appID = 'wx0eed5c77f630dd7e&secret';
$sectet = 'c974f26f77f06ea6b7e7b988ceb9ff12';
$url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appID.'='.$sectet;

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL,$url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

