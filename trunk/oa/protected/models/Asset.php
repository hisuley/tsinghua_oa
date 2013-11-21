<?php

class Asset extends CActiveRecord{
    public $user_id, $name, $amount, $sn, $status, $price, $create_time;
	public static function model($className = __CLASS__){
		return parent::model($className);
	}
	public function tableName(){
		return 'asset';
	}
    public function rules(){
        return array(
            array('user_id, name, amount, sn, price, create_time, status', 'safe')
            );
    }
    public function relations(){
        return array(
            'history'=>array(self::HAS_MANY, 'AssetHistory', 'asset_id')
            );
    }

    /**
     * 借出物品
     * @param $id 该物品的ID
     * @param $borrower 借用该物品人员id
     * @param bool $lender 出借人（目前未使用）
     * @return bool
     */
    public static function borrow($id, $borrower, $lender = false){
        if(!empty($id)){
            $model = self::model()->findByPk($id);
            if(!empty($model) && $model->attributes['status'] == 'available'){
                    $model->status = 'unavailable';
                    $history = new AssetHistory();
                    $history->borrow_time = strtotime('now');
                    $history->asset_id = $model->id;
                    $history->user_id = $borrower;
                    $history->create_time = strtotime('now');
                    if($history->save())
                        $model->save();
            }
        }
        return true;
    }

    /**
     * 归还物品
     * @param $id 该物品id
     * @return bool
     */
    public static function returnBack($id){
        if(!empty($id)){
            $model = self::model()->findByPk($id);
            if(!empty($model) && $model->attributes['status'] == 'unavailable'){
                $model->status = 'available';
                $history = AssetHistory::model()->find('asset_id = :asset_id AND return_time IS NULL', array(':asset_id'=>$id));
                if(!empty($history)){
                    $history->return_time = strtotime('now');
                    if($history->save()){
                        $model->save();
                        return true;
                    }
                }
            }
        }
        return false;
    }

    /**
     * 获取借用记录
     * @return array|CActiveRecord|mixed|null
     */
    public static function getHistory(){
        return AssetHistory::model()->findAll('return_time IS NOT NULL', array());
    }

    /**
     * 删除物品
     * @param $id
     * @return bool
     */
    public static function deleteRelated($id){
        self::model()->deleteByPk($id);
        AssetHistory::model()->deleteAllByAttributes(array('asset_id'=>$id));
        return true;
    }
}
?>