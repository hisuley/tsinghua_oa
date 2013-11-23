<?php
/**
 * Created by Kimi Tourism.
 * @author Suley<luzhang@jmlvyou.com>
 * @time 13-11-11
 * @version 1.0
 * @copyright 
 **/

class Attribute extends CActiveRecord{
    /** Define Useful Attributes **/
    const ATTR_PROJECT_CAT = 'project_cat';
    const ATTR_CALENDAR_ITEM = 'calendar_item';
    public $attr_name, $attr_value, $user_id, $create_time;
    public static function model($className = __CLASS__){
        return parent::model($className);
    }
    public function tableName(){
        return 'attributes';
    }
    public function rules(){
        return array(
            array('attr_name, attr_value, user_id, create_time', 'safe')
        );
    }
    public function beforeSave(){
        if($this->isNewRecord){
            $this->create_time = strtotime('now');
        }
        return parent::beforeSave();
    }
    /**
     * Add New attributes to database
     * @param array $data the data of 
     * @return bool
     **/

    public static function addAttr($data){
        if(isset($data)){
            $model = new Attribute;
            $model->attributes = $data;
            if($model->save())
                return true;
        }
        return false;
    }

    /**
     * 返回属性列表
     * @param $attrName
     * @param string $type
     * @return array|CActiveRecord|mixed|null
     */
    public static function getAttr($attrName, $type = 'auto'){
        $result = self::model()->findAllByAttributes(array('attr_name'=>$attrName));
        if(count($result) > 0){
            switch($type){
                case 'auto':
                    return $result;
                    break;
            }
        }
        return false;
    }

    /**
     * 返回属性值
     * @param $id
     * @return array|mixed|null
     */
    public static function getAttrVal($id){
        $result = self::model()->findByPk($id);
        return $result->attr_value;
    }
}