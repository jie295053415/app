<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/6 0006
 * Time: 22:04
 */

namespace app\api\validate;


use app\lib\exception\ParameterException;

class OrderPlace extends BaseValidate
{
    protected $rule = [
        'products' => 'require|checkProducts',
    ];

    protected $singleRule = [
        'product' => 'require|isPostiveInterger',
        'count'   => 'require|isPostiveInterger',
    ];

    protected function checkProducts($values)
    {
        if (!is_array($values)) {
            throw new ParameterException([
                'msg' => '商品参数不正确',
            ]);
        }

        if (empty($values)) {
            throw new ParameterException([
                'msg' => '商品列表不能为空',
            ]);
        }

        foreach ($values as $value) {
            $this->checkProduct($value);
        }

        return true;
    }

    /**
     * @param $value
     * @throws ParameterException
     */
    protected function checkProduct($value)
    {
        $validate = new BaseValidate($this->singleRule);

        $result = $validate->check($value);

        if (!$result) {
            throw new ParameterException([
                'msg' => '商品列表参数错误'
            ]);
        }
    }
}