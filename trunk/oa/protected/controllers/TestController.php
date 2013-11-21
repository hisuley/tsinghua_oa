<?php
/**
 * Created by Kimi Tourism.
 * @author Suley<luzhang@jmlvyou.com>
 * @time 13-10-31
 * @version 1.0
 * @copyright 
 **/

class TestController extends Controller{
    public function beforeAction(){
        return true;
    }
    public function actionTestLeave(){
        var_dump(intval(Leave::getAvailHour(1)/3600));
    }
    public function actionCal(){
        $this->render('calendar');
    }
}
?>