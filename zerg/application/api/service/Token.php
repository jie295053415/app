<?php
/**
 * Created by PhpStorm.
 * User: KITL0 YUEN
 * Date: 2017/11/13
 * Time: 22:02
 */

namespace app\api\service;


use app\extra\enum\ScopeEnum;
use app\lib\exception\ForbiddenException;
use app\lib\exception\TokenException;
use think\Cache;
use think\Exception;
use think\Request;

class Token
{
    /**
     * @return string
     */
    public static function generateToken()
    {
        // 32个字符组成一组随机字符串
        $randChars = getRandChar(32);

        // 用三组字符串,进行md5加密
        $timestamp = $_SERVER['REQUEST_TIME_FlOAT'];

        // salt 盐
        $salt = config('secure.token_salt');

        return md5($randChars . $timestamp . $salt);
    }

    /**
     * 根据token的key值获取到对应的值
     *
     * @param $key
     * @return mixed
     * @throws Exception
     * @throws TokenException
     */
    public static function getCurrentTokenVar($key)
    {
        $token = Request::instance()
            ->header('token');

        // 从缓存中去到token的值
        $vars = Cache::get($token);

        // 判断$vars有没有值
        if (!$vars) {
            throw new TokenException();
        } else {
            // 判断$vars是不是数组
            if (!is_array($vars)) {
                $vars = json_decode($vars, true);
            }
            // 判断传进来的$key是否存在数据
            if (array_key_exists($key, $vars)) {
                // 返回$key对应的值
                return $vars[$key];
            } else {
                throw new Exception('尝试获取的Token变量不存在');
            }
        }
    }

    public static function getCurrentUid()
    {
        $uid = self::getCurrentTokenVar('uid');
        return $uid;
    }

    /**
     * 需要用户和CMS管理员都可以访问的权限
     *
     * @return bool
     * @throws ForbiddenException
     * @throws TokenException
     */
    public static function needPrimaryScope()
    {
        $scope = self::getCurrentTokenVar('scope');

        if ($scope) {
            if ($scope >= ScopeEnum::USER) {
                return true;
            } else {
                throw new ForbiddenException();
            }
        } else {
            throw new TokenException();
        }
    }

    /**
     * 只有用户才可以访问的权限
     *
     * @return bool
     * @throws ForbiddenException
     * @throws TokenException
     */
    public static function needExclusiveScope()
    {
        $scope = self::getCurrentTokenVar('scope');

        if ($scope) {
            if ($scope >= ScopeEnum::USER && $scope < ScopeEnum::SUPER) {
                return true;
            } else {
                throw new ForbiddenException();
            }
        } else {
            throw new TokenException();
        }
    }

    public static function isValidOperate($checkedUID)
    {
        if (!$checkedUID) {
            throw new Exception('传入的订单号不正确, 请检查');
        }

        $currentOperateUID = self::getCurrentUid();

        if ($currentOperateUID === $checkedUID) {
            return true;
        }
        return false;
    }
}