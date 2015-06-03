<?php
namespace common\modules\image\models;
 
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;



use yii\imagine\Image as Imagine;
use Imagine\Image\Box;
use Imagine\Image\Point;



/**
 * UploadFile модель для оработки загруженного файла
 */
class UploadFile extends Model
{
	/**
     * Файл
     *
     * @access public
     * @var file
     */
	public $file;
		
	 /**
     * Ширина изображения
     *
     * Default value is null
     *
     * @access public
     * @var integer
     */	
	public $width;
	
	 /**
     * Высота изображения
     *
     * Default value is null
     *
     * @access public
     * @var integer
     */	
	public $height;
	 
	 /**
     * Относительность 
     *
     * Необходима для миниатюры
     *
     * @access public
     * @var integer
     */	
	public $relative;
	
	/**
     * Название папки, куда будем сохранять изображение 
     *    
     * @access public
     * @var string
     */	
	public $savePath = '/default/';
	
	 /**
     * @inheritdoc
     */
    public function rules()
    {
        return [           
			[['file'], 'required'],
			[['file'], 'file', 'extensions'=>'jpg, png, jpeg'],
			[['width', 'height', 'relative'], 'integer'],	
			[['width'], 'default', 'value' => 800],	
			[['height'], 'default', 'value' => 600]
        ];
    }
	
	 /**
     * Загрузка файла на сервер
     *
     * @access public   
     */
	public function uploadFile()
    {	
		$data = array();
		$file = $this->file;
		$data['upload_path'] = Yii::getAlias('@common/modules/image/uploads/').$this->savePath;		
		//Генерация имени файла
		$data['file_name']= $this->generateFileName( $file->name );	
		//Создание папки если нету
		FileHelper::createDirectory($data['upload_path'], 509);
		//Сохранения оригинала		
		$file->saveAs($data['upload_path'].$data['file_name']);	
		self::resizeImage($data['file_name'], $data['upload_path'], '/', $this->width, $this->height, $this->relative);	  
		
		$data['url'] = Yii::$app->urlManager->createAbsoluteUrl('../../common/modules/image/uploads/'.$this->savePath.$data['file_name']);
		
		
		
		return $data;
    }
	
	/**
	 * Создание миниатюры
     * path = путь к uploads + тип файлов (папка) + id пользователя
	 * image_type = тип изображения (в данном случае папка)
	 * Return array; Позиция кропления миниатюры по отношению к оригиналу 
    */
	public static function resizeImage($fileName, $path, $image_type = '/', $width_s, $height_s, $relative)
    {		
		$image = Imagine::getImagine();	
		$origImage = $image->open($path.$fileName);
			
		//Получение размеров файла
		$origImageWidth = $origImage->getSize()->getWidth();
		$origImageHeight = $origImage->getSize()->getHeight();
		
		//Получение отношения сторон
		$ratio = $origImageWidth/$origImageHeight;
		$ratio2 = $width_s/$height_s;
				
		if( $ratio > $ratio2) {
			$width = ($origImageWidth > $width_s ? $width_s : $origImageWidth);					
			$height = $width/$ratio;													
		}
		else {
			$height = ($origImageHeight > $height_s ? $height_s : $origImageHeight);						
			$width = $height*$ratio;									
		}	
		
		// считаем позицию миниатюры относительно главного изобр		
		$width2 = ($ratio > $ratio2 ? $origImageHeight*$ratio2 : $origImageWidth);
		$height2 = ($ratio > $ratio2 ? $origImageHeight : $origImageWidth/$ratio2);
		
		FileHelper::createDirectory($path.$image_type, 509);		
		
		//Возвращаемый массив
		$sizes=array();				
		if($relative == 1){
			$origImage->resize(new Box($width, $height))->save($path.$image_type.$fileName);		
		}else{			
			Imagine::thumbnail($path.$fileName, $width_s, $height_s)->save($path.$image_type.$fileName, ['quality' => 90]);				
			// считаем позицию миниатюры относительно главного изобр		
			$sizes['w'] = $width2;
			$sizes['h'] = $height2;
			$sizes['x'] = ($origImageWidth-$width2)/2;
			$sizes['y'] =($origImageHeight-$height2)/2;			
		}		
		return $sizes;      
    }
	

	/**
	* Генерация имени файла
	*
	* @access private
	* @param  string  Название файла
	* @return string Название файла
	*/
	private static function generateFileName( $name )
    {      
		$ext = end((explode(".", $name)));
		$name = uniqid("").".{$ext}";
				
        return $name;
    } 
}