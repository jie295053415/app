<?php
/**
 * Created by PhpStorm.
 * User: KITL0 YUEN
 * Date: 2017/9/14
 * Time: 22:39
 */

namespace app\api\validate;


use app\lib\exception\ParameterException;
use think\Request;
use think\Validate;

class BaseValidate extends Validate
{
    public function goCheck()
    {
        //实例化Request对象
        $request = Request::instance();
        //通过Request对象获取所有参数
        $params = $request->param();
        //通过父类方法验证参数(之所以加batch，是因为参数传过来有多个，如果没有batch，系统只会验证第一个，
        //那如果后面参数还有错，这样就会造成传参要多次才能获取信息，造成用户体验不好)
        $result = $this->batch()->check($params);
        //判断验证结果
        if (!$result) {
            $e = new ParameterException([
                'msg' => $this->error,
            ]);
            throw $e;

            /*$error = $this->error;
            throw new Exception($error);*/
        } else {
            return true;
        }
    }

    //验证是否是正整数的方法  其实rule, data, field 参数可以不用写在方法里
    protected function isPostiveInterger($value, $rule = '', $data = '', $field = '')
    {
        if (is_numeric($value) && is_int($value + 0) && ($value + 0) > 0) {
            return true;
        } else {
            return false;
        }
    }

    //验证传进来的ID是否是正整数
    public function checkIDs($value){
        $values = explode(',', $value);
        if(empty($values)){
            return false;
        }
        foreach ($values as $id){
            if(!$this->isPostiveInterger($id)){
                return false;
            }
        }
        return true;
    }

    /**
     * 验证是否为空
     *
     * @param $value
     * @return bool
     */
    protected function isNotEmpty($value)
    {
        return empty($value) ? false : true;
    }

    protected function isMobile($value)
    {
        $rule = '/^1[3|4|5|7|8]\d{9}$/';
        $match = preg_match($rule, $value);

        return $match ? true : false;
    }

    public function getDataByRule($array)
    {
        if (array_key_exists('uid', $array ) | array_key_exists('user_id', $array)) {
            throw new ParameterException([
                'msg' => '参数中包括有非法的参数名user_id或uid',
            ]);
        }

        $new_arr = [];

        // $rule 的键是合法的键 通过foreach 合法的键才能留下来 不合法的就过滤
        foreach ($this->rule as $key => $value) {
            $new_arr[$key] = $array[$key];
        }

        return $new_arr;
    }
}