<?php

class FinanceController extends Controller{
    public function beforeAction(){
        parent::beforeAction();
    }
	public function actionReimbursement(){
		if(isset($_POST['ReimbursementForm'])){
			$reimbursement = new Reimbursement();
			$reimbursement->user_id = Yii::app()->user->id;
			$reimbursement->username = $_POST['ReimbursementForm']['username'];
			$reimbursement->price = $_POST['ReimbursementForm']['price'];
			$reimbursement->item = $_POST['ReimbursementForm']['item'];
			$reimbursement->name = $_POST['ReimbursementForm']['name'];
			$reimbursement->type = $_POST['ReimbursementForm']['type'];
            $reimbursement->status = 'pending';
            $reimbursement->create_time = strtotime('now');
			$reimbursement->content = serialize($_POST['ReimbursementForm']['content']);
			if($reimbursement->save()){
				$this->redirect(
					array('notify/success', 
						'back'=>'finance/reimbursementlist', 
						'title'=>'报销申请成功', 
						'content'=>'您已经申请报销，将转到报销列表页面。'
						)
					);	
			}else{
				throw new CHttpException(500, '服务器错误');
			}
		}else{
			$this->render('applyreimbursement');
		}
		
	}
    public function actionReimbursementEdit($id){
        if(isset($id)){
            if(empty($_POST['ReimbursementForm'])){
                $result = Reimbursement::model()->findByPk($id);
                $result->content = unserialize($result->content);
                $this->render('applyreimbursement', array('result'=>$result));
            }else{
                $model = new Reimbursement();
                $model->attributes = $_POST['ReimbursementForm'];
                $model->content = serialize($_POST['ReimbursementForm']['content']);
            }

        }
    }
	public function actionReimbursementlist(){
        if(Yii::app()->user->role == 'staff'){
            $result = Reimbursement::model()->findAll('user_id = :userId', array(':userId'=>Yii::app()->user->id));
        }elseif(Yii::app()->user->role == 'admin' || Yii::app()->user->role == 'superintendent'){
            $result = Reimbursement::model()->findAll('status != "cancelled"', array());
        }elseif(Yii::app()->user->role == 'project-manager'){
            $users = Project::findUserUnderProject(Yii::app()->user->id);
            $criteria = new CDbCriteria();
            if(!empty($users)){
                $criteria->addInCondition('user_id', $users, 'OR');
            }
            $criteria->addCondition('user_id = '.Yii::app()->user->id);
            $result = Reimbursement::model()->findAll($criteria);
        }
		$this->render('reimbursementlist', array('result'=>$result));
	}
	public function actionReimbursementReview($id){
		if(Yii::app()->request->isAjaxRequest && isset($_POST['ReimbursementForm'])){
            $model = Reimbursement::model()->findByPk($_POST['ReimbursementForm']['id']);
            $model->status = $_POST['ReimbursementForm']['status'];
            if($model->save()){
                echo 'success';
            }else{
                echo 'failure';
            }
        }else{
            $model = Reimbursement::model()->findByPk($id);
            $model->approve_time = strtotime('now');
            $model->status = 'approved';
            if($model->save()){
                $this->redirect(array('notify/success', 'back'=>'finance/reimbursementlist', 'content'=>'审核成功'));
            }
        }
	}
}
?>