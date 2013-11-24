<?php

class ActiveRecord extends CActiveRecord{
	/**
	 * Some tricks before it's saved
	 **/
	public function beforeSave(){
        if($this->isNewRecord){
          $this->create_time = strtotime('now');
        }
        return true;
    }
}
?>