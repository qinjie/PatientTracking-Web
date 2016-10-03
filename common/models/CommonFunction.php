<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 25/4/16
 * Time: 10:50 AM
 */

namespace common\models;

use backend\models\AlertArea;
use backend\models\Button;
use backend\models\ButtonHistory;
use backend\models\Floor;
use backend\models\FloorManager;
use backend\models\FloorMap;
use backend\models\Marker;
use backend\models\LocationHistory;
use backend\models\Tag;
use Yii;


class CommonFunction extends \yii\db\ActiveRecord
{
    //get all floor model
    public function getAllFloor(){
        $query = Floor::find()->all();
        return $query;
    }

    //delete marker
    public function deleteFloorMap($id){
        Yii::$app->db->createCommand('DELETE FROM marker WHERE floor_id = (SELECT floor_id FROM floor_map WHERE id = '.$id.')')->execute();
        Yii::$app->db->createCommand('DELETE FROM alert_area WHERE floor_id = (SELECT floor_id FROM floor_map WHERE id = '.$id.')')->execute();
        $query = FloorMap::find()->where(['id' => $id])->one();
        if (file_exists($filePath = $query['file_path'])){
            unlink($query['file_path']);
        }
        if (file_exists($filePath = $query['thumbnail_path'])){
            unlink($query['thumbnail_path']);
        }
        return true;
    }

    //get Coordinate of Floor_id
    public function getCoordinate($id){
        $query = Yii::$app->db->createCommand('SELECT pixelx, pixely FROM marker where floor_id = '.$id.' order by position ASC ')->queryAll();
        return $query;
    }

    //get Coordinate alert of Floor_id
    public function getCoordinateAlert($id){
        $query = Yii::$app->db->createCommand('SELECT pixelx, pixely FROM alert_area where floor_id = '.$id.' order by position ASC ')->queryAll();
        return $query;
    }

    //get Thumbnail Path by Floor_id
    public function getThumbnailPath($id){
        $query = FloorMap::find()->where(['floor_id' => $id])->one();
        return $query['thumbnail_path'];
    }

    //check image exist
    public function checkImageExist($id){
        $query = FloorMap::find()->where(['floor_id' => $id])->one();
        if ($query) return true;
        return false;
    }

    //get image Path by Floor_id
    public function getImgPath($id){
        $query = FloorMap::find()->where(['floor_id' => $id])->one();
        if ($query){
            return $query['file_path'];
        }
        else{
            return "na.png";
        }
    }

    //get number of resident in floor $id
    public function getResidentCount($id){
        $query = Yii::$app->db->createCommand('
            select count(id) as cnt
            from location
            where resident_id is not NULL and floor_id = '.$id.' and resident_id not in (SELECT resident_id FROM notification WHERE user_id IS NULL)
        ')->queryAll();
        return $query[0]["cnt"];
    }

    //get number of caregiver in floor $id
    public function getCaregiverCount($id){
        $query = Yii::$app->db->createCommand('
            select count(id) as cnt
            from location
            where user_id is not NULL and floor_id = '.$id.' and outside = 0
            and created_at > DATE_SUB(NOW(), INTERVAL '.Yii::$app->params['locationTimeOut'].' second)
        ')->queryAll();
        return $query[0]["cnt"];
    }

    //get number of resident who is out of range
    public function getAlertCount(){
        $query = Yii::$app->db->createCommand('
            select count(id) as cnt
            from location
            where resident_id in (SELECT resident_id FROM notification WHERE user_id IS NULL)
        ')->queryAll();
        return $query[0]["cnt"];
    }

    //get floor name by $id
    public function getFloorName($id){
        $query = Floor::find()->where(['id' => $id])->one();
        return $query['label'];
    }

    //get all resident in floor $id
    public function getResidentInFloor($id){
        $query = Location::find()->where(['floor_id' => $id])->all();
        return $query;
    }

    //get resident by $id
    public function getResident($id){
        $query = Resident::find()->where(['id' => $id])->one();
        return $query;
    }

    //get resident model by $id
    public function getResidentModel($id){
        $query = Resident::findOne(['id' => $id]);
        return $query;
    }

    //get resident name by $id
    public function getResidentName($id){
        $query = Resident::find()->where(['id' => $id])->one();
        return $query['firstname']." ".$query['lastname'];
    }

    //get next-of-kin list by resident $id and/or floor $fid
    public function getNextofkinList($id, $fid = null){
        $query = ResidentRelative::find()->where(['resident_id' => $id])->all();
        $str = "";
        if ($fid == null){
            foreach ($query as $item){
                $tmp = Nextofkin::find()->where(['id' => $item['nextofkin_id']])->one();
                if ($str == ""){
                    $str .=  "".$item['relation'].": <a href='".Yii::$app->homeUrl."nextofkin/view?id=".$tmp['id']."'>".$tmp['full_Name']."</a>";
                } else{
                    $str .= "<br>".$item['relation'].": <a href='".Yii::$app->homeUrl."nextofkin/view?id=".$tmp['id']."'>".$tmp['full_Name']."</a>";
                }
            }
        }
        else{
            foreach ($query as $item){
                $tmp = Nextofkin::find()->where(['id' => $item['nextofkin_id']])->one();
                if ($str == ""){
                    $str .= "".$item['relation'].": <a href='".Yii::$app->homeUrl."dashboard/nextofkindetail?id=".$tmp['id']."&fid=".$fid."&rid=".$id."'>".$tmp['first_name']." ".$tmp['last_name']."</a>";
                } else{
                    $str .= "<br>".$item['relation'].": <a href='".Yii::$app->homeUrl."dashboard/nextofkindetail?id=".$tmp['id']."&fid=".$fid."&rid=".$id."'>".$tmp['first_name']." ".$tmp['last_name']."</a>";
                }
            }
        }
        if ($str == null){
            return "";
        }
        return $str;
    }

    //get next-of-kin name by $id
    public function getNextofkinName($id){
        $query = Nextofkin::find()->where(['id' => $id])->one();
        return $query['first_name']." ".$query['last_name'];
    }

    //get next-of-kin model by $id
    public function getNextofkinModel($id){
        $query = Nextofkin::findOne(['id' => $id]);
        return $query;
    }

    //get resident list by next-of-kin $id
    public function getResidentList($id){
        $query = ResidentRelative::find()->where(['nextofkin_id' => $id])->all();
        $str = "";
        foreach ($query as $item){
            $tmp = Resident::find()->where(['id' => $item['resident_id']])->one();
            if ($str == ""){
                $str .= "".$item['relation']." of: <a href='".Yii::$app->homeUrl."resident/view?id=".$tmp['id']."'>".$tmp['fullName']."</a>";
            }
            else{
                $str .= "<br>".$item['relation']." of: <a href='".Yii::$app->homeUrl."resident/view?id=".$tmp['id']."'>".$tmp['fullName']."</a>";
            }
        }
        if ($str == null){
            return "";
        }
        return $str;
    }

    //GET INDEX INFO

    //get count resident
    public function getResidentNumber(){
        $query = Resident::find()->count();
        return $query;
    }

    //get count next-of-kin
    public function getNextofkinNumber(){
        $query = Nextofkin::find()->count();
        return $query;
    }

    //get count resident relative
    public function getResidentRelativeNumber(){
        $query = ResidentRelative::find()->count();
        return $query;
    }

    //get count user
    public function getUserNumber(){
        $query = User::find()->count();
        return $query;
    }

    //get count location
    public function getLocationNumber(){
        $query = Location::find()->count();
        return $query;
    }

    //get count tag
    public function getTagNumber(){
        $query = Tag::find()->count();
        return $query;
    }

    //get count location history
    public function getLocationHistoryNumber(){
        $query = LocationHistory::find()->count();
        return $query;
    }

    //get count floor
    public function getFloorNumber(){
        $query = Floor::find()->count();
        return $query;
    }

    //get count floor map
    public function getFloorMapNumber(){
        $query = FloorMap::find()->count();
        return $query;
    }

    //get count marker
    public function getMarkerNumber(){
        $query = Marker::find()->count();
        return $query;
    }

    //get count floor manager
    public function getFloorManagerNumber(){
        $query = FloorManager::find()->count();
        return $query;
    }

    //get count alert area
    public function getAlertAreaNumber(){
        $query = AlertArea::find()->count();
        return $query;
    }

    //get count button
    public function getButtonNumber(){
        $query = Button::find()->count();
        return $query;
    }

    //get count button history
    public function getButtonHistoryNumber(){
        $query = ButtonHistory::find()->count();
        return $query;
    }

    //calculate pixel coordinate from real coordinate
    public function getResidentPixel($floor_id)
    {
        $topPixel = Marker::find()->where(['floor_id' => $floor_id])->min('pixely');
        $botPixel = Marker::find()->where(['floor_id' => $floor_id])->max('pixely');
        $rightPixel = Marker::find()->where(['floor_id' => $floor_id])->max('pixelx');
        $leftPixel = Marker::find()->where(['floor_id' => $floor_id])->min('pixelx');
        $topCoor = Marker::find()->where(['floor_id' => $floor_id])->max('coory');
        $botCoor = Marker::find()->where(['floor_id' => $floor_id])->min('coory');
        $rightCoor = Marker::find()->where(['floor_id' => $floor_id])->max('coorx');
        $leftCoor = Marker::find()->where(['floor_id' => $floor_id])->min('coorx');
        $query = (new \yii\db\Query())
            ->select('*')
            ->from('location')
            ->where(['floor_id' => $floor_id])
            ->andWhere('resident_id IS NOT NULL')
            ->all();
        for ($i = 0; $i < count($query); $i++) {
            if ($query[$i]['resident_id']){
                $query[$i]['resident'] = $this->ResidentDetail($query[$i]['resident_id']);
                $query[$i]['color'] = $this->ResidentColor($query[$i]['resident_id']);
                $query[$i]['signal'] = $this->ResidentSignal($query[$i]['resident_id']);
            }
            $query[$i]['pixelx'] = $leftPixel + intval(round(1.0 * ($query[$i]['coorx'] - $leftCoor) * ($rightPixel - $leftPixel) / ($rightCoor - $leftCoor)));
            $query[$i]['pixely'] = $topPixel + intval(round(1.0 * ($query[$i]['coory'] - $topCoor) * ($topPixel - $botPixel) / ($topCoor - $botCoor)));
        }
        return $query;
    }

    //calculate pixel coordinate from real coordinate
    public function getUserPixel($floor_id)
    {
        $topPixel = Marker::find()->where(['floor_id' => $floor_id])->min('pixely');
        $botPixel = Marker::find()->where(['floor_id' => $floor_id])->max('pixely');
        $rightPixel = Marker::find()->where(['floor_id' => $floor_id])->max('pixelx');
        $leftPixel = Marker::find()->where(['floor_id' => $floor_id])->min('pixelx');
        $topCoor = Marker::find()->where(['floor_id' => $floor_id])->max('coory');
        $botCoor = Marker::find()->where(['floor_id' => $floor_id])->min('coory');
        $rightCoor = Marker::find()->where(['floor_id' => $floor_id])->max('coorx');
        $leftCoor = Marker::find()->where(['floor_id' => $floor_id])->min('coorx');
        $query = (new \yii\db\Query())
            ->select('*')
            ->from('location')
            ->where(['floor_id' => $floor_id])
            ->andWhere('user_id IS NOT NULL')
            ->all();
        for ($i = 0; $i < count($query); $i++) {
            if ($query[$i]['user_id']){
                $query[$i]['user'] = $this->UserDetail($query[$i]['user_id']);
                //Color: Green
                $query[$i]['color'] = "#009688";
            }
            $query[$i]['pixelx'] = $leftPixel + intval(round(1.0 * ($query[$i]['coorx'] - $leftCoor) * ($rightPixel - $leftPixel) / ($rightCoor - $leftCoor)));
            $query[$i]['pixely'] = $topPixel + intval(round(1.0 * ($query[$i]['coory'] - $topCoor) * ($topPixel - $botPixel) / ($topCoor - $botCoor)));
        }
        return $query;
    }

    private function UserDetail($id){
        $query = Yii::$app->db->createCommand('SELECT * FROM User WHERE id = '.$id)->queryAll();
        return $query[0];
    }

    private function ResidentDetail($id){
        $query = Yii::$app->db->createCommand('SELECT * FROM Resident WHERE id = '.$id)->queryAll();
        return $query[0];
    }

    private function ResidentColor($id){
        if (Notification::find()->where(['resident_id' => $id, 'user_id' => null])->one()){
            //Color: Red
            return "#F44336";
        }
        //Color: Blue
        return "#2196F3";
    }

    private function ResidentSignal($id){
        if (Location::find()->where(['resident_id' => $id])->andWhere('created_at < DATE_SUB(NOW(), INTERVAL '.Yii::$app->params['locationTimeOut'].' second)')->one()){
            return false;
        }
        return true;
    }

    public function getNotification($id = null){
        if ($id){
            $result = (new \yii\db\Query())
                ->select(['notification.id', 'notification.resident_id', 'notification.type', 'resident.firstname'])
                ->from('notification')
                ->leftJoin('resident', 'notification.resident_id = resident.id')
                ->andWhere('notification.id > '.$id)
                ->orderBy('notification.id ASC')
                ->all();
            return $result;
        }
        else{
            return "";
        }
    }
}