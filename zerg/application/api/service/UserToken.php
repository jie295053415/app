<?php
/**
 * Created by PhpStorm.
 * User: KITL0 YUEN
 * Date: 2017/11/12
 * Time: 11:02
 */

namespace app\api\service;


use app\extra\enum\ScopeEnum;
use app\lib\exception\WeChatException;
use think\Exception;
use app\api\model\User as UserModel;

class UserToken extends Token
{
    protected $code;
    protected $wxAppID;
    protected $wxAppSecret;
    protected $wxLoginUrl;

    public function __construct($code)
    {
        $this->code = $code;
        $this->wxAppID = config('wx.app_id');
        $this->wxAppSecret = config('wx.app_secret');
        $this->wxLoginUrl = sprintf(config('wx.login_url'),
            $this->wxAppID, $this->wxAppSecret, $this->code);
    }

    public function get()
    {
        $result = curl_get($this->wxLoginUrl);
        $wxResult = json_decode($result, true);
        if (empty($wxResult)) {
            throw new Exception('获取session_key及openID时异常,微信内部错误');
        } else {
            $loginFail = array_key_exists('errcode', $wxResult);
            if ($loginFail) {
                $this->processLoginError($wxResult);
            } else {
                return $this->grantToken($wxResult);
            }
        }
    }

    private function processLoginError($wxResult)
    {
        throw new WeChatException([
            'msg' => $wxResult['errmsg'],
            'errorCode' => $wxResult['errcode'],
        ]);
    }


    private function grantToken($wxResult)
    {
        // 拿到openid
        $openid = $wxResult['openid'];
        $user = UserModel::getByOpenID($openid);
        // 数据库里看一下,这个openid是不是已经存在
        // 如果存在,则不处理,如果不存在,新增一条user记录
        $uid = $user ? $user->id : $this->newUser($openid);
//        if ($user) {
//            $uid = $user->id;
//        } else {
//            $uid = $this->newUser($openid);
//        }
        // 生成令牌,主表缓存数据,写入缓存
        $cacheValue = $this->prepareCacheValue($wxResult, $uid);
        // key :令牌
        // value: wxResult, uid, scope
        $token = $this->saveToCache($cacheValue);

        // 把令牌返回到客户端
        return $token;
    }

    private function saveToCache($cacheValue)
    {
        $key = self::generateToken();
        $value = json_encode($cacheValue);
        $expire_in = config('setting.token_expire_in');

        $request = cache($key, $value, $expire_in);

        if ($request) {
            throw new TokenException([
                'msg'       => '服务器缓存异常',
                'errorCode' => 10005,
            ]);
        }
        return $key;
    }

    private function prepareCacheValue($wxResult, $uid)
    {
        $cacheValue = $wxResult;
        $cacheValue['uid'] = $uid;
        $cacheValue['scope'] = ScopeEnum::USER;

        return $cacheValue;
    }

    private function newUser($openid)
    {
        $user = UserModel::create([
            'openid' => $openid,
        ]);
        return $user->id;
    }
}