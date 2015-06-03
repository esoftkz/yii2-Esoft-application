<?php
namespace common\modules\cms\models;

use Yii;

/**
 * This is the model class for table "tr_language".
 *
 * @property integer $id
 * @property string $name
 * @property string $local
 * @property integer $default
 * @property string $url
 * @property integer $status
 */
class Language extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tr_language';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'local', 'default', 'url', 'status'], 'required'],
            [['default', 'status'], 'integer'],
            [['name', 'local', 'url'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'local' => 'Local',
            'default' => 'Default',
            'url' => 'Url',
            'status' => 'Status',
        ];
    }
	
	//Переменная, для хранения текущего объекта языка
	static $current = null;
	
	//Получение текущего объекта языка
	static function getCurrent()
	{
		if( self::$current === null ){
			self::$current = self::getDefaultLang();
		}
		return self::$current;
	}
	
	//Получения объекта языка по умолчанию
	static function getDefaultLang()
	{
		return self::find()->where('`default` = :default', [':default' => 1])->one();
	}
	
	//Получения объекта языка первого
	static function getFirstLang()
	{
		return self::find()->one();
	}
	
	//Изменение старого языка по умолчанию 
	static function deleteDefaultValue()
	{
		$selected_lang=self::getDefaultLang();
		if(isset($selected_lang)){
			$selected_lang->default=0;
			$selected_lang->save();
		}				
	}
	
	//Изменение старого языка по умолчанию 
	static function checkIssetDefault()
	{
		$selected_lang=self::getDefaultLang();
		if(!isset($selected_lang)){
			$selected_lang=self::getFirstLang();
			if(isset($selected_lang)){
				$selected_lang->default=1;
				$selected_lang->save();	
			}
		}		
	}
	
	//Установка текущего объекта языка и локаль пользователя
	static function setCurrent($url = null)
	{
		$language = self::getLangByUrl($url);
		self::$current = ($language === null) ? self::getDefaultLang() : $language;
		Yii::$app->language = self::$current->id;
	}
	

	//Получения объекта языка по буквенному идентификатору
	static function getLangByUrl($url = null)
	{
		if ($url === null) {
			return null;
		} else {
			$language = self::find()->where('url = :url', [':url' => $url])->one();
			if ( $language === null ) {
				return null;
			}else{
				return $language;
			}
		}
	}	

	//Поиск всех активных языков
	public static function findAllActive()
	{
		$models=Language::find()->where('status=1')->all();	
		return $models;
	}	
}