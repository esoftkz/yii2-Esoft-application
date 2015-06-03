<?php
namespace common\modules\cms\components\rbac;



use Yii;
use yii\rbac\DbManager;

use yii\db\Connection;
use yii\db\Query;
use yii\db\Expression;
use yii\base\InvalidCallException;
use yii\base\InvalidParamException;
use yii\di\Instance;



class DbManager_ext extends DbManager{
	
	public function EditAssign($id)
    {	
		 $this->db->createCommand()
                ->delete($this->assignmentTable, ['user_id' => $id])
                ->execute();
    }
 
}