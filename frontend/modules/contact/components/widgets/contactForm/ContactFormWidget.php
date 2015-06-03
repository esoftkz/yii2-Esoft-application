<?php
namespace frontend\modules\contact\components\widgets\contactForm;

use Yii;
use yii\base;
use yii\base\Widget;
use app\modules\contact\assets\AppAsset;
use app\modules\contact\models\ContactForm;


class ContactFormWidget extends Widget{
	
	//Номер формы, если форм несколько на странице
	public $i = 0;
	
	
	
	public function init(){
		parent::init();		
	}
	
	public function run(){	
		

		$this->registerPlugin();
		
		$model = new ContactForm();
		return $this->render('index', [	
			'model' => $model,
			'i' => $this->i,
        ]);		
	}
	
	protected function registerPlugin()
	{
		$view = $this->getView();
		AppAsset::register($view);	
	}	
}
?>