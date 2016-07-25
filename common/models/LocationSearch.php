<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * LocationSearch represents the model behind the search form about `backend\models\Location`.
 */
class LocationSearch extends Location
{
    public $residentName;
    public $floorName;
    public $residentGender;
    public $residentBirthday;
    public $outsideName;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'outside'], 'integer'],
            [['coorx', 'coory', 'azimuth', 'speed'], 'number'],
            [['created_at', 'resident_id', 'floor_id', 'residentName', 'floorName', 'residentGender', 'residentBirthday', 'zone', 'outsideName', 'user_id', 'userName'], 'safe'],
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
        $query = Location::find();

        $query->joinWith('resident');

        $query->joinWith('floor');

        $query->joinWith('user');

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
                'user_id' => [
                    'asc' => ['User.username' => SORT_ASC],
                    'desc' => ['User.username' => SORT_DESC],
                    'default' => SORT_ASC
                ],
                'floor_id' => [
                    'asc' => ['Floor.label' => SORT_ASC],
                    'desc' => ['Floor.label' => SORT_DESC],
                    'default' => SORT_ASC
                ],
                'coorx',
                'coory',
                'zone',
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
        $query->andWhere('(concat(firstname, \' \', lastname) LIKE "%'.$this->resident_id.'%" or "'.$this->resident_id.'" = "")')
            ->andFilterWhere(['like', 'username', $this->user_id])
            ->andFilterWhere(['like', 'zone', $this->zone])
            ->andFilterWhere(['like', 'Floor.label', $this->floor_id]);
        return $dataProvider;
    }

    public function searchFloor($params, $fid){
        $query = Location::find();
        $query->andWhere('floor_id = '.$fid.'
        and (outside = 0) and (location.created_at between DATE_SUB(NOW(), INTERVAL '.Yii::$app->params['locationTimeOut'].' second) and NOW())');
        $query->joinWith('resident');
        $query->joinWith('floor');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->setSort([
            'attributes' =>[
                'id',
                'residentName' => [
                    'asc' => ['firstname' => SORT_ASC, 'lastname' => SORT_ASC],
                    'desc' => ['firstname' => SORT_DESC, 'lastname' => SORT_DESC],
                    'default' => SORT_ASC
                ],
                'residentGender' => [
                    'asc' => ['resident.gender' => SORT_ASC],
                    'desc' => ['resident.gender' => SORT_DESC],
                    'default' => SORT_ASC
                ],
                'residentBirthday' => [
                    'asc' => ['resident.birthday' => SORT_ASC],
                    'desc' => ['resident.birthday' => SORT_DESC],
                    'default' => SORT_ASC
                ],
                'floorName' => [
                    'asc' => ['Floor.label' => SORT_ASC],
                    'desc' => ['Floor.label' => SORT_DESC],
                    'default' => SORT_ASC
                ],
                'coorx',
                'coory',
                'speed',
                'azimuth',
                'outside',
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
            'created_at' => $this->created_at,
        ]);
        $query
            ->andFilterWhere(['like', 'floor.label', $this->floorName])
            ->andFilterWhere(['like', 'resident.gender', $this->residentGender])
            ->andFilterWhere(['like', 'resident.birthday', $this->residentBirthday])
            ->andFilterWhere(['like', 'coorx', $this->coorx])
            ->andFilterWhere(['like', 'coory', $this->coory])
            ->andFilterWhere(['like', 'speed', $this->speed])
            ->andFilterWhere(['like', 'azimuth', $this->azimuth])
            ->andFilterWhere(['like', 'zone', $this->zone])
            ->andWhere('concat(firstname, \' \', lastname) LIKE "%'.$this->residentName.'%"');

        return $dataProvider;
    }

    //outside = 0: inside a ward; outside = 1: outside a ward, inside lobby; outside = 2: no signal

    public function searchAlert($params){
        $query = Location::find();
        $query->andWhere('(outside != 0) or (location.created_at not between DATE_SUB(NOW(), INTERVAL '.Yii::$app->params['locationTimeOut'].' second) and NOW())');
        $query->joinWith('resident');
        $query->joinWith('floor');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->setSort([
            'attributes' =>[
                'id',
                'residentName' => [
                    'asc' => ['firstname' => SORT_ASC, 'lastname' => SORT_ASC],
                    'desc' => ['firstname' => SORT_DESC, 'lastname' => SORT_DESC],
                    'default' => SORT_ASC
                ],
                'residentGender' => [
                    'asc' => ['resident.gender' => SORT_ASC],
                    'desc' => ['resident.gender' => SORT_DESC],
                    'default' => SORT_ASC
                ],
                'residentBirthday' => [
                    'asc' => ['resident.birthday' => SORT_ASC],
                    'desc' => ['resident.birthday' => SORT_DESC],
                    'default' => SORT_ASC
                ],
                'floorName' => [
                    'asc' => ['Floor.label' => SORT_ASC],
                    'desc' => ['Floor.label' => SORT_DESC],
                    'default' => SORT_ASC
                ],
                'type',
                'outside',
                'coorx',
                'coory',
                'speed',
                'azimuth',
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
            'outside' => $this->outside,
            'created_at' => $this->created_at,
        ]);
        $query
            ->andFilterWhere(['like', 'floor.label', $this->floorName])
            ->andFilterWhere(['like', 'resident.gender', $this->residentGender])
            ->andFilterWhere(['like', 'resident.birthday', $this->residentBirthday])
            ->andFilterWhere(['like', 'coorx', $this->coorx])
            ->andFilterWhere(['like', 'coory', $this->coory])
            ->andFilterWhere(['like', 'speed', $this->speed])
            ->andFilterWhere(['like', 'zone', $this->zone])
            ->andFilterWhere(['like', 'azimuth', $this->azimuth])
            ->andWhere('concat(firstname, \' \', lastname) LIKE "%'.$this->residentName.'%"');

        return $dataProvider;
    }
}
