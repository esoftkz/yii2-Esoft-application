<?php

namespace common\modules\cms\models;

use Yii;
use common\modules\cms\behaviors\MetaBehavior;
/**
 * This is the model class for table "page".
 *
 * @property integer $id
 * @property string $name
 * @property integer $post_id
 * @property integer $configurable
 */
class Page extends \yii\db\ActiveRecord
{
	/**
     * Язык
     */
	public $language;
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_page';
    }
	
	public function behaviors()
    {
        return [          
			'MetaBehavior' => [
                'class' => MetaBehavior::classname(),              
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'configurable'], 'required'],
            [['post_id', 'configurable'], 'integer'],
            [['name'], 'string', 'max' => 255]			
        ];
    }
	
	
	

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Страница'),
            'post_id' => Yii::t('app', 'Post ID'),
            'configurable' => Yii::t('app', 'Configurable'),
        ];
    }
}
