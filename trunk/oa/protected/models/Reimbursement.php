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
    		array('username, price, content, approve_time, type', 'safe')
    		);
    }
    /**
     * Add new attributes
     * @param array $data
     * @param array $items
     * @return bool
     **/
    public static function add(array $data, array $items){
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
    public static function update(array $data, array $items){
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