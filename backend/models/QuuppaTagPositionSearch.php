<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\QuuppaTagPosition;

/**
 * QuuppaTagPositionSearch represents the model behind the search form about `backend\models\QuuppaTagPosition`.
 */
class QuuppaTagPositionSearch extends QuuppaTagPosition
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'positionTS'], 'integer'],
            [['tagId', 'name', 'color', 'position', 'smoothedPosition', 'areaId', 'areaName', 'zones', 'coordinateSystemId', 'coordinateSystemName', 'covarianceMatrix', 'created_at'], 'safe'],
            [['positionAccuracy', 'positionX', 'positionY', 'positionZ', 'smoothedPositionX', 'smoothedPositionY', 'smoothedPositionZ'], 'number'],
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
        $query = QuuppaTagPosition::find();

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
            'positionTS' => $this->positionTS,
            'positionAccuracy' => $this->positionAccuracy,
            'positionX' => $this->positionX,
            'positionY' => $this->positionY,
            'positionZ' => $this->positionZ,
            'smoothedPositionX' => $this->smoothedPositionX,
            'smoothedPositionY' => $this->smoothedPositionY,
            'smoothedPositionZ' => $this->smoothedPositionZ,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'tagId', $this->tagId])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'color', $this->color])
            ->andFilterWhere(['like', 'position', $this->position])
            ->andFilterWhere(['like', 'smoothedPosition', $this->smoothedPosition])
            ->andFilterWhere(['like', 'areaId', $this->areaId])
            ->andFilterWhere(['like', 'areaName', $this->areaName])
            ->andFilterWhere(['like', 'zones', $this->zones])
            ->andFilterWhere(['like', 'coordinateSystemId', $this->coordinateSystemId])
            ->andFilterWhere(['like', 'coordinateSystemName', $this->coordinateSystemName])
            ->andFilterWhere(['like', 'covarianceMatrix', $this->covarianceMatrix]);

        return $dataProvider;
    }
}
