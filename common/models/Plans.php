<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "plans".
 *
 * @property integer $id
 * @property string $name
 */
class Plans extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'plans';
    }
	
	/**
	 * @var file  - загружаемый файл
	 */
	public $image;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
			[['image'], 'required', 'on' => 'file_upload'],
			[['image'], 'file', 'extensions'=>'jpg, png, jpeg', 'skipOnEmpty'=>true, 'maxFiles' => 11],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Название'),
			'image' => Yii::t('app', 'Изображение'),			
        ];
    }
	
	public function behaviors()
    {
        return [
            'UploadFileBehavior' => [
                'class' => 'common\modules\image\behaviors\UploadFileBehavior',
                'attributeName' => 'image',				
				'protectOld' => true,
				'imageType' => 'plans',
            ],
        ];
    }
}
