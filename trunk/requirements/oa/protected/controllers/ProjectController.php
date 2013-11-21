<?php

class ProjectController extends Controller{
	public function actionNew(){
		$this->render('new');
	}	
	public function actionList(){
		$this->render('list');
	}
	public function actionReview(){
		$this->render('review');
	}
}
?>