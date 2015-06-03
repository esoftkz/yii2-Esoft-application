<?php

namespace common\modules\image\models;

use Yii;

/**
 * This is the model class for table "cms_image_type".
 *
 * @property integer $id
 * @property string $name
 * @property integer $width
 * @property integer $height
 * @property integer $relative
 * @property string $path
 * @property string $default
 *
 * @property CmsImageAccess[] $cmsImageAccesses
 * @property CmsImageThumbnails[] $cmsImageThumbnails
 * @property CmsImage[] $images
 */
class ImageType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_image_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'width', 'height', 'path'], 'required'],
            [['width', 'height', 'relative'], 'integer'],
            [['name', 'path'], 'string', 'max' => 255],
			[['default'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Тип'),
            'width' => Yii::t('app', 'Ширина'),
            'height' => Yii::t('app', 'Высота'),
            'relative' => Yii::t('app', 'Ред.'),
            'path' => Yii::t('app', 'Папка'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsImageAccesses()
    {
        return $this->hasMany(ImageAccess::className(), ['id_image_type' => 'id']);
    }



    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImages()
    {
        return $this->hasMany(Image::className(), ['id' => 'image_id'])->viaTable('cms_image_thumbnails', ['image_type_id' => 'id']);
    }
}
