<?php
/**
 * Created by Kimi Tourism.
 * @author Suley<luzhang@jmlvyou.com>
 * @time 13-10-14
 * @version 1.0
 * @copyright 
 **/

class ProjectUser extends CActiveRecord{
    public $user_id, $project_id, $role, $note, $create_time, $start_time, $end_time, $important, $notice;
    public static function model($className = __CLASS__){
        return parent::model($className);
    }
    public function tableName(){
        return 'project_user';
    }
    public function rules(){
        return array(
          array('user_id,project_id,role,note,create_time,start_time,end_time,important,notice', 'safe')
        );
    }
    public function relations(){
        return array(
           'project' => array(self::BELONGS_TO, 'project', 'project_id')
        );
    }
    public static function dateFix($result){
        $result->start_time = strtotime($result->start_time);
        $result->end_time = strtotime($result->end_time);
        $result->important = strtotime($result->important);
        return $result;
    }
    public static function format($result){
        $result = self::dateFix($result);
        return $result;
    }
}