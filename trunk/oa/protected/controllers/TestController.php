<?php
/**
 * Created by Kimi Tourism.
 * @author Suley<luzhang@jmlvyou.com>
 * @time 13-10-31
 * @version 1.0
 * @copyright 
 **/

class TestController extends Controller{
    public function actionTestLeave(){
        var_dump(intval(Leave::getAvailHour(1)/3600));
    }
    public function actionCal(){
        $this->render('calendar');
    }
    public function actionActiveRecord(){
    	$model = Asset::model()->findAll();
    	foreach($model as $item){
    		print_r($item->attributes);
    	}
    }
    public function actionUrl(){
        echo $this->createUrl('test/urltest', array('filter'=>array('shit'=>array('ok', 'no-ok'),'fuck'=>array())));
    }
    public function actionUrlTest(array $filter = array()){
        print_r($filter);
        echo 'ok';
    }
    public function actionTable(){
        $this->render('table');
    }
}
?>