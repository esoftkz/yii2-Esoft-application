<?php
namespace common\modules\image\widgets\imagepanel;

use Yii;
use yii\base;
use yii\base\Widget;
use common\modules\image\assets\AppAsset;
use common\modules\image\models\ImageType;

class Imagepanel extends Widget{
	
	//Основная модель какого либо класса
	public $model;
	
	//dataProvider какого либо класса
	public $dataProvider;
	
	//Тип изображения
	public $image_class;
	
	//Название страницы
	public $title;
	
	public function init(){
		parent::init();		
	}
	
	public function run(){	
	
	
		if (!$this->model) {
            throw new base\ErrorException('Не указана основная модель');
        }
		
		if (!$this->dataProvider) {
            throw new base\ErrorException('Не указана dataProvider of images');
        }
		
		if (!$this->image_class) {
            throw new base\ErrorException('Не указан класс изображения');
        }
		
		$this->registerPlugin();
		
	
		$ImageType = ImageType::find()->joinWith('cmsImageAccesses')->andWhere('class_image="'.$this->image_class.'"')->orderBy('relative')->one();
		$paper = $ImageType->path;
		
		return $this->render('index', [	
			'model' => $this->model,
			'dataProvider' => $this->dataProvider,	
			'paper' => $paper,
        ]);		
	}
	
	protected function registerPlugin()
	{
		$view = $this->getView();
		AppAsset::register($view);	
	}	
}
?>