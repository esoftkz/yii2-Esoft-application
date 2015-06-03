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

use common\modules\cms\models\CmsMeta;

class MetaBehavior extends Behavior
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
		$this->createMeta();
    }
			
	/**
	* Создает модель Page и сохраняет в БД
	*/
	protected function createMeta()
    {
        
	   /** @var ActiveRecord $model */
        $model = $this->owner;			    
		
		$meta = new CmsMeta();
		
		$meta->lang_id = $model->language;
		$meta->page_id = $model->id;
		$meta->meta_title = $this->textCut($model->name, 255);
		$meta->url_rewrite = $this->encodestring( $this->textCut($meta->meta_title, 45));
		$meta->save(false);
    }
	
	/**
	* Простая функия кодировки в транслит
	*/
	public function encodestring($str) {
		$rus = array(' ', 'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
		$lat = array('_', 'A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya');
		return str_replace($rus, $lat, $str);
	}
	
	/**
	* Простая функия обрезки текста
	*/
	public function textCut( $str, $maxLen )
	{
		if ( mb_strlen( $str ) > $maxLen )
		{
			preg_match( '/^.{0,'.$maxLen.'} .*?/ui', $str, $match );
			return $match[0];
		}
		else {
			return $str;
		}
	}
	
}