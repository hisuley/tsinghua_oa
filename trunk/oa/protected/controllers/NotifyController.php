<?php

class NotifyController extends Controller{
    public function beforeAction(){
        if(Yii::app()->user->isGuest && $this->action->id != 'login'){
            $this->redirect(array('site/login', 'back'=>$this->id."/".$this->action->id));
        }
        return true;
    }
	public function actionSuccess(){
		Yii::app()->user->setFlash('success', $_GET['content']);
		$this->redirect(array($_GET['back']));
		/*$this->render('success', array(
			'title' => $_GET['title'],
			'content' => $_GET['content'],
			'back' => isset($_GET['back']) ? $_GET['back'] : ''
			));*/
	}
    public function actionFailure(){
        Yii::app()->user->setFlash('failure', $_GET['content']);
        $this->redirect(array($_GET['back']));
    }
    public function setRead(){
        if(Yii::app()->request->isAjaxRequest && isset($_POST['NotifyForm']['id'])){
            Notify::setRead($_POST['NotifyForm']['id']);
            echo "success";
        }
    }
    public function setAllRead(){
        if(Yii::app()->request->isAjaxRequest && isset($_POST['NotifyForm']['user_id'])){
            if(Yii::app()->user->id == intval($_POST['NotifyForm']['user_id'])){
                Notify::setAllRead(Yii::app()->user->id);
                echo "success";
            }
        }
        echo "failure";
    }
}
?>