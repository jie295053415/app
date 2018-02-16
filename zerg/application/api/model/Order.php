<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/18 0018
 * Time: 22:23
 */

namespace app\api\model;


class Order extends BaseModel
{
    protected $hidden = ['user_id', 'delete_time', 'update_time'];
    const UNPAID = 1;
    const PAID = 2;
    const DELIVERED = 3;
    const PAID_BUT_OUT_OF = 4;

    protected $autoWriteTimestamp = true;

    public static function getSummaryByUser($uid, $page = 1, $size = 15)
    {
        return self::where('user_id', $uid)
            ->order('create_time', 'desc')
            ->paginate($size, true, ['page' => $page]);
    }

    public function getSnapItemsAttr($value)
    {
        if (empty($value)) {
            return null;
        }
        return json_decode($value);
    }

    public function getSnapAddressAttr($value)
    {
        if (empty($value)) {
            return null;
        }
        return json_decode($value);
    }
}