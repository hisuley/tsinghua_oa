<?php
/**
 * The major entrance of OA system
 * @author Suley<dearsuley@gmail.com>
 * @version 1.0 last updated: 11/24/13 20:41:57
 * @copyright © Beijing Backpacker Information Consulting Center
 **/
class SiteController extends Controller
{
  

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
	 * Displays the login page
	 * @todo the page could not be loaded, check what's happenning.
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
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(array('site/login', 'logout'=>1));
	}
	/**
	 * Edit user information
	 * @param int $id the user's id
	 * @version 1.0
	 **/
    public function actionUser($id = 0){
        if(empty($id)){
            if(empty($_POST['UserForm'])){
                $this->render('user');
            }else{
            	$userData = $_POST['UserForm'];
                if(User::register($userData)){
                	$this->redirect(array('notify/success', 'back'=>'site/userlist', 'content'=>'用户保存成功！'));
                }else{
                	throw new CHttpException(500,'服务器错误。');
                }
            }
        }else{
            $result = User::model()->findByPk($id);
            if(empty($_POST['UserForm'])){
                if(!empty($result)){
                    $this->render('user', array('result'=>$result));
                }else{
                    throw new CHttpException(404, '无法找到你请求的用户。');
                }
            }else{
            	$userData = $_POST['UserForm'];
            	$userData['id'] = $id;
                if(User::updateInfo($_POST['UserForm'])){
                    $this->redirect(array('notify/success', 'back'=>'site/userlist', 'content'=>'修改用户信息成功！'));
                }else{
                	throw new CHttpException(500,'无法保存用户，存储过程发生严重错误。请联系管理员。');
                }
            }
        }

    }
    /**
     * List all users
     * @version 1.0 11/24/13 22:23:26
     **/
    public function actionUserList(){
        $result = User::getList(array());
        $this->render('userlist', array('result'=>$result));
    }
}