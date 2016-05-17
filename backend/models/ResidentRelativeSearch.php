<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ResidentRelative;

/**
 * ResidentRelativeSearch represents the model behind the search form about `backend\models\ResidentRelative`.
 */
class ResidentRelativeSearch extends ResidentRelative
{
    public $residentName;
    public $nextofkinName;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['relation', 'created_at', 'updated_at', 'residentName', 'nextofkinName', 'resident_id', 'nextofkin_id'], 'safe'],
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
        $query = ResidentRelative::find();

        $query->joinWith('resident');

        $query->joinWith('nextofkin');

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
                ],
                'nextofkin_id' => [
                    'asc' => ['Nextofkin.first_name' => SORT_ASC, 'Nextofkin.last_name' => SORT_ASC],
                    'desc' => ['Nextofkin.first_name' => SORT_DESC, 'Nextofkin.last_name' => SORT_DESC],
                ],
                'relation',
                'created_at',
                'updated_at',
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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'relation', $this->relation]);
        $query->andWhere('concat(firstname, \' \', lastname) LIKE "%'.$this->resident_id.'%"')
              ->andWhere('concat(first_name, \' \', last_name) LIKE "%'.$this->nextofkin_id.'%"');
        return $dataProvider;
    }
}
