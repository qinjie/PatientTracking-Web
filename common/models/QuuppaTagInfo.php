<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "quuppa_tag_info".
 *
 * @property string $id
 * @property string $tagId
 * @property string $name
 * @property string $color
 * @property string $lastPacketTS
 * @property string $acceleration
 * @property string $accelerationTS
 * @property string $batteryVoltage
 * @property string $batteryVoltageTS
 * @property string $batteryAlarm
 * @property string $batteryAlarmTS
 * @property string $buttonState
 * @property string $buttonStateTS
 * @property string $tagState
 * @property string $tagStateTS
 * @property string $tagStateTransitionStatus
 * @property string $tagStateTransitionStatusTS
 * @property string $triggerCount
 * @property string $triggerCountTS
 * @property string $ioStates
 * @property string $ioStatesTS
 * @property string $rssi
 * @property string $rssiLocator
 * @property string $rssiLocatorCoords
 * @property string $rssiCoordinateSystemId
 * @property string $rssiCoordinateSystemName
 * @property string $rssiTS
 * @property string $txRate
 * @property string $txRateTS
 * @property string $txPower
 * @property string $txPowerTS
 * @property string $lastAreaId
 * @property string $lastAreaName
 * @property string $lastAreaTS
 * @property string $zones
 * @property string $custom
 * @property string $customTS
 * @property integer $accelerationX
 * @property integer $accelerationY
 * @property integer $accelerationZ
 * @property string $rssiLocatorCoordX
 * @property string $rssiLocatorCoordY
 * @property string $rssiLocatorCoordZ
 * @property string $created_at
 */
class QuuppaTagInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quuppa_tag_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lastPacketTS', 'accelerationTS', 'batteryVoltageTS', 'batteryAlarmTS', 'buttonStateTS', 'tagStateTS', 'tagStateTransitionStatusTS', 'triggerCount', 'triggerCountTS', 'ioStatesTS', 'rssi', 'rssiTS', 'txRate', 'txRateTS', 'txPowerTS', 'lastAreaTS', 'customTS', 'accelerationX', 'accelerationY', 'accelerationZ'], 'integer'],
            [['batteryVoltage', 'txPower', 'rssiLocatorCoordX', 'rssiLocatorCoordY', 'rssiLocatorCoordZ'], 'number'],
            [['created_at'], 'safe'],
            [['tagId', 'rssiLocator', 'rssiCoordinateSystemId', 'lastAreaId'], 'string', 'max' => 25],
            [['name', 'acceleration', 'ioStates', 'rssiLocatorCoords', 'rssiCoordinateSystemName', 'lastAreaName'], 'string', 'max' => 50],
            [['color', 'buttonState', 'custom'], 'string', 'max' => 10],
            [['batteryAlarm'], 'string', 'max' => 5],
            [['tagState', 'tagStateTransitionStatus'], 'string', 'max' => 20],
            [['zones'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tagId' => 'Tag ID',
            'name' => 'Name',
            'color' => 'Color',
            'lastPacketTS' => 'Last Packet Ts',
            'acceleration' => 'Acceleration',
            'accelerationTS' => 'Acceleration Ts',
            'batteryVoltage' => 'Battery Voltage',
            'batteryVoltageTS' => 'Battery Voltage Ts',
            'batteryAlarm' => 'Battery Alarm',
            'batteryAlarmTS' => 'Battery Alarm Ts',
            'buttonState' => 'Button State',
            'buttonStateTS' => 'Button State Ts',
            'tagState' => 'Tag State',
            'tagStateTS' => 'Tag State Ts',
            'tagStateTransitionStatus' => 'Tag State Transition Status',
            'tagStateTransitionStatusTS' => 'Tag State Transition Status Ts',
            'triggerCount' => 'Trigger Count',
            'triggerCountTS' => 'Trigger Count Ts',
            'ioStates' => 'Io States',
            'ioStatesTS' => 'Io States Ts',
            'rssi' => 'Rssi',
            'rssiLocator' => 'Rssi Locator',
            'rssiLocatorCoords' => 'Rssi Locator Coords',
            'rssiCoordinateSystemId' => 'Rssi Coordinate System ID',
            'rssiCoordinateSystemName' => 'Rssi Coordinate System Name',
            'rssiTS' => 'Rssi Ts',
            'txRate' => 'Tx Rate',
            'txRateTS' => 'Tx Rate Ts',
            'txPower' => 'Tx Power',
            'txPowerTS' => 'Tx Power Ts',
            'lastAreaId' => 'Last Area ID',
            'lastAreaName' => 'Last Area Name',
            'lastAreaTS' => 'Last Area Ts',
            'zones' => 'Zones',
            'custom' => 'Custom',
            'customTS' => 'Custom Ts',
            'accelerationX' => 'Acceleration X',
            'accelerationY' => 'Acceleration Y',
            'accelerationZ' => 'Acceleration Z',
            'rssiLocatorCoordX' => 'Rssi Locator Coord X',
            'rssiLocatorCoordY' => 'Rssi Locator Coord Y',
            'rssiLocatorCoordZ' => 'Rssi Locator Coord Z',
            'created_at' => 'Created At',
        ];
    }
}
