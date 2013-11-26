<?php
/**
 * The asset management model
 * @author Suley <dearsuley@gmail.com>
 * @version 1.0 last updated: 16:46 November 21 2013
 * @copyright © Beijing Backpacker Information Consulting Center
 **/
class Asset extends ActiveRecord{
    /** Asset Status **/
    const STATUS_AVAILABLE = 'available';
    const STATUS_UNAVAILABLE = 'unavailable';
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
     * Add new asset data
     * @param array @data the data of asset array('user_id'=>'', 'name'=>'', 'amount'=>'', 'sn'=>'', 'price'=>'', 'status'=>'')
     * @return bool
     **/
    public static function addNew(array $data){
        $model = new Asset;
        $model->attributes = $data;
        $model->status = self::STATUS_AVAILABLE;
        if($model->save()){
            return true;
        }
    }
    /**
     * Update asset data
     * @param array $data
     * @return bool
     **/
    public static function updateInfo(array $data){
        if(empty($data['id']))
            return false;
        $model = self::model()->findByPk($data['id']);
        unset($data['id']);
        $model->attributes = $data;
        if($model->save())
            return true;
        return false;
    }

    /**
     * 借出物品
     * @param array $data 借阅信息
     */
    public static function borrow($data){
        if(!empty($data['asset_id'])){
            $model = self::model()->findByPk($data['asset_id']);
            if(!empty($model) && $model->attributes['status'] == self::STATUS_AVAILABLE){
                    $model->status = self::STATUS_UNAVAILABLE;
                    $history = new AssetHistory();
                    $history->borrow_time = strtotime('now');
                    $history->asset_id = $model->id;
                    $history->user_id = $data['user_id'];
                    if($history->save()){
                        $model->save();
                        return true;
                    }
            }
        }
        return false;
    }

    /**
     * 归还物品
     * @param $id 该物品id
     * @return bool
     */
    public static function returnBack($id){
        if(!empty($id)){
            $model = self::model()->findByPk($id);
            if(!empty($model) && $model->attributes['status'] == self::STATUS_UNAVAILABLE){
                $model->status = self::STATUS_AVAILABLE;
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
     * Get asset list by filters
     * @param array $filters the filter's combination
     * @return null|mixed
     **/
    public static function getList(array $filters){
        return self::model()->findAllByAttributes($filters);
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
    public static function deleteAsset($id){
        if(self::model()->deleteByPk($id) && AssetHistory::model()->deleteAllByAttributes(array('asset_id'=>$id)))
            return true;
        else
            return false;
    }

}
?>