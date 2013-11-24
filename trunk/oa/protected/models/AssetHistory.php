<?php
/**
 * the asset history recording model, used to maintance history record of borrowing  and returning.
 * @author Suley<dearsuley@gmail.com> 13-10-31
 * @version 1.0
 * @copyright © Beijing Backpacker Information Cousulting Center
 **/
class AssetHistory extends CActiveRecord{
	public $user_id, $borrow_time, $return_time, $create_time, $asset_id;
    public static function model($className = __CLASS__){
        return parent::model($className);
    }
    public function tableName(){
        return 'asset_history';
    }
    public function rules(){
    	return array(
    		array('user_id, borrow_time, return_time, create_time, asset_id', 'safe')
    		);
    }
    
    public function relations(){
        return array(
            'asset' => array(self::BELONGS_TO, 'Asset', 'asset_id')
            );
    }

    /**
     * 获取借用者姓名
     * @param $assetId
     * @return array|mixed|null
     */
    public static function getBorrower($assetId){
    	$result = self::model()->find('asset_id = :assetId AND return_time IS NULL', array(':assetId'=>$assetId));
    	$user = User::model()->findByPk($result->user_id);
    	return empty($user->realname) ? $user->username:$user->realname;
    }

    /**
     * 删除
     * @param $id
     * @return bool
     */
    public static function deleteByParent($id){
        self::model()->deleteAllByAttributes(array('asset_id'=>$id));
        return true;
    }
}
?>