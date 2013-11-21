<?php

class SiteController extends Controller
{
    public function beforeAction(){
        if(Yii::app()->user->isGuest && $this->action->id != 'login'){
            $this->redirect(array('site/login', 'back'=>$this->id."/".$this->action->id));
        }
        return true;
    }
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
        if(Yii::app()->user->isGuest){
            $this->redirect(array('site/login'));
        }
        $userRole = Yii::app()->user->role;
        $manHour = Manhour::getManhourInfo(Yii::app()->user->id);
        if(1){
            if(isset($_GET['section']) && $_GET['section'] == 2){
                $this->render('superuser', array('section'=>2, 'manhour'=>$manHour));
            }else{
                $this->render('superuser', array('section'=>1, 'manhour'=>$manHour));
            }
        }
		
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
        $model = new LoginForm();
        if(!Yii::app()->user->isGuest){
            $this->redirect(array('site/index'));
        }
        // if it is ajax validation request
        if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if(isset($_POST['LoginForm']))
        {
            $model->attributes=$_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if($model->validate() && $model->login())
                $this->redirect(Yii::app()->user->returnUrl);
            else
                Yii::app()->user->setFlash('failure', '登陆失败，请检查用户名');
        }
        if(isset($_GET['logout']) && $_GET['logout'])
            Yii::app()->user->setFlash('success','您已经成功注销！');

		$this->renderPartial('newlogin');
		// $model=new LoginForm;

		// // if it is ajax validation request
		// if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		// {
		// 	echo CActiveForm::validate($model);
		// 	Yii::app()->end();
		// }

		// // collect user input data
		// if(isset($_POST['LoginForm']))
		// {
		// 	$model->attributes=$_POST['LoginForm'];
		// 	// validate user input and redirect to the previous page if valid
		// 	if($model->validate() && $model->login())
		// 		$this->redirect(Yii::app()->user->returnUrl);
		// }
		// // display the login form
		// $this->render('login',array('model'=>$model));
	}
	public function actionNewLogin()
	{
		
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(array('site/login', 'logout'=>1));
	}
    public function actionUser(){
        if(empty($_GET['id'])){
            if(empty($_POST['UserForm'])){
                $this->render('user');
            }else{
                $user = new User();
                $user->username = $_POST['UserForm']['username'];
                $user->realname = $_POST['UserForm']['realname'];
                $user->password = $user->hashPassword($_POST['UserForm']['password']);
                $user->role = $_POST['UserForm']['role'];
                $user->email = $_POST['UserForm']['email'];
                $user->create_time = strtotime('now');
                if($user->save()){
                    $this->redirect(array('notify/success', 'back'=>'site/userlist', 'content'=>'用户保存成功！'));
                }else{
                    throw new CHttpException(500,'服务器错误。');
                }
            }
        }else{
            $result = User::model()->findByPk($_GET['id']);
            if(empty($_POST['UserForm'])){
                if(!empty($result)){
                    $this->render('user', array('result'=>$result));
                }else{
                    throw new CHttpException(404, '无法找到你请求的用户。');
                }
            }else{
                if(!empty($_POST['UserForm']['password'])){
                    $result->password = User::hashPassword($_POST['UserForm']['password']);
                }
                unset($_POST['UserForm']['password']);
                $result->attributes = $_POST['UserForm'];

                if($result->save()){
                    $this->redirect(array('notify/success', 'back'=>'site/userlist', 'content'=>'修改用户信息成功！'));
                }
            }


        }


    }

    public function actionUserList(){
        $result = User::model()->findAll();
        $this->render('userlist', array('result'=>$result));
    }
}