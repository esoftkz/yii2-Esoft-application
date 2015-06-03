<?php

namespace common\modules\image\models;

use Yii;

/**
 * This is the model class for table "cms_image".
 *
 * @property integer $id
 * @property integer $id_owner
 * @property string $name
 * @property string $class
 * @property integer $position
 * @property integer $status
 *
 * @property CmsImageAccess[] $cmsImageAccesses
 * @property CmsImageLang[] $cmsImageLangs
 * @property TrLanguage[] $idLangs
 */
class Image extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_owner', 'name', 'image_class',  'status'], 'required'],
            [['id_owner', 'position', 'status', 'id_lang'], 'integer'],
            [['name', 'image_class', 'title'], 'string', 'max' => 255],
			[['id_lang', 'title'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_owner' => Yii::t('app', 'Id Owner'),
            'name' => Yii::t('app', 'Название'),
            'image_class' => Yii::t('app', 'Тип'),
            'position' => Yii::t('app', 'Позиция'),
            'status' => Yii::t('app', 'Статус'),
			'id_lang' => Yii::t('app', 'Язык'),
			'title' => Yii::t('app', 'Заголовок'),
        ];
    }

	
	/**
     * @return last (int)id Or 0
     */
    public static function findIdByOwnerAndClass($id_owner, $image_class)
    {
		$position=(int)Image::find()->select('position')->where('id_owner='.$id_owner)->andWhere('image_class="'.$image_class.'"')->orderBy('position DESC')->one();
		$position++;
		
		return $position;
    }
	
	/**
     * Удаление по id
     */
    public static function deleteById($id)
    {
		$model=Image::find()->where('id='.$id)->one();		
		//Тут тупо по всем папкам прогоняем 
		$ImageTypes=ImageType::find()->all();		
		foreach($ImageTypes as $ImageType){
			//Путь к изображению
			$image_path=Yii::getAlias('@common').'/modules/image/uploads/'.$model->image_class.'/'.$model->id_owner.$ImageType->path.$model->name;		
			if(is_file($image_path)){
				unlink( $image_path );	
			}			
		}
		$model->delete();
        return true;
    }
	
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsImageAccesses()
    {
        return $this->hasMany(ImageAccess::className(), ['class_image' => 'image_class']);
    }
	
	 /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsImageThumbnails()
    {
        return $this->hasMany(ImageThumbnails::className(), ['image_id' => 'id']);
    }

   

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdLangs()
    {
        return $this->hasMany(common\modules\localization\models\Language::className(), ['id' => 'id_lang'])->viaTable('cms_image_lang', ['id_image' => 'id']);
    }
}
