<?php

namespace backend\modules\ir\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Incidentreport;

/**
 * IncidentreportSearch represents the model behind the search form of `common\models\Incidentreport`.
 */
class IncidentreportSearch extends Incidentreport
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['irID', 'riskDate', 'riskTime', 'location', 'HN', 'AN', 'staff', 'position', 'tel', 'issue', 'detail', 'repairable', 'result', 'recomment', 'created_at', 'updated_at', 'status'], 'safe'],
            [['sufID', 'infromID', 'levelID', 'created_by', 'updated_by'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Incidentreport::find();

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
            'riskDate' => $this->riskDate,
            'riskTime' => $this->riskTime,
            'sufID' => $this->sufID,
            'infromID' => $this->infromID,
            'levelID' => $this->levelID,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'irID', $this->irID])
            ->andFilterWhere(['like', 'location', $this->location])
            ->andFilterWhere(['like', 'HN', $this->HN])
            ->andFilterWhere(['like', 'AN', $this->AN])
            ->andFilterWhere(['like', 'staff', $this->staff])
            ->andFilterWhere(['like', 'position', $this->position])
            ->andFilterWhere(['like', 'tel', $this->tel])
            ->andFilterWhere(['like', 'issue', $this->issue])
            ->andFilterWhere(['like', 'detail', $this->detail])
            ->andFilterWhere(['like', 'repairable', $this->repairable])
            ->andFilterWhere(['like', 'result', $this->result])
            ->andFilterWhere(['like', 'recomment', $this->recomment])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
