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
            and created_at between DATE_SUB(NOW(), INTERVAL '.Yii::$app->params['locationTimeOut'].' second) and NOW()
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
    public function getResidentPixel($floorid)
    {
        $result = (new \yii\db\Query())
            ->select(['pixelx', 'pixely', 'coorx', 'coory'])
            ->from('marker')
            ->where(['floor_id' => $floorid])
            ->all();

        $inf = 9223372036854775807;

        $topLeftPixelx = $inf; $topLeftCoorx = 0.0;
        $topLeftPixely = $inf; $topLeftCoory = 0.0;

        $bottomRightPixelx = -1; $bottomRightCoorx = 0.0;
        $bottomRightPixely = -1; $bottomRightCoory = 0.0;


        for($i = 0; $i < count($result); $i++)
        {
            if($result[$i]['pixelx'] < $topLeftPixelx)
            {
                $topLeftPixelx = $result[$i]['pixelx'];
                $topLeftCoorx = $result[$i]['coorx'];
            }
            if($result[$i]['pixely'] < $topLeftPixely)
            {
                $topLeftPixely = $result[$i]['pixely'];
                $topLeftCoory = $result[$i]['coory'];
            }

            if($result[$i]['pixelx'] > $bottomRightPixelx)
            {
                $bottomRightPixelx = $result[$i]['pixelx'];
                $bottomRightCoorx = $result[$i]['coorx'];
            }
            if($result[$i]['pixely'] > $bottomRightPixely)
            {
                $bottomRightPixely = $result[$i]['pixely'];
                $bottomRightCoory = $result[$i]['coory'];
            }
        }

        $res = Yii::$app->db
            ->createCommand('select r.id, r.firstname, l.coorx, l.coory
                            from resident as r, location as l
                            where r.id = l.resident_id
                            and (l.floor_id = '.$floorid.')')
            ->queryAll();

        $widthPixel = $bottomRightPixelx - $topLeftPixelx;
        $heightPixel = $bottomRightPixely - $topLeftPixely;
        $widthCoor = $bottomRightCoorx - $topLeftCoorx;
        $heightCoor = $bottomRightCoory - $topLeftCoory;

        for($i = 0; $i < count($res); $i++)
        {
            try
            {
                $res[$i]['pixelx'] = $topLeftPixelx + intval(round(1.0*($res[$i]['coorx'] - $topLeftCoorx)/$widthCoor*$widthPixel));
                $res[$i]['pixely'] = $topLeftPixely + intval(round(1.0*($res[$i]['coory'] - $topLeftCoory)/$heightCoor*$heightPixel));
                if (self::isAlerted($res[$i]['id'])) {
                    // set red color
                    $res[$i]['color'] = "RED";
                } else {
                    // set blue color
                    $res[$i]['color'] = "BLUE";
                }
                if (Location::find()->where(['resident_id' => $res[$i]['id'], 'tpye' => 3])->one()){
                    $res[$i]['outside'] = true;
                } else {
                    $res[$i]['outside'] = false;
                }
            }
            catch(\Exception $ex)
            {
                return [];
            }
        }
        return $res;
    }

    //calculate pixel coordinate from real coordinate
    public function getUserPixel($floorid)
    {
        $result = (new \yii\db\Query())
            ->select(['pixelx', 'pixely', 'coorx', 'coory'])
            ->from('marker')
            ->where(['floor_id' => $floorid])
            ->all();

        $inf = 9223372036854775807;

        $topLeftPixelx = $inf; $topLeftCoorx = 0.0;
        $topLeftPixely = $inf; $topLeftCoory = 0.0;

        $bottomRightPixelx = -1; $bottomRightCoorx = 0.0;
        $bottomRightPixely = -1; $bottomRightCoory = 0.0;


        for($i = 0; $i < count($result); $i++)
        {
            if($result[$i]['pixelx'] < $topLeftPixelx)
            {
                $topLeftPixelx = $result[$i]['pixelx'];
                $topLeftCoorx = $result[$i]['coorx'];
            }
            if($result[$i]['pixely'] < $topLeftPixely)
            {
                $topLeftPixely = $result[$i]['pixely'];
                $topLeftCoory = $result[$i]['coory'];
            }

            if($result[$i]['pixelx'] > $bottomRightPixelx)
            {
                $bottomRightPixelx = $result[$i]['pixelx'];
                $bottomRightCoorx = $result[$i]['coorx'];
            }
            if($result[$i]['pixely'] > $bottomRightPixely)
            {
                $bottomRightPixely = $result[$i]['pixely'];
                $bottomRightCoory = $result[$i]['coory'];
            }
        }

        $res = Yii::$app->db
            ->createCommand('select r.id, r.username, l.coorx, l.coory
                            from user as r, location as l
                            where r.id = l.user_id
                            and (l.floor_id = '.$floorid.')')
            ->queryAll();

        $widthPixel = $bottomRightPixelx - $topLeftPixelx;
        $heightPixel = $bottomRightPixely - $topLeftPixely;
        $widthCoor = $bottomRightCoorx - $topLeftCoorx;
        $heightCoor = $bottomRightCoory - $topLeftCoory;

        for($i = 0; $i < count($res); $i++)
        {
            try
            {
                $res[$i]['pixelx'] = $topLeftPixelx + intval(round(1.0*($res[$i]['coorx'] - $topLeftCoorx)/$widthCoor*$widthPixel));
                $res[$i]['pixely'] = $topLeftPixely + intval(round(1.0*($res[$i]['coory'] - $topLeftCoory)/$heightCoor*$heightPixel));
            }
            catch(\Exception $ex)
            {
                return [];
            }
        }
        return $res;
    }

    private function isAlerted($resident_id){
        try {
            $result = (new \yii\db\Query())
                ->select(['id'])
                ->from('notification')
                ->where(['resident_id' => $resident_id])
                    ->andWhere('user_id is NULL')
                ->all();
            if (count($result) > 0) {
                return true;
            }
            return false;
        } catch (\Exception $e) {
            return false;
        }
    }
}