<?php

namespace common\modules\cms\models;

use Yii;
use common\modules\cms\behaviors\PostBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "cms_posts".
 *
 * @property integer $id
 * @property integer $lang_id
 * @property integer $post_author
 * @property string $post_content
 * @property string $post_title
 * @property integer $post_status
 * @property string $date_created
 * @property string $date_updated
 * @property integer $post_type
 *
 * @property CmsPage[] $cmsPages
 * @property TrLanguage $lang
 */
class CmsPosts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_posts';
    }
	
	public function behaviors()
    {
        return [
            'timestamp' => [
				'class' => TimestampBehavior::classname(),
				'attributes' => [
					ActiveRecord::EVENT_BEFORE_INSERT => 'date_created',
					ActiveRecord::EVENT_BEFORE_UPDATE => 'date_updated',	
				],
				'value' => function() { return date("Y-m-d"); }
			],	
			'PostBehavior' => [
                'class' => PostBehavior::classname(),              
            ],
			
        ];
    }
	
	//ВООБЩЕМ ХЕРНЯ, НА РАБОЧАЯ
	public function beforeValidate()
    {
		if(empty( $this->post_type))
			$this->post_type=Yii::$app->controller->id;	
		$this->post_author=Yii::$app->user->identity->id;	
		
		$parent = parent::beforeValidate();		
		return $parent;
    }
	

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lang_id', 'post_content', 'post_title', 'post_status'], 'required'],
            [['lang_id', 'post_author', 'post_status'], 'integer'],
            [['post_content', 'post_title'], 'string'],
            [['date_created', 'date_updated'], 'safe'],
			[['post_type'], 'string', 'max' => 30]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'lang_id' => Yii::t('app', 'Lang ID'),
            'post_author' => Yii::t('app', 'Post Author'),
            'post_content' => Yii::t('app', 'Описание'),
            'post_title' => Yii::t('app', 'Название'),
            'post_status' => Yii::t('app', 'Статус'),
            'date_created' => Yii::t('app', 'Date Created'),
            'date_updated' => Yii::t('app', 'Date Updated'),
            'post_type' => Yii::t('app', 'Post Type'),
        ];
    }
	
	
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsPages()
    {
        return $this->hasMany(CmsPage::className(), ['post_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(TrLanguage::className(), ['id' => 'lang_id']);
    }
}
