<?php

namespace backend\modules\personal\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Person;

/**
 * PersonSearch represents the model behind the search form of `common\models\Person`.
 */
class PersonSearch extends Person
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'Team_teamID'], 'integer'],
            [['firtname', 'lastname', 'photo'], 'safe'],
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
        $query = Person::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'user_id' => $this->user_id,
            'Team_teamID' => $this->Team_teamID,
        ]);

        $query->andFilterWhere(['like', 'firtname', $this->firtname])
            ->andFilterWhere(['like', 'lastname', $this->lastname])
            ->andFilterWhere(['like', 'photo', $this->photo]);

        return $dataProvider;
    }
}
