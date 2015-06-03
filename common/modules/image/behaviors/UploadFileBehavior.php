<?php
namespace common\modules\image\behaviors;

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
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use yii\web\NotFoundHttpException;

use yii\imagine\Image as Imagine;
use Imagine\Image\Box;
use Imagine\Image\Point;

use common\modules\cms\models\Language;

use common\modules\image\models\Image;
use common\modules\image\models\ImageAccess;
use common\modules\image\models\ImageThumbnails;
use common\modules\image\models\ImageType;
use common\modules\image\models\UploadFile;

class UploadFileBehavior extends Behavior
{
	/**
	 * @var string название типа загружаемого изображения
	 * необходим для определения видов обрезания изображения
	 */
	public $imageType = '';
		
	/**
	 * @var string название атрибута, хранящего в себе имя файла и файл
	 */
	public $attributeName = '';
	
	/**
	 * @var string путь сохранения
	 */
	public $savePath;
	
	
	/** @var bool erase protection the old value of the model attribute if the form returns empty string */
    public $protectOld = true;

	/** @var bool status of image */
    public $status = 1;
	
	/** @var auto ALT and Title*/
    public $alt = 'name';
	
	/**
     * @var array сценарии валидации к которым будут добавлены правила валидации
     * загрузки файлов
     */
    public $scenarios = ['file_upload'];
	
	public function init() {
        
		//Если мы задали тип изображения
		if(empty($this->imageType)){
			$this->imageType = $this->clean(get_class($this->owner)); 	
		}
		$this->savePath = Yii::getAlias('@common/modules/image/uploads').'/'.$this->imageType;
				
        parent::init();
		
    }
	

	public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'beforeValidate',	
			ActiveRecord::EVENT_AFTER_INSERT => 'afterSave',	
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterUpdate',
			ActiveRecord::EVENT_BEFORE_DELETE => 'beforeDelete'
        ];
    }
	

	public function beforeValidate($event)
    {
         /** @var ActiveRecord $model */
        $model = $this->owner;
        if ($file = UploadedFile::getInstances($model, $this->attributeName)) {
			$model->{$this->attributeName} = $file;
        }
    }
		
	public function afterSave($event)
    {	
		$model = $this->owner;	
		if (in_array($model->scenario, $this->scenarios)) 
	    {	   
			$this->loadFile();
	    }
    }
	
	public function afterUpdate()
    {
		$model = $this->owner;
		if (in_array($model->scenario, $this->scenarios)) 
		{	      
			$this->loadFile();
		}
    }
	
	public function beforeDelete()
    {
		$model = $this->owner;		
		
		$images = Image::find()->where('id_owner='.$model->id)->andWhere('image_class="'.$this->imageType.'"')->all();	
		foreach($images as $image){			
			$image->delete();			
		}	
		
		FileHelper::removeDirectory($this->savePath.'/'.$model->id);		
    }
	
	
	
	protected function loadFile()
    {
        
	   /** @var ActiveRecord $model */
        $model = $this->owner;			    
		
		//Получаем начальную позицию изображения -- доработать
		$position = Image::findIdByOwnerAndClass($model->id,$this->imageType);
		
		//Создание папки
		FileHelper::createDirectory($this->savePath.'/'.$model->id, 509);	
		
		//Получаем все доступные типы изображения
		$image_types=ImageAccess::find()->with('idImageType')->where('class_image="'.$this->imageType.'"')->all();			
        foreach($model->{$this->attributeName} as $key => $data){
			
			//Генерация имени файла
			$fileName = $this->generateFileName( $model->id, $data->name );
		
			//Сохранения оригинала
			$data->saveAs($this->savePath.'/'.$model->id.'/'.$fileName);			
				
			//Проход по всем типам изображения и геренация новых размеров
			$size=array();
			foreach($image_types as $type){
				$path = $this->savePath.'/'.$model->id.'/';
				$image_type = $type->idImageType->path;
				$width = $type->idImageType->width;
				$height = $type->idImageType->height;
				$relative = $type->idImageType->relative;
				
				$size[$type->id] = UploadFile::resizeImage($fileName, $path, $image_type, $width, $height, $relative);		
			}
			
			//Сохранение изображение в базу
			$image = New Image();
			$image->id_owner = $model->id;
			$image->image_class = $this->imageType;
			$image->name = $fileName;
			$image->status = $this->status;
			$image->position = $position;
			$image->id_lang = Language::getDefaultLang()->id;
			$alt = $this->alt;
			if(isset($model->$alt))				
				$image->title = $model->$alt;	
			else
				$image->title='';
			$image->save();
		
			
			foreach($image_types as $type){
				$model_thumbnail = New ImageThumbnails();		
				$model_thumbnail->image_id = $image->id;
				$model_thumbnail->image_type_id = $type->idImageType->id;
				
				$model_thumbnail->x = (float)$size[$type->id]['x'];
				$model_thumbnail->y = (float)$size[$type->id]['y'];
				$model_thumbnail->w = (float)$size[$type->id]['w'];
				$model_thumbnail->h = (float)$size[$type->id]['h'];
				$model_thumbnail->save();
				
			}
			
			//Увеличиваем позицию изображения
			$position++;
		}	
    }
	
	
	

	
	
	/**
     * Генерация имени файла
    */
	private static function generateFileName( $id, $name )
    {      
		$ext = end((explode(".", $name)));
		$name = Yii::$app->security->generateRandomString().".{$ext}";
				
        if ( self::checkUniqueFileName( $id, $name ) ) {
            return $name;
        } else {
			$ext = end(explode(".", $name));  					
            for ( $suffix = 2; !self::checkUniqueFileName( $id, $new_name = $ext[0] . '-' . $suffix . '.' .$ext[1]); $suffix++ ) {}
            return $new_name;
        }
    }
	
	/**
     * Проверка уникальности имени файла
    */
	private static function checkUniqueFileName( $id, $name )
    {        
        $condition = 'id_owner = :owner_id AND name = :name';
        $params = [ ':owner_id' => $id, ':name' => $name ];
      
        return !Image::find()		
            ->where( $condition, $params )
            ->one();
    }
	
	
	/**
	* @param string (класс)
	* @return string (тип изображения)
	*/
	private static function clean($string) {
		
		//возвращается очищенный класс с которого вызвали
		$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
		$string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
		return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
	}
	
	
	
  
}