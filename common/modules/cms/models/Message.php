<?php
namespace common\modules\cms\models;

use Yii;

/**
 * This is the model class for table "tr_message".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $code
 */
class Message extends \yii\db\ActiveRecord
{
	/**
     * Переменная, которая необходима для мультиязычности перевода
     */
	public $translate;
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tr_message';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'code'], 'required'],
            [['category_id'], 'integer'],
            [['code'], 'string', 'max' => 255],
			[['translate'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Страница',
            'code' => 'Индентификатор фразы',
        ];
    }
	
	/**
     * Получение string: mesagge по id категории и языка.
	 * В случае неудачи, возвращает пустую строку.
     */
	public static function Message($category_id,$lang_id)
    {
		$lang=Dictionary::find()->where('language_id='.$lang_id)->andWhere('message_id='.$category_id)->one();
		if(isset($lang))	
			return $lang->message;
		else
			return '';              
    }
	
	public function getCategory()
    {
		return $this->hasOne(Page::className(), ['id' => 'category_id']);               
    }
	
}
