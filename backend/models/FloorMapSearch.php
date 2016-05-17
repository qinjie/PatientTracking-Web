<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\FloorMap;

/**
 * FloorMapSearch represents the model behind the search form about `backend\models\FloorMap`.
 */
class FloorMapSearch extends FloorMap
{

    public $floorName;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['file_type', 'file_name', 'file_ext', 'file_path', 'thumbnail_path', 'created_at', 'updated_at', 'floorName', 'floor_id'], 'safe'],
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
        $query = FloorMap::find();
        
        $query->joinWith('floor');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'attributes' =>[
                'id',
                'floor_id' => [
                    'asc' => ['floor.label' => SORT_ASC],
                    'desc' => ['floor.label' => SORT_DESC],
                    'default' => SORT_ASC
                ],
                'file_type',
                'file_name',
                'file_ext',
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
            'floor_map.id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'file_type', $this->file_type])
            ->andFilterWhere(['like', 'file_name', $this->file_name])
            ->andFilterWhere(['like', 'file_ext', $this->file_ext])
            ->andFilterWhere(['like', 'file_path', $this->file_path])
            ->andFilterWhere(['like', 'thumbnail_path', $this->thumbnail_path])
            ->andWhere('label LIKE "%'.$this->floor_id.'%"');

        return $dataProvider;
    }
}
