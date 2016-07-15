<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Tag;

/**
 * TagSearch represents the model behind the search form about `backend\models\Tag`.
 */
class TagSearch extends Tag
{
    public $residentName;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['label', 'tagid', 'created_at', 'updated_at', 'residentName', 'resident_id'], 'safe'],
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
        $query = Tag::find();

        $query->joinWith('resident');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'attributes' =>[
                'id',
                'label',
                'tagid',
                'status',
                'resident_id' => [
                    'asc' => ['Resident.firstname' => SORT_ASC, 'Resident.lastname' => SORT_ASC],
                    'desc' => ['Resident.firstname' => SORT_DESC, 'Resident.lastname' => SORT_DESC],
                ],
            ],
            'defaultOrder' => ['id'=>SORT_ASC],
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
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'label', $this->label])
            ->andFilterWhere(['like', 'tagid', $this->tagid]);

        $query->andWhere('concat(firstname, \' \', lastname) LIKE "%'.$this->resident_id.'%"');



        return $dataProvider;
    }
}
