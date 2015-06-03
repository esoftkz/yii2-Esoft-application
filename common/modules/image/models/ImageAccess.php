<?php

namespace common\modules\image\models;

use Yii;

/**
 * This is the model class for table "cms_image_access".
 *
 * @property string $class_image
 * @property integer $id_image_type
 *
 * @property CmsImageType $idImageType
 * @property CmsImage $classImage
 */
class ImageAccess extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_image_access';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['class_image', 'id_image_type'], 'required'],
            [['id_image_type'], 'integer'],
            [['class_image'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'class_image' => Yii::t('app', 'Class Image'),
            'id_image_type' => Yii::t('app', 'Id Image Type'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdImageType()
    {
        return $this->hasOne(ImageType::className(), ['id' => 'id_image_type']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClassImage()
    {
        return $this->hasOne(Image::className(), ['class' => 'class_image']);
    }
}
