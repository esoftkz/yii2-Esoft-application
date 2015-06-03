<?php
namespace common\modules\cms\components\rbac;

use Yii;
use yii\rbac\Rule;
use yii\helpers\ArrayHelper;

use common\modules\cms\models\User;

class UserRoleRule extends Rule
{
    public $name = 'userRole';
	
    public function execute($user, $item, $params)
    {
		
        //ѕолучаем массив пользовател€ из базы
        $user = ArrayHelper::getValue($params, 'user', User::findOne($user));
        if ($user) {           
            return $user->id;
        }
        return false;
    }
}