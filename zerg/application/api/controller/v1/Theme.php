<?php

namespace app\api\controller\v1;


use app\api\validate\IDCollection;
use app\api\validate\IDMustBePostiveInt;
use app\api\model\Theme as ThemeModel;
use app\lib\exception\ThemeException;


class Theme
{
    /**
     * @url /theme?ids=id1,id2,id3,...
     *     //return array  一组theme模型
     *
     */
    public function getSimpleList($ids = '')
    {

        (new IDCollection())->gocheck();
        // 这一句有嫌疑, 重复了
        $ids = explode(',', $ids);
        
        $result = ThemeModel::with('topicImg,headImg')
            ->select($ids);
        
        if($result->isEmpty()){
            throw new ThemeException();  
        }

        return $result;
    }

    public function getComplexOne($id)
    {
        (new IDMustBePostiveInt())->gocheck();

        $theme = ThemeModel::getThemeWithProducts($id);
        
        if($theme){
            throw new ThemeException();  
        }

        return $theme->hidden(['products.summary'])->toArray();
    }
}
