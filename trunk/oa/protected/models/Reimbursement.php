<?php
/**
 * Reimbursement model
 * @author Suley<dearsuley@gmail.com>
 * @version 1.0 11/25/13 01:05:10
 * @copyright © Beijing Backpacker Information Consulting Center
 **/
class Reimbursement extends CActiveRecord{
	public $user_id,$type,$username,$name,$item, $price, $content, $approve_time, $reviewer_id, $create_time, $status;
  // Reimbursement Status defination
  const STATUS_PENDING = 'pending';
  const STATUS_APPROVED = 'approved';
  const STATUS_REJECTED = 'rejected';
  const STATUS_RESUBMIT = 'resubmit';

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
    		array('username, price, content, approve_time, reviewer_id,  type', 'safe')
    		);
    }

    /**
     * Set reimbursement status to Approved
     * @param int $id the reimbursement record's id
     * @param int $user the reviewer's id
     * @return bool
     **/
    public static function setApproved($id, $user){
      return self::model()->updateByPk($id,array('status'=>self::STATUS_APPROVED, 'reviewer_id'=>$user));
    }

    /**
     * Set reimbursement status to rejected
     * @param int $id the reimbursement record's id
     * @param int $user the reviewer's id
     * @return bool
     **/
    public static function setRejected($id, $user){
      return self::model()->updateByPk($id,array('status'=>self::STATUS_REJECTED, 'reviewer_id'=>$user));
    }

    /**
     * Set reimbursement status to resubmit
     * @param int $id the reimbursement record's id
     * @param int $user the reviewer's id
     * @return bool
     **/
    public static function setResubmit($id){
      return self::model()->updateByPk($id,array('status'=>self::STATUS_RESUBMIT));
    }

    /**
     * Add new attributes
     * @param array $data
     * @param array $items
     * @return bool
     **/
    public static function addNew(array $data, array $items){
        $model = new Reimbursement;
        $model->attributes = $data;
        if($model->save()){
            foreach($items as $item){
                $itemModel = new ReimbursementItem;
                $itemModel->attributes = $item;
                $itemModel->reimbursement_id = $model->id;
                $itemModel->save();
            }
            return true;
        } 
        return false;
    }
    /**
     * Update reimbusement record
     * @param array $data
     * @param array $items
     * @return bool
     **/
    public static function updateInfo(array $data, array $items){
        if(isset($data['id']))
            $model = self::model()->findByPk($data['id']);
        unset($data['id']);
        $model->attributes = $data;
        if($model->save()){
            if(Reimbursement::model()->deleteAllByAttributes(array('reimbursement_id'=>$model->id))){
                foreach($items as $item){
                    $itemModel = new ReimbursementItem;
                    $itemModel->attributes = $item;
                    $itemModel->reimbursement_id = $model->id;
                    $itemModel->save();
                }
            }
            return true;
        }
        return false;
    }
}
?>