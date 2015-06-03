<?php

namespace common\modules\cms\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\cms\models\CmsPosts;

/**
 * CmsPosts_search represents the model behind the search form about `common\modules\page\models\CmsPosts`.
 */
class CmsPosts_search extends CmsPosts
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'lang_id', 'post_author', 'post_status', 'post_type'], 'integer'],
            [['post_content', 'post_title', 'date_created', 'date_updated'], 'safe'],
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
        $query = CmsPosts::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'lang_id' => $this->lang_id,
            'post_author' => $this->post_author,
            'post_status' => $this->post_status,
            'date_created' => $this->date_created,
            'date_updated' => $this->date_updated,
            'post_type' => $this->post_type,
        ]);

        $query->andFilterWhere(['like', 'post_content', $this->post_content])
            ->andFilterWhere(['like', 'post_title', $this->post_title]);

        return $dataProvider;
    }
}
