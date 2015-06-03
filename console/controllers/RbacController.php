<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\rbac\DbManager;
use common\modules\cms\components\rbac\UserRoleRule;

class RbacController extends Controller
{
    public function actionInit()
    {
	
		   
        $auth = Yii::$app->authManager;
        $auth->removeAll(); //������� ������ ������
     
        //�������� ��� ����������
        $rule = new UserRoleRule();
        $auth->add($rule);
        //��������� ����
        $user = $auth->createRole('user');
        $user->description = '������������';
        $user->ruleName = $rule->name;
        $auth->add($user);
        $moder = $auth->createRole('moder');
        $moder->description = '���������';
        $moder->ruleName = $rule->name;
        $auth->add($moder);
        //��������� ��������
        $auth->addChild($moder, $user);
      
        $admin = $auth->createRole('admin');
        $admin->description = '�������������';
        $admin->ruleName = $rule->name;
        $auth->add($admin);
        $auth->addChild($admin, $moder);
		
    }
}