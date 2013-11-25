<?php

class ReimbursementItem extends ActiveRecord{
    public $reimbursement_id,$name,$total_price,$single_price,$amount, $notes, $create_time;
    public static function model($className = __CLASS__){
        return parent::model($className);
    }
    public function tableName(){
        return 'reimbursement_item';
    }
    public function relations(){
        return array(
          'reimbursement' => array(self::BELONGS_TO, 'reimbursement', 'reimbursement_id')
        );
    }
}
?>