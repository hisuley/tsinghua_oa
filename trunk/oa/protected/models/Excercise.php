<?php

class Exercise extends ActiveRecord{
    public $user_id, $time, $create_time;
    public static function model($className = __CLASS){
        return parent::model($className);
    }
    public function tableName(){
        return 'exercise';
    }
    public function rules(){
        return array(
          array('user_id, time, create_time', 'safe')
        );
    }

    /**
     * 插入锻炼记录
     * @param array $attributes 锻炼记录属性
     * @return bool
     */
    public function insertNew(array $attributes){
        $this->attributes = $attributes;
        $this->create_time = strtotime('now');
        if($this->save()){
            return true;
        }
        return fasle;
    }
}
?>