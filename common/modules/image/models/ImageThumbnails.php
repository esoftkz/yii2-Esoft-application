<?php

namespace common\modules\image\models;

use Yii;

/**
 * This is the model class for table "cms_image_thumbnails".
 *
 * @property integer $image_id
 * @property integer $image_type_id
 * @property double $x
 * @property double $y
 * @property double $w
 * @property double $h
 *
 * @property CmsImageType $imageType
 * @property CmsImage $image
 */
class ImageThumbnails extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_image_thumbnails';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['image_id', 'image_type_id'], 'required'],
            [['image_id', 'image_type_id'], 'integer'],
            [['x', 'y', 'w', 'h'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'image_id' => Yii::t('app', 'Image ID'),
            'image_type_id' => Yii::t('app', 'Image Type ID'),
            'x' => Yii::t('app', 'X'),
            'y' => Yii::t('app', 'Y'),
            'w' => Yii::t('app', 'W'),
            'h' => Yii::t('app', 'H'),
        ];
    }
	
	public function behaviors()
    {
        return [
            'ImageCropBehavior' => [
                'class' => 'common\modules\image\models\ImageCropBehavior', 
				'savePath' => Yii::getAlias('@common/modules/image/uploads'),	
            ],
        ];
    }

	
	
	
	
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImageType()
    {
        return $this->hasOne(ImageType::className(), ['id' => 'image_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'image_id']);
    }
}
