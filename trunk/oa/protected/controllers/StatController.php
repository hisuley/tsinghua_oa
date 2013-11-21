<?php

class StatController extends Controller{
    public function beforeAction(){
        if(Yii::app()->user->isGuest && $this->action->id != 'login'){
            $this->redirect(array('site/login', 'back'=>$this->id."/".$this->action->id));
        }
        return true;
    }
	public function actionTotal(){
		$project = new Project();
		$manhour = new Manhour();
		
	}
	public function actionManhour(){
		$this->render('manhour');
	}
	public function actionReimbursement(){
		$this->render('reimbursement');
	}
	public function actionExercise(){
		$this->render('exercise');
	}
	public function actionProject(){
		$this->render('project');
	}
	
}
?>