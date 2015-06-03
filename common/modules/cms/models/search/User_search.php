<?php

namespace common\modules\cms\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

use common\modules\cms\models\User as UserModel;

/**
 * User represents the model behind the search form about `\common\models\User`.
 */
class User_search extends UserModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['username', 'email','authassignment.itemName.description'], 'safe'],
        ];
    }

	public function attributes()
	{		
		return array_merge(parent::attributes(), ['authassignment.itemName.description']);
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
        $query = UserModel::find()->joinWith('authassignment.itemName');	
		
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,         
            'status' => $this->status,         
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'email', $this->email])
			->andFilterWhere(['like', 'auth_item.name', $this->getAttribute('authassignment.itemName.description')]);
           
        return $dataProvider;
    }
}
