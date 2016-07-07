<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ResidentLocationHistory;

/**
 * ResidentLocationHistorySearch represents the model behind the search form about `backend\models\ResidentLocationHistory`.
 */
class ResidentLocationHistorySearch extends ResidentLocationHistory
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'resident_id', 'floor_id', 'outside'], 'integer'],
            [['tagid', 'zone', 'created_at'], 'safe'],
            [['coorx', 'coory', 'azimuth', 'speed'], 'number'],
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
        $query = ResidentLocationHistory::find();

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
            'id' => $this->id,
            'resident_id' => $this->resident_id,
            'floor_id' => $this->floor_id,
            'coorx' => $this->coorx,
            'coory' => $this->coory,
            'outside' => $this->outside,
            'azimuth' => $this->azimuth,
            'speed' => $this->speed,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'tagid', $this->tagid])
            ->andFilterWhere(['like', 'zone', $this->zone]);

        return $dataProvider;
    }
}
