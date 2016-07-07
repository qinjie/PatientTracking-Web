<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AlertArea;

/**
 * AlertAreaSearch represents the model behind the search form about `backend\models\AlertArea`.
 */
class AlertAreaSearch extends AlertArea
{
    public $floorName;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'floor_id', 'status'], 'integer'],
            [['quuppa_id', 'description', 'created_at', 'updated_at', 'floorName'], 'safe'],
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
        $query = AlertArea::find();

        $query->joinWith('floor');
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'attributes' =>[
                'id',
                'floorName' => [
                    'asc' => ['Floor.label' => SORT_ASC],
                    'desc' => ['Floor.label' => SORT_DESC],
                    'default' => SORT_ASC
                ],
                'status',
                'created_at',
                'updated_at',
                'quuppa_id',
                'description',
            ]
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
            'floor_id' => $this->floor_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'quuppa_id', $this->quuppa_id])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'floor.label', $this->floorName]);

        return $dataProvider;
    }
}
