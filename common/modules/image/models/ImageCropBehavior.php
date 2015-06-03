<?php

namespace common\modules\image\models;

use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\validators\Validator;


use yii\imagine\Image as Imagine;
use Imagine\Image\Box;
use Imagine\Image\Point;

class ImageCropBehavior extends Behavior{
	
	/**
	 * @var string ���� ����������
	 */
	public $savePath = '../uploads';
	
	
	public function events()
    {
        return [          			
			ActiveRecord::EVENT_AFTER_UPDATE => 'afterUpdate',	
        ];
    }
	
	
	public function afterUpdate()
    {
		$this->crop();
    }
	
	/**
     * ��������� ����
     */
	protected function crop()
    {
		/** @var ActiveRecord $model */
        $model = $this->owner;	
		
		
		/** ������ �������� ���� */
		$ImageType = ImageType::findOne($model->image_type_id);
		
		/** ������ ����������� */
		$ImageModel = Image::findOne($model->image_id);
	
		$this->resizeImage($model, $ImageType, $ImageModel);	
	}
	
	
	
	
	protected function resizeImage($model, $ImageType, $ImageModel)
    {
			
		$image = Imagine::getImagine();	
		
		$origImage = $image->open($this->savePath.'/'.$ImageModel->image_class.'/'.$ImageModel->id_owner.'/'.$ImageModel->name);
			
		$origImage->crop(new Point($model->x, $model->y), new Box($model->w, $model->h))
		->resize(new Box($ImageType->width, $ImageType->height))
		->save($this->savePath.'/'.$ImageModel->image_class.'/'.$ImageModel->id_owner.$ImageType->path.$ImageModel->name);
	 
    }
	
	
	
	
	
	
	
	
	
	
	
	
	

}?>