<?php
/**
 * Created by Kimi Tourism.
 * @author Suley<luzhang@jmlvyou.com>
 * @time 13-11-11
 * @version 1.0
 * @copyright 
 **/

class Attribute extends CActiveRecord{
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