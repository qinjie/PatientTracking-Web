<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ResidentLocation;

/**
 * ResidentLocationSearch represents the model behind the search form about `backend\models\ResidentLocation`.
 */
class ResidentLocationSearch extends ResidentLocation
{
    public $residentName;
    public $floorName;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'outside'], 'integer'],
            [['coorx', 'coory', 'azimuth', 'speed'], 'number'],
            [['created_at', 'resident_id', 'floor_id', 'residentName', 'floorName'], 'safe'],
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
        $query = ResidentLocation::find();

        $query->joinWith('resident');

        $query->joinWith('floor');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->setSort([
            'attributes' =>[
                'id',
                'resident_id' => [
                    'asc' => ['Resident.firstname' => SORT_ASC, 'Resident.lastname' => SORT_ASC],
                    'desc' => ['Resident.firstname' => SORT_DESC, 'Resident.lastname' => SORT_DESC],
                    'default' => SORT_ASC
                ],
                'floor_id' => [
                    'asc' => ['Floor.label' => SORT_ASC],
                    'desc' => ['Floor.label' => SORT_DESC],
                    'default' => SORT_ASC
                ],
                'coorx',
                'coory',
                'outside',
                'azimuth',
                'speed',
                'created_at',
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
            'resident.id' => $this->id,
            'coorx' => $this->coorx,
            'coory' => $this->coory,
            'outside' => $this->outside,
            'azimuth' => $this->azimuth,
            'speed' => $this->speed,
            'created_at' => $this->created_at,
        ]);
        $query->andWhere('concat(firstname, \' \', lastname) LIKE "%'.$this->resident_id.'%"')
            ->andFilterWhere(['like', 'Floor.label', $this->floor_id]);
        return $dataProvider;
    }
}
