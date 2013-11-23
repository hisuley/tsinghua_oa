<?php

class LeaveController extends Controller{
    public function beforeAction(){
        parent::beforeAction();
    }
	public function actionOut(){
		if(isset($_POST['LeaveForm'])){
			$leave = new Leave();
			$leave->attributes = $_POST['LeaveForm'];
			if($leave->save()){
				$this->redirect(
					array('notify/success', 
						  'back'=>'leave/list',
				 		  'content' => '您的外出信息已经被系统记录。'
				 		  )
					);
			}else{
				throw new CHttpException(500, '服务器错误');
			}
		}else{
			$this->render('out');	
		}
		
	}
    //调休申请
    public function actionChange(){
        if(isset($_POST['LeaveForm'])){
            $leave = new Leave();
            $leave->attributes = $_POST['LeaveForm'];
            if($leave->save()){
                $this->redirect(array('notify/success', 'back'=>'leave/list', 'content'=>"添加成功！"));
            }else{
                throw new CHttpException(500, '服务器错误');
            }
        }
        $this->render('change');
    }

    public function actionReview(){
        if(isset($_POST['LeaveForm'])){
            $leave = Leave::model()->findByPk($_POST['LeaveForm']['id']);
            $leave->attributes = $_POST['LeaveForm'];
            if($leave->save()){
                if(Yii::app()->request->isAjaxRequest){
                    echo 'success';
                }else{
                    $this->redirect(array('notify/success', 'back'=>'leave/list', 'content'=>'修改成功！'));
                }
            }else{
                if(Yii::app()->request->isAjaxRequest){
                    echo 'failure';
                }else{
                    $this->redirect(array('notify/success', 'back'=>'leave/list', 'content'=>'修改成功！'));
                }
            }
            //Ajax Request
        }
    }
    public function actionEdit($id = false){
        if(!empty($id)){
            $model = Leave::model()->findByPk($id);
        }
    }
	public function actionNew($type = 'leave'){
        if(isset($_POST['LeaveForm'])){
            $leave = new Leave();
            $leave->attributes = $_POST['LeaveForm'];
            if($leave->save()){
                $this->redirect(array('notify/success', 'back'=>'leave/list', 'content'=>'添加成功！'));
            }else{
                throw new CHttpException(500, '服务器错误，请联系管理员。');
            }
        }
        switch($type){
            case 'leave':
                $this->render('new');
                break;
            case 'change':
                $this->render('change');
        }
	}
	public function actionList($type, $action){
        $renderPage = 'review';
		$filter = array();
        if(!empty($type) && $type != 'all')
            $filter['type'] = $type;
        $result = Leave::getList(Yii::app()->user->role, Yii::app()->user->id, $filter);
        if(!empty($action)){
            switch($action){
                case 'review':
                    $renderPage = 'review';
                    break;
                case 'view':
                    //This is the default page
                    $renderPage = 'review';
                    break;
            }
        }
		$this->render($renderPage, array('result'=>$result));
	}

    //审批调休记录
    public function actionChangeReview($id = null){
        if(!empty($id) && !empty($_POST['LeaveForm'])){
            $result = Leave::reviewLeave($id, $_POST['LeaveForm']['status']);
            if(!empty($result)){
                if(Yii::app()->request->isAjaxRequest){
                    echo "success";
                }else{
                    $this->redirect(array('notify/success', 'back'=>'leave/changereviewlist', 'content'=>'审批成功'));
                }
            }else{
                if(Yii::app()->request->isAjaxRequest){
                    echo "failure";
                }else{
                    throw new CHttpException(500, '服务器错误');
                }
            }
        }
        throw new CHttpException(404, '无法找到您的资源。');
    }
}
?>