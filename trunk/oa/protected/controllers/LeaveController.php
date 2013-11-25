<?php
/**
 * Leave management
 * @author Suley<dearsuley@gmail.com>
 * @version 1.0 11/25/13 08:28:17
 **/
class LeaveController extends Controller{

    /**
     * Add out record
     * @version 1.0 11/25/13 08:37:45
     **/
	public function actionOut(){
		if(isset($_POST['LeaveForm'])){
            $data = $_POST['LeaveForm'];
            $data['user_id'] = Yii::app()->user->id;
            $data['type'] = Manhour::TYPE_OUT;
			if(Manhour::addNew($data)){
				$this->redirect(
					array('notify/success', 
						  'back'=>'leave/list',
				 		  'content' => '您的外出信息已经被系统记录。'
				 		  )
					);
			}else{
				throw new CHttpException(500, '服务器错误');
			}
		}
		$this->render('out');	
	}

    //调休申请
    public function actionChange(){
        if(isset($_POST['LeaveForm'])){
            $data = $_POST['LeaveForm'];
            $data['user_id'] = Yii::app()->user->id;
            $data['type'] = Leave::TYPE_CHANGE;
            if(Leave::addNew($data)){
                $this->redirect(array('notify/success', 'back'=>'leave/list', 'content'=>"添加成功！"));
            }else{
                throw new CHttpException(500, '服务器错误');
            }
        }
        $this->render('change');
    }

    /**
     * Review the leave data
     * @param int $id the leave's id
     * @return 
     **/
    public function actionReview($id){
        if(isset($_POST['LeaveForm'])){
            $data = $_POST['LeaveForm'];
            if(Leave::setStatus($data['status'], $id, Yii::app()->user->id)){
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
    /**
     * Edit the leave data
     * @param int $id leave record's id
     **/
    public function actionEdit($id = false){
        if(!empty($id)){
            if(empty($_POST['LeaveForm'])){
                $model = Leave::model()->findByPk($id);
                $this->render($model->type);
            }else{

            }
            
        }
    }
    /**
     * Insert new common leave record
     * @param string $type the type of leave
     * @return bool
     * @version 1.0 11/25/13 10:35:44
     **/
	public function actionNew($type = 'leave'){
        if(isset($_POST['LeaveForm'])){
            $data = $_POST['LeaveForm'];
            $data['user_id'] = Yii::app()->user->id;
            if(Leave::addNew($data)){
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
    /**
     * Get Leave list
     * @param array $filters
     * @version 1.0 11/25/13 10:39:28
     **/
	public function actionList(array $filters = array()){
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