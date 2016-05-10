<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 25/4/16
 * Time: 10:50 AM
 */

namespace backend\models;

use Yii;
use yii\db\Query;


class CommonFunction extends \yii\db\ActiveRecord
{
    //get all floor model
    public function getAllFloor(){
        $query = Floor::find()->all();
        return $query;
    }

    //get number of resident in floor $id
    public function getResidentCount($id){
        //Scenario 1
//        $query = Yii::$app->db->createCommand('
//            select count(r1.id) as cnt from resident_location as r1
//            where floor_id = '.$id.' and outside = 0
//            and (created_at between DATE_SUB(NOW(), INTERVAL 60 second) and NOW())
//            and created_at = (select max(created_at) from resident_location as r2 where r1.resident_id = r2.resident_id)
//        ')->queryAll();
        //Scenario 2
        $query = Yii::$app->db->createCommand('
            select count(id) as cnt
            from resident_location as r1
            where floor_id = '.$id.' and outside = 0
            and created_at between DATE_SUB(NOW(), INTERVAL 10 second) and NOW()
            and created_at = (select max(created_at) from resident_location as r2 where r1.resident_id = r2.resident_id)
        ')->queryAll();
        return $query[0]["cnt"];
    }

    //get number of resident who is out of range
    public function getAlertCount(){
        //Scenario 1
//        //between nearest 60 seconds and outside
//        $query = Yii::$app->db->createCommand('
//            select count(DISTINCT r1.resident_id) as cnt from resident_location as r1
//            where created_at = (select max(created_at) from resident_location as r2 where r1.resident_id = r2.resident_id)
//            and (created_at between DATE_SUB(NOW(), INTERVAL 60 second) and NOW())
//            and outside = 0
//        ')->queryAll();
//        //not between nearest 60 seconds
//        $tmp1 = Yii::$app->db->createCommand('
//            select count(distinct r1.resident_id) as cnt
//            from resident_location as r1;
//        ')->queryAll();
//        $tmp2 = Yii::$app->db->createCommand('
//            select count(distinct r1.resident_id) as cnt
//            from resident_location as r1
//            where r1.created_at between DATE_SUB(NOW(), INTERVAL 60 second) and NOW();
//        ')->queryAll();
//        return $query[0]["cnt"]+($tmp1[0]["cnt"] - $tmp2[0]["cnt"]);
        //Scenario 2
        $query = Yii::$app->db->createCommand('
            select count(id) as cnt
            from resident_location as r1
            where outside = 1
            and created_at between DATE_SUB(NOW(), INTERVAL 10 second) and NOW()
            and created_at = (select max(created_at) from resident_location as r2 where r1.resident_id = r2.resident_id)
        ')->queryAll();
        $tmp1 = Yii::$app->db->createCommand('
            select count(distinct r1.resident_id) as cnt
            from resident_location as r1;
        ')->queryAll();
        $tmp2 = Yii::$app->db->createCommand('
            select count(distinct r1.resident_id) as cnt
            from resident_location as r1
            where r1.created_at between DATE_SUB(NOW(), INTERVAL 10 second) and NOW();
        ')->queryAll();
        return $query[0]["cnt"]+($tmp1[0]["cnt"] - $tmp2[0]["cnt"]);
    }

    //get floor name by $id
    public function getFloorName($id){
        $query = Floor::find()->where(['id' => $id])->one();
        return $query['label'];
    }

    //get all resident in floor $id
    public function getResidentInFloor($id){
        $query = ResidentLocation::find()->where(['floor_id' => $id])->all();
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

    //get count floor
    public function getFloorNumber(){
        $query = Floor::find()->count();
        return $query;
    }

}