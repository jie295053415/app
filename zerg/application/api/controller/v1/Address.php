<?php
/**
 * Created by PhpStorm.
 * User: KITL0 YUEN
 * Date: 2017/11/18
 * Time: 19:14
 */

namespace app\api\controller\v1;


use app\api\validate\AddressNew;
use app\api\service\Token as TokenService;
use app\api\model\User as UserModel;
use app\lib\exception\SuccessMessage;
use app\lib\exception\UserException;


class Address extends BaseController
{
    protected $beforeActionList = [
        'checkPrimaryScope' => ['only' => 'createOrUpdateAddress']
    ];

    protected function checkPrimaryScope()
    {
        $scope = TokenService::needPrimaryScope();

    }

    public function createOrUpdateAddress()
    {
        $validate = new AddressNew();
        $validate->goCheck();

        // 1. 根据token获取用户uid
        $uid = TokenService::getCurrentUid();

        // 2. 根据uid来查找用户数据, 判断用户是否存在, 如果不存在报异常
        $user = UserModel::get($uid);
        if (!$user) {
            throw new UserException();
        }

        // 3. 获取用户从客户端提交来的地址信息
        $dataArray = $validate->getDataByRule(input('post.'));

        // 4. 根据用户地址信息是否存在, 从而判断是添加地址还是更新地址
        $userAddress = $user->address;

        if (!$userAddress) {
            $user->address()->save($dataArray);
        } else {
            $user->address->save($dataArray);
        }

        return json(new SuccessMessage(), 201);
    }
}