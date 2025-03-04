<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ButtonSearch represents the model behind the search form about `backend\models\Button`.
 */
class ButtonSearch extends Button
{
    public $residentName;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'resident_id'], 'integer'],
            [['created_at', 'residentName'], 'safe'],
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
        $query = Button::find();
        $query->joinWith('resident');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['created_at'=>SORT_DESC]]
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'id',
                'resident_id',
                'created_at',
                'residentName' => [
                    'asc' => ['resident.firstname' => SORT_ASC, 'resident.lastname' => SORT_ASC],
                    'desc' => ['resident.firstname' => SORT_DESC, 'resident.lastname' => SORT_DESC],
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
            'id' => $this->id,
            'resident_id' => $this->resident_id,
            'created_at' => $this->created_at,
        ]);

        $query->andWhere('concat(resident.firstname, \' \', resident.lastname) LIKE "%'.$this->residentName.'%"');

        return $dataProvider;
    }
}
