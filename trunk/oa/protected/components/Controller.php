<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
	/**
	 * Override the default method and add some useful judgements
	 * @override 
	 **/
	public function beforeAction($action){
		/*
        if(Yii::app()->user->isGuest && $this->action->id != 'login' && $this->action->id != 'error' && $this->id != 'test'){
            $this->redirect(array('site/login', 'back'=>$this->id."/".$this->action->id));
        }elseif($this->id != 'test'){
        	if(empty(Yii::app()->user->role))
        		$role = User::ROLE_GUEST;
        	else
        		$role = Yii::app()->user->role;
            if(!User::checkPriv($role, $this->id, $this->action->id) && ($this->action->id != 'login')){
                throw new CHttpException(401, '您没有权限操作。');
            }
        }*/
        return true;
    }
}