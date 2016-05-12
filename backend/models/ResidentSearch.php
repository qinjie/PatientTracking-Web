<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Resident;

/**
 * ResidentSearch represents the model behind the search form about `backend\models\Resident`.
 */
class ResidentSearch extends Resident
{
    public $fullName;
    public $coorx;
    public $coory;
    public $speed;
    public $lastfloor;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['firstname', 'lastname', 'nric', 'gender', 'birthday', 'contact', 'remark', 'lastmodified', 'fullName'], 'safe'],
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

    public function search($params, $fid = null)
    {
        if ($fid != null){
            $query = Resident::find()->distinct();
            $query->joinWith('residentLocations')->andWhere('resident_id in
            (select r1.resident_id
            from resident_location as r1
            where r1.outside = 0 and floor_id = '.$fid.'
            and (r1.created_at between DATE_SUB(NOW(), INTERVAL 10 second) and NOW())
            and r1.created_at = (select max(r2.created_at) from resident_location as r2 where r1.resident_id = r2.resident_id))');
        } else{
            $query = Resident::find();
        }
        // add conditions that should always apply here
        //filter by floor
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'id',
                'firstname',
                'lastname',
                'nric',
                'gender',
                'birthday',
                'contact',
                'remark',
                'lastmodified',
                'fullName' => [
                    'asc' => ['firstname' => SORT_ASC, 'lastname' => SORT_ASC],
                    'desc' => ['firstname' => SORT_DESC, 'lastname' => SORT_DESC],
                    'label' => 'Full Name',
                    'default' => SORT_ASC
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
            'lastmodified' => $this->lastmodified,
            'resident_location.coorx' => $this->coorx,
            'resident_location.coory' => $this->coory,
            'resident_location.speed' => $this->speed,
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

    public function searchAlert($params)
    {
        $query = Resident::find()->distinct();
        $query->joinWith('residentLocations')->andWhere('
            resident_id in
            (select DISTINCT r1.resident_id
            from resident_location as r1
            where (r1.created_at between DATE_SUB(NOW(), INTERVAL 10 second) and NOW())
            and r1.outside != 0
            and r1.created_at = (select max(created_at) from resident_location as r2 where r1.resident_id = r2.resident_id))
            or resident_id in
            (select r1.resident_id
            from resident_location as r1
            where r1.resident_id in (select DISTINCT r2.resident_id from resident_location as r2)
            and r1.resident_id not in (select DISTINCT r3.resident_id from resident_location as r3
            where r3.created_at between DATE_SUB(NOW(), INTERVAL 10 second) and NOW())
            and r1.created_at = (select max(created_at) from resident_location as r2 where r1.resident_id = r2.resident_id)) 
        ');
        // add conditions that should always apply here
        //filter by floor
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'id',
                'firstname',
                'lastname',
                'nric',
                'gender',
                'birthday',
                'contact',
                'remark',
                'lastmodified',
                'fullName' => [
                    'asc' => ['firstname' => SORT_ASC, 'lastname' => SORT_ASC],
                    'desc' => ['firstname' => SORT_DESC, 'lastname' => SORT_DESC],
                    'default' => SORT_ASC
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
            'lastmodified' => $this->lastmodified,
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
