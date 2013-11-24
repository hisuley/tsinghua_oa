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
    /**
     * Test
     **/
    public function beforeFind(){
    	$this->create_time = date('Y-m-d', $this->create_time);
    	return true;
    }
}
?>