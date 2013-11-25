<?php

class FinanceController extends Controller{
    public function beforeAction(){
        parent::beforeAction();
    }
    /**
     * Apply for new reimbursement
     * @version 1.0 11/25/13 02:40:47
     **/
	public function actionReimbursement(){
		if(isset($_POST['ReimbursementForm']) && isset($_POST['ReimbursementItemForm'])){
            $data = $_POST['ReimbursementForm'];
            $data['user_id'] = Yii::app()->user->id;
            $itemData = $_POST['ReimbursementItemForm'];
            $model = Reimbursement::addNew($data, $itemData);
			if(!$model){
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
    /**
     * Edit Reimbursement 
     * @param int $id the id of reimbursement record
     * @version 1.0
     **/
    public function actionReimbursementEdit($id){
        if(isset($id)){
            if(empty($_POST['ReimbursementForm']) && empty($_POST['ReimbursementItemForm'])){
                $result = Reimbursement::model()->findByPk($id);
                $this->render('applyreimbursement', array('result'=>$result));
            }else{
                if(Reimbursement::updateInfo($_POST['ReimbursementForm'], $_POST['ReimbursementItemForm'])){
                    $this->redirect(
                        array('notify/success', 
                            'back'=>'finance/reimbursementlist', 
                            'title'=>'报销修改成功', 
                            'content'=>'报销修改成功。'
                            )
                        );  
                }
            }

        }
    }

    /**
     * Show reimbursement List
     * @param mixed $filters the filters of reimbursement
     * @version 1.0 11/25/13 02:45:08
     **/
	public function actionReimbursementList(array $filters = array()){
        $result = Reimbursement::getList($filters, Yii::app()->user->role, Yii::app()->user->id);
		$this->render('reimbursementlist', array('result'=>$result));
	}
    /**
     * Review the reimbursement record
     * @param int $id reimbursement record id
     * @return bool
     * @version 1.0 11/25/13 08:25:41
     **/
	public function actionReimbursementReview($id){
		if(Yii::app()->request->isAjaxRequest && isset($_POST['ReimbursementForm'])){
            if(in_array($_POST['ReimbursementForm']['status'], array( Reimbursement::STATUS_REJECTED, Reimbursement::STATUS_RESUBMIT, Reimbursement::STATUS_APPROVED))){
                if(Reimbursement::setStatus($_POST['ReimbursementForm'], $id, Yii::app()->user->id)){
                    echo 'success';
                }else{
                    echo 'failure';
                }
            }
        }else{
            if(in_array($_POST['ReimbursementForm']['status'], array( Reimbursement::STATUS_REJECTED, Reimbursement::STATUS_RESUBMIT, Reimbursement::STATUS_APPROVED))){
                if(Reimbursement::setStatus($_POST['ReimbursementForm'], $id, Yii::app()->user->id)){
                    $this->redirect(array('notify/success', 'back'=>'finance/reimbursementlist', 'content'=>'审核成功'));
                }else{
                    echo 'failure';
                }
            }
        }
	}
}
?>