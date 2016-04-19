<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\QuuppaTagInfo;

/**
 * QuuppaTagInfoSearch represents the model behind the search form about `backend\models\QuuppaTagInfo`.
 */
class QuuppaTagInfoSearch extends QuuppaTagInfo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'lastPacketTS', 'accelerationTS', 'batteryVoltageTS', 'batteryAlarmTS', 'buttonStateTS', 'tagStateTS', 'tagStateTransitionStatusTS', 'triggerCount', 'triggerCountTS', 'ioStatesTS', 'rssi', 'rssiTS', 'txRate', 'txRateTS', 'txPowerTS', 'lastAreaTS', 'customTS', 'accelerationX', 'accelerationY', 'accelerationZ'], 'integer'],
            [['tagId', 'name', 'color', 'acceleration', 'batteryAlarm', 'buttonState', 'tagState', 'tagStateTransitionStatus', 'ioStates', 'rssiLocator', 'rssiLocatorCoords', 'rssiCoordinateSystemId', 'rssiCoordinateSystemName', 'lastAreaId', 'lastAreaName', 'zones', 'custom', 'created_at'], 'safe'],
            [['batteryVoltage', 'txPower', 'rssiLocatorCoordX', 'rssiLocatorCoordY', 'rssiLocatorCoordZ'], 'number'],
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
        $query = QuuppaTagInfo::find();

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
            'lastPacketTS' => $this->lastPacketTS,
            'accelerationTS' => $this->accelerationTS,
            'batteryVoltage' => $this->batteryVoltage,
            'batteryVoltageTS' => $this->batteryVoltageTS,
            'batteryAlarmTS' => $this->batteryAlarmTS,
            'buttonStateTS' => $this->buttonStateTS,
            'tagStateTS' => $this->tagStateTS,
            'tagStateTransitionStatusTS' => $this->tagStateTransitionStatusTS,
            'triggerCount' => $this->triggerCount,
            'triggerCountTS' => $this->triggerCountTS,
            'ioStatesTS' => $this->ioStatesTS,
            'rssi' => $this->rssi,
            'rssiTS' => $this->rssiTS,
            'txRate' => $this->txRate,
            'txRateTS' => $this->txRateTS,
            'txPower' => $this->txPower,
            'txPowerTS' => $this->txPowerTS,
            'lastAreaTS' => $this->lastAreaTS,
            'customTS' => $this->customTS,
            'accelerationX' => $this->accelerationX,
            'accelerationY' => $this->accelerationY,
            'accelerationZ' => $this->accelerationZ,
            'rssiLocatorCoordX' => $this->rssiLocatorCoordX,
            'rssiLocatorCoordY' => $this->rssiLocatorCoordY,
            'rssiLocatorCoordZ' => $this->rssiLocatorCoordZ,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'tagId', $this->tagId])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'color', $this->color])
            ->andFilterWhere(['like', 'acceleration', $this->acceleration])
            ->andFilterWhere(['like', 'batteryAlarm', $this->batteryAlarm])
            ->andFilterWhere(['like', 'buttonState', $this->buttonState])
            ->andFilterWhere(['like', 'tagState', $this->tagState])
            ->andFilterWhere(['like', 'tagStateTransitionStatus', $this->tagStateTransitionStatus])
            ->andFilterWhere(['like', 'ioStates', $this->ioStates])
            ->andFilterWhere(['like', 'rssiLocator', $this->rssiLocator])
            ->andFilterWhere(['like', 'rssiLocatorCoords', $this->rssiLocatorCoords])
            ->andFilterWhere(['like', 'rssiCoordinateSystemId', $this->rssiCoordinateSystemId])
            ->andFilterWhere(['like', 'rssiCoordinateSystemName', $this->rssiCoordinateSystemName])
            ->andFilterWhere(['like', 'lastAreaId', $this->lastAreaId])
            ->andFilterWhere(['like', 'lastAreaName', $this->lastAreaName])
            ->andFilterWhere(['like', 'zones', $this->zones])
            ->andFilterWhere(['like', 'custom', $this->custom]);

        return $dataProvider;
    }
}
