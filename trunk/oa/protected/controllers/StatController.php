<?php

class StatController extends Controller{
  
	public function actionTotal(){
		$project = new Project();
		$manhour = new Manhour();
		
	}
	/**
	 *
	 **/
	public function actionManhour(array $filters = array()){
		$result = Manhour::getManhourStatInfo($filters);
		$this->render('manhour', array('result'=>$result, 'filters'=>$filters));
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