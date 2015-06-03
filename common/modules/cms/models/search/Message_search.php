<?php

namespace common\modules\cms\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\cms\models\Message;
use common\modules\cms\models\Language;
use common\modules\cms\models\Dictionary;


class Message_search extends Message
{
	public $lang_attributes = array();

	public function init()
    {      
        parent::init();
		$this->lang_attributes=$this->lang_attributes($this->lang_array());
		array_push($this->lang_attributes, "category.name");
		
    }
		
	public function lang_array(){
		$languages=Language::find()->all();
		return $languages;
	}
	
	public function lang_attributes($languages){
		$arr=array();
		foreach($languages as $language){	
			$arr[]='message'.$language->id;
		}
		return $arr;
	}
	
	
	
	public function attributes()
	{
		// add related fields to searchable attributes
		return array_merge(parent::attributes(), $this->lang_attributes);
	} 

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'category_id'], 'integer'],
            [['code'], 'safe'],
			[$this->lang_attributes, 'safe'],
        ];
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
        $query = Message::find()->joinWith('category');

		$languages=$this->lang_array();
		foreach($languages as $language){			
			$subQuery = Dictionary::find()->select('message, message_id')->where('language_id = '.$language->id);	
			$query->leftJoin(['message'.$language->id => $subQuery], 'message'.$language->id.'.message_id = tr_message.id');					
		}

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
		
		$dataProvider->sort->attributes['category.name'] = [
			  'asc' => ['cms_page.name' => SORT_ASC],
			  'desc' => ['cms_page.name' => SORT_DESC],
		 ];
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
		
		
        $query->andFilterWhere([
            'id' => $this->id,
            'category_id' => $this->category_id,
        ]);
		
        $query->andFilterWhere(['like', 'code', $this->code]);
		foreach($languages as $language){				
			$query->andFilterWhere(['like', 'message'.$language->id.'.message',  $this->getAttribute('message'.$language->id)]);			
		}
		$query->andWhere(['or', ['like','cms_page.name', $this->getAttribute('category.name')], ['like','cms_page.id', $this->getAttribute('category.name')] ]);	
        return $dataProvider;
    }
}

