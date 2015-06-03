<?php
namespace common\modules\cms\models;

use Yii;

/**
 * This is the model class for table "tr_dictionary".
 *
 * @property integer $id
 * @property string $message
 * @property integer $language_id
 * @property integer $message_id
 */
class Dictionary extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tr_dictionary';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['message', 'language_id', 'message_id'], 'required'],
            [['message'], 'string'],
            [['language_id', 'message_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'message' => 'Message',
            'language_id' => 'Language ID',
            'message_id' => 'Message ID',
        ];
    }
	
	/**
     * Поиск модели перевода;
	 * @param int $message_id; int $lang_id;
	 * @return найденную модель, или новую модель
     */
	public static function findModel($message_id,$lang_id)
    {	
        $model = self::find()->where('message_id='.$message_id)->andWhere('language_id='.$lang_id)->one();
		if(isset($model))
			return $model;
		else
			return new Dictionary;
    }
	
	
}
