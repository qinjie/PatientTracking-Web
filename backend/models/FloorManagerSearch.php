<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\FloorManager;

/**
 * FloorManagerSearch represents the model behind the search form about `backend\models\FloorManager`.
 */
class FloorManagerSearch extends FloorManager
{
    public $userName;
    public $floorName;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['created_at', 'userid', 'floorid', 'userName', 'floorName'], 'safe'],
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
        $query = FloorManager::find();

        $query->joinWith('user');
        $query->joinWith('floor');


        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'attributes' =>[
                'id',
                'userid' => [
                    'asc' => ['User.username' => SORT_ASC],
                    'desc' => ['User.username' => SORT_DESC],
                ],
                'floorid' => [
                    'asc' => ['Floor.label' => SORT_ASC],
                    'desc' => ['Floor.label' => SORT_DESC],
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
        ]);
        $query->andFilterWhere(['like', 'floor.label', $this->floorid]);
        $query->andFilterWhere(['like', 'user.username', $this->userid]);

        return $dataProvider;
    }
}
