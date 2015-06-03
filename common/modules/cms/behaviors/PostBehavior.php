<?php
namespace common\modules\cms\behaviors;

/**
 * UploadFileBehavior for Yii2
 *
 * @author Elle <2481496@gmail.om>
 * @version 0.1
 * @package Behaviors for Yii2
 *
 */
 
use yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;

use common\modules\cms\models\Page;

class PostBehavior extends Behavior
{	
	public function init() {
        		
        parent::init();
		
    }
	
	public function events()
    {
        return [           
			ActiveRecord::EVENT_AFTER_INSERT => 'afterSave'	           			
        ];
    }
		
	public function afterSave($event)
    {	
		$model = $this->owner;	
		$this->createPage();
    }
		
	
	/**
	* Создает модель Page и сохраняет в БД
	*/
	protected function createPage()
    {
        
	   /** @var ActiveRecord $model */
        $model = $this->owner;			    
		
		$page = new Page();
		$page->post_id = $model->id;
		$page->name = $model->post_title;
		$page->configurable = 1;
		$page->language = $model->lang_id;
		$page->save();
    }
}