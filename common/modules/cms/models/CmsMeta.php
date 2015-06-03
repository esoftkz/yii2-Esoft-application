<?php

namespace common\modules\cms\models;

use Yii;

/**
 * This is the model class for table "cms_meta".
 *
 * @property integer $lang_id
 * @property integer $page_id
 * @property string $meta_title
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $url_rewrite
 *
 * @property CmsPage $page
 * @property TrLanguage $lang
 */
class CmsMeta extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_meta';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lang_id', 'meta_title', 'meta_keywords', 'meta_description', 'url_rewrite'], 'required'],
            [['lang_id', 'page_id'], 'integer'],
            [['meta_title', 'meta_keywords', 'meta_description'], 'string', 'max' => 255],
			[['url_rewrite'], 'string', 'max' => 80]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'lang_id' => Yii::t('app', 'Язык'),
            'page_id' => Yii::t('app', 'Id'),
            'meta_title' => Yii::t('app', 'Meta Title'),
            'meta_keywords' => Yii::t('app', 'Meta Keywords'),
            'meta_description' => Yii::t('app', 'Meta Description'),
            'url_rewrite' => Yii::t('app', 'Дружественный URL'),
        ];
    }

	
	
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPage()
    {
        return $this->hasOne(Page::className(), ['id' => 'page_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(TrLanguage::className(), ['id' => 'lang_id']);
    }
}
