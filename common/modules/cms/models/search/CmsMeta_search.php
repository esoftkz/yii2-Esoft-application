<?php

namespace common\modules\cms\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\cms\models\CmsMeta;
use common\modules\cms\models\Page;
use common\modules\cms\models\Language;
/**
 * CmsMeta_search represents the model behind the search form about `common\modules\page\models\CmsMeta`.
 */
class CmsMeta_search extends CmsMeta
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lang_id', 'page_id'], 'integer'],
            [['meta_title', 'meta_keywords', 'meta_description', 'url_rewrite', 'page.name'], 'safe'],
			
        ];
    }
	
	public function attributes()
	{
		// add related fields to searchable attributes
		return array_merge(parent::attributes(), array('page.name'));
	} 

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
		// Устанвливаем начальный язык, если не выбран
		if(!isset($params['CmsMeta_search']['lang_id']))
			$params['CmsMeta_search']['lang_id']=Language::getDefaultLang()->id;
		
		
        $query = CmsMeta::find()->joinWith('page');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

		$dataProvider->sort->attributes['page.name'] = [
			  'asc' => [Page::tableName().'.name' => SORT_ASC],
			  'desc' => [Page::tableName().'.name' => SORT_DESC],
		 ];
		
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
		
		
		
        $query->andFilterWhere([
            'lang_id' => $this->lang_id,
            'page_id' => $this->page_id,			
        ]);

        $query->andFilterWhere(['like', 'meta_title', $this->meta_title])
            ->andFilterWhere(['like', 'meta_keywords', $this->meta_keywords])
            ->andFilterWhere(['like', 'meta_description', $this->meta_description])
            ->andFilterWhere(['like', 'url_rewrite', $this->url_rewrite])
			->andFilterWhere(['like', Page::tableName().'.name', $this->getAttribute('page.name')]);

        return $dataProvider;
    }
}
