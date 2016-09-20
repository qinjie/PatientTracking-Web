<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Notification;

/**
 * NotificationSearch represents the model behind the search form about `common\models\Notification`.
 */
class NotificationSearch extends Notification
{
    public $residentName;
    public $floorName;
    public $residentGender;
    public $residentBirthday;
    public $alertType;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'resident_id', 'last_position', 'user_id', 'type'], 'integer'],
            [['residentName', 'floorName', 'residentGender', 'residentBirthday', 'alertType', 'created_at', 'updated_at'], 'safe'],
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
        $query = Notification::find();

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
            'last_position' => $this->last_position,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'user_id' => $this->user_id,
            'type' => $this->type,
        ]);

        return $dataProvider;
    }
    public function searchAlert($params){
        $query = Notification::find()->andWhere('notification.created_at > DATE_SUB(NOW(), INTERVAL 300 second) OR user_id IS NULL');
        $query->joinWith('user');
        $query->joinWith('resident');
        $query->joinWith('floor');


        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'defaultOrder' => ['created_at'=>SORT_DESC],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        return $dataProvider;
    }

    public function searchAlertList($params){
        $query = Notification::find();
        $query->joinWith('user');
        $query->joinWith('resident');
        $query->joinWith('floor');


        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'defaultOrder' => ['created_at'=>SORT_DESC],
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
                    'asc' => ['floor.label' => SORT_ASC],
                    'desc' => ['floor.label' => SORT_DESC],
                    'default' => SORT_ASC
                ],
                'alertType' => [
                    'asc' => ['alertType' => SORT_ASC],
                    'desc' => ['alertType' => SORT_DESC],
                    'default' => SORT_ASC
                ],
                'created_at' => [
                    'asc' => ['created_at' => SORT_ASC],
                    'desc' => ['created_at' => SORT_DESC],
                    'default' => SORT_ASC
                ],
                'type',
                'last_position',
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
            'resident_id' => $this->resident_id,
            'last_position' => $this->last_position,
            'notification.created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'user_id' => $this->user_id,
            'type' => $this->type,
        ]);

        $query
            ->andFilterWhere(['like', 'floor.label', $this->floorName])
            ->andFilterWhere(['like', 'resident.gender', $this->residentGender])
            ->andFilterWhere(['like', 'resident.birthday', $this->residentBirthday])
            ->andWhere('concat(firstname, \' \', lastname) LIKE "%'.$this->residentName.'%"');


        return $dataProvider;
    }
}
