<?php
/**
 * Created by Kimi Tourism.
 * @author Suley<luzhang@jmlvyou.com>
 * @time 13-11-1
 * @version 1.0
 * @copyright 
 **/

class ManHourWidget extends CWidget{
    public $width;
    public function run(){
        $this->render('manhour', array('width'=>$this->width));
    }
}