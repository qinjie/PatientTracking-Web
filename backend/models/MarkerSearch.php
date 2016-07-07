<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * MarkerSearch represents the model behind the search form about `backend\models\Marker`.
 */
class MarkerSearch extends Marker
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'floor_id', 'position', 'pixelx', 'pixely'], 'integer'],
            [['label', 'mac', 'created_at', 'updated_at'], 'safe'],
            [['coorx', 'coory'], 'number'],
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
    public function search($params, $id = null)
    {
        if ($id == null){
            $query = Marker::find();
        }
        else{
            $query = Marker::find()->where(['floor_id' => $id]);
        }

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
            'floor_id' => $this->floor_id,
            'position' => $this->position,
            'pixelx' => $this->pixelx,
            'pixely' => $this->pixely,
            'coorx' => $this->coorx,
            'coory' => $this->coory,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'label', $this->label])
            ->andFilterWhere(['like', 'mac', $this->mac]);

        return $dataProvider;
    }
}
