<?php

class UserController extends Controller{
     public function beforeAction(){
        parent::beforeAction();
    }

	public function actionMymanhour(){
		$this->render('manhour');
	}
    public function actionAddExercise(){
        if(isset($_POST['ExerciseForm'])){
            $model = new Exercise();
            $model->user_id = Yii::app()->user->id;
            $model->attributes = $_POST['ExerciseForm'];
            if($model->save()){
                $this->redirect(array('notify/success', 'back'=>'user/exercise', 'content'=>'添加锻炼时间成功！'));
            }else{
                $this->redirect(array('notify/failure', 'back'=>'user/exercise', 'content'=>'服务器通信失败，请联系管理员！'));
            }
        }

        $this->render('exercise');
    }
	public function actionExercise(){
		$this->render('exercise');
	}
	public function actionNotify(){
		$this->render('notify');
	}
	public function actionProject(){
		$project = new Project();
		$userRole = 'admin'; //TODO: should be replaced by dymanic value passing
		if($userRole == 'admin' || $userRole == 'manager'){
			$result = Project::model()->findAll();
		}elseif($userRole == 'staff'){
			$this->redirect(array('notify/nopermission', 'back'=>'site/index', 'title'=>'权限不足', 'content'=>'您的身份是普通用户，无法执行该操作，请确认您的权限是否可以查看项目。' ));
		}elseif($userRole == 'project-manager'){
			$result = Project::model()->findAllByAttributes(
				array(
					'user_id' => Yii::app()->user->id
					)
				);
		}
		$this->render('project', array('result'=>$result));
	}
    public function actionCheckUsername(){
        if(Yii::app()->request->isAjaxRequest){
            $result = User::model()->count('username = "'.$_POST['username'].'"');
            if($result > 0){
                echo "taken";
            }else{
                echo "available";
            }
        }else{
            echo "do not directly access";
            $result = User::model()->count('username = "admin"');
            var_dump($result);
        }
    }
    public function actionDelete($id){
        $result = User::model()->deleteByPk($id);
        $this->redirect(array('notify/success', 'back'=>'site/userlist', 'content'=>'删除用户成功！'));
    }
}
?>