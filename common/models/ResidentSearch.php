<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ResidentSearch represents the model behind the search form about `backend\models\Resident`.
 */
class ResidentSearch extends Resident
{
    public $fullName;
    public $coorx;
    public $coory;
    public $lastTime;
    public $speed;
    public $azimuth;
    public $lastFloor;
    public $lastFloorId;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['firstname', 'lastname', 'nric', 'gender', 'birthday', 'contact', 'remark', 'created_at', 'updated_at', 'fullName', 'coorx', 'coory', 'speed', 'azimuth', 'lastFloorId'], 'safe'],
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
        $query = Resident::find();
        // add conditions that should always apply here
        //filter by floor
        $query->joinWith('location');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'id',
                'firstname',
                'lastname',
                'nric',
                'lastFloorId' =>[
                    'asc' => ['location.floor_id' => SORT_ASC],
                    'desc' => ['location.floor_id' => SORT_DESC],
                ],
                'gender',
                'birthday',
                'contact',
                'remark',
                'created_at',
                'updated_at',
                'fullName' => [
                    'asc' => ['firstname' => SORT_ASC, 'lastname' => SORT_ASC],
                    'desc' => ['firstname' => SORT_DESC, 'lastname' => SORT_DESC],
                    'default' => SORT_ASC
                ],
                'coorx' => [
                    'asc' => ['location.coorx' => SORT_ASC],
                    'desc' => ['location.coorx' => SORT_DESC],
                ],
                'coory' => [
                    'asc' => ['location.coory' => SORT_ASC],
                    'desc' => ['location.coory' => SORT_DESC],
                ],
                'speed' => [
                    'asc' => ['location.speed' => SORT_ASC],
                    'desc' => ['location.speed' => SORT_DESC],
                ],
                'azimuth' => [
                    'asc' => ['location.azimuth' => SORT_ASC],
                    'desc' => ['location.azimuth' => SORT_DESC],
                ],
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
            'birthday' => $this->birthday,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'azimuth' => $this->azimuth,
            'coorx' => $this->coorx,
            'coory' => $this->coory,
            'speed' => $this->speed,
            'location.floor_id' => $this->lastFloorId,
        ]);
        $query
            ->andFilterWhere(['like', 'firstname', $this->firstname])
            ->andFilterWhere(['like', 'lastname', $this->lastname])
            ->andFilterWhere(['like', 'nric', $this->nric])
            ->andFilterWhere(['like', 'gender', $this->gender])
            ->andFilterWhere(['like', 'contact', $this->contact])
            ->andFilterWhere(['like', 'remark', $this->remark])
            ->andWhere('concat(firstname, \' \', lastname) LIKE "%'.$this->fullName.'%"');
        return $dataProvider;
    }
}
