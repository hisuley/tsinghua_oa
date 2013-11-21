<?php

class Reimbursement extends CActiveRecord{
	public $user_id,$type,$username,$name,$item, $price, $content, $approve_time, $create_time, $status;
	public static function model($className = __CLASS__){
		return parent::model($className);
	}
	public function tableName(){
		return 'reimbursement';
	}
    public function relations(){
        return array(
          'item' => array(self::HAS_MANY, 'reimbursement_item', 'reimbursement_id')

        );
    }
    public function rules(){
    	return array(
    		array('username, price', 'safe')
    		);
    }
}
?>