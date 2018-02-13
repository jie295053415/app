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
}