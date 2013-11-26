<?php
/**
 * The user's model which use to support user login\add\edit
 * @author Suley<dearsuley@gmail.com>
 * @version 1.0 last updated: 18:23 November 21 2013
 * @see <<User's Manual>>
 * @copyright © Beijing Backpacker Information Consulting Center
 **/
class User extends ActiveRecord{
	//Basic setting for Yii model
	public $id,$username,$role,$email, $realname;
	public $password;
	private static $salt = 'jwiejg298y3583uif2hu';
	public function tableName(){
		return 'user';
	}
	public static function model($className = __CLASS__){
		return parent::model($className);
	}
  public function rules(){
    return array(
      array('username, role, password, email, realname', 'safe')
      );
  }
    // User role
  const ROLE_ADMIN = 'admin';
  const ROLE_PRESIDENT = 'superintendent';
  const ROLE_STAFF = 'staff';
  const ROLE_PRJMGR = 'project-manager';
  const ROLE_MANAGER = 'manager';
  const ROLE_GUEST = 'guest';
  public static $roleIntl = array(
    self::ROLE_ADMIN => '管理员',
    self::ROLE_PRESIDENT => '所长',
    self::ROLE_STAFF => '员工',
    self::ROLE_PRJMGR => '项目经理',
    self::ROLE_MANAGER => '主管',
    self::ROLE_GUEST => '游客'
    );
    // User status
  const STATUS_DISABLED = 'disabled';
  const STATUS_ACTIVE = 'active';
  const STATUS_DELETED = 'deleted';
  public function checkAccess($role){

  }
  public function validatePassword($password,$userPassword){
    Yii::log('User Attampts to login','warning','user.login');
    Yii::log('User Password:'.$password,'warning', 'user.login');
    Yii::log('Username:'.$this->username.'  Password:'.$userPassword,'warning', 'user.login');
    Yii::log('Hash Password:'.self::hashPassword($password),'warning', 'user.login');
    return (self::hashPassword($password) == $userPassword);
  }
  public static function hashPassword($password){
    return md5($password.self::$salt);
  }
  /**
   * Register with user information provided.
   * @param array $user = array('username'=>'', 'password'=>'', 'role'=>'', 'realname'=>'', 'email'=>'')
   **/
  public function register(array $user){
    if(isset($user)){
      $user['realname'] = empty($user['realname']) ? $user['username'] : $user['realname'];
      $user['password'] = self::hashPassword($user['password']);
      $this->attributes = $user;
      if($this->save()){
        return true;
      }
    }
    return false;
  }
  /**
   * Update user information with exist user
   * @param array $user = array('id'=>'', 'username'=>'', 'password'=>'', 'role'=>'', 'realname'=>'', 'email'=>'')
   * @return bool
   **/
  public static function updateInfo(array $user){
    if(isset($user)){
      $model = self::model()->findByPk($user['id']);
      if(isset($user['password']) && (self::hashPassword($user['password']) == $user['password']) OR empty($user['password']))
        unset($user['password']);
      else
        $user['password'] = self::hashPassword($user['password']);
      $model->attributes = $user;
      if($model->save())
        return true;
    }
    return false;
  }
  /**
   * Get user list filter by conditions.
   * @param mixed $filter
   **/
  public static function getList($filter = array()){
    if(empty($filter))
      $filter = array('status'=>self::STATUS_ACTIVE);
    return self::model()->findAllByAttributes($filter);
  }
  /**
   * Disable user
   * @param mixed $userId user's id, can be both array or single int number
   * @return bool
   **/
  public static function setDisabled($userId){
    return self::model()->updateByPk($userId, array('status'=>self::STATUS_DISABLED));
  }
  /**
   * Enable user by id
   * @param mixed $userId user's id, can be both array or single int number
   * @return bool
   **/ 
  public static function setEnable($userId){
    return self::model()->updateByPK($userId, array('status'=>self::STATUS_ACTIVE));
  }
  /**
   * Delete User
   * @param mixed $userId user's id, can be both array or single int number
   * @return bool
   **/
  public static function setDelete($userId){
    return self::model()->updateByPk($userId, array('status'=>self::STATUS_DELETED));
  }
  /** 
   * Get user's privileges
   * @param string $role user's role,
   * @return array $rolePrivs privileges list
   **/
  public static function getPriv($role){
    if(empty($role))
      $role = self::ROLE_STAFF;
    switch($role){
      //Administrator have all privileges
      case self::ROLE_ADMIN:
      $rolePrivs = array(
        'Asset' => array('New', 'ApplyNew', 'Review', 'Delete', 'List', 'Borrow', 'Back', 'History'),
        'Finance' => array('Reimbursement', 'ReimbursementEdit', 'ReimbursementList', 'ReimbursementReview'),
        'Leave' => array('Out', 'Change', 'Review', 'Edit', 'New', 'List', 'ChangeReview'),
        'Manhour' => array('Add', 'Edit', 'Report', 'Delete', 'Counting', 'Out', 'List', 'ReviewList', 'Review'),
        'Notify' => array('Success', 'Failure', 'SetRead', 'SetAllRead'),
        'Project' => array('New', 'List', 'Edit', 'Delete', 'Review'),
        'Site' => array('Index', 'Error', 'Login', 'NewLogin', 'Logout', 'User', 'UserList'),
        'Stat' => array('Total', 'Manhour', 'Reimbursement', 'Excercise', 'Project'),
        'User' => array('AddExcercise', 'Mymanhour', 'Exercise', 'Notify', 'Project', 'CheckUsername', 'Delete')
        );
      break;
      case self::ROLE_MANAGER:
      $rolePrivs = array(
        'Asset' => array('New', 'ApplyNew', 'Review', 'Delete', 'List', 'Borrow', 'Back', 'History'),
        'Finance' => array('Reimbursement', 'ReimbursementEdit', 'ReimbursementList', 'ReimbursementReview'),
        'Leave' => array('Out', 'Change', 'Review', 'Edit', 'New', 'List', 'ChangeReview'),
        'Manhour' => array('Add', 'Edit', 'Report', 'Delete', 'Counting', 'Out', 'List', 'ReviewList', 'Review'),
        'Notify' => array('Success', 'Failure', 'SetRead', 'SetAllRead'),
        'Project' => array('New', 'List', 'Edit', 'Delete', 'Review'),
        'Site' => array('Index', 'Error', 'Login', 'NewLogin', 'Logout', 'User', 'UserList'),
        'Stat' => array('Total', 'Manhour', 'Reimbursement', 'Excercise', 'Project'),
        'User' => array('AddExcercise', 'Mymanhour', 'Exercise', 'Notify', 'Project', 'CheckUsername', 'Delete')
        );
      break;
      case self::ROLE_PRJMGR:
      $rolePrivs = array(
        'Leave' => array('Out', 'Change', 'Review', 'Edit', 'New', 'List', 'ChangeReview'),
        'Manhour' => array('Add', 'Edit', 'Report', 'Delete', 'Counting', 'Out', 'List', 'ReviewList', 'Review'),
        'Notify' => array('Success', 'Failure', 'SetRead', 'SetAllRead'),
        'Project' => array('New', 'List', 'Edit', 'Delete', 'Review'),
        'Site' => array('Index', 'Error', 'Login', 'NewLogin', 'Logout', 'User', 'UserList'),
        'Stat' => array('Manhour', 'Reimbursement', 'Excercise', 'Project'),
        'User' => array('AddExcercise', 'Mymanhour', 'Exercise', 'Notify', 'Project', 'CheckUsername', 'Delete')
        );
      break;
      case self::ROLE_STAFF:
      $rolePrivs = array(
        'Finance' => array('Reimbursement', 'ReimbursementEdit', 'ReimbursementList'),
        'Leave' => array('Out', 'Change', 'Review', 'Edit', 'New', 'List'),
        'Manhour' => array('Add', 'Delete', 'Counting', 'Out', 'List'),
        'Notify' => array('Success', 'Failure', 'SetRead', 'SetAllRead'),
        'Project' => array('List'),
        'Site' => array('Index', 'Error', 'Login', 'NewLogin', 'Logout', 'User'),
        'User' => array('AddExcercise', 'Mymanhour', 'Exercise', 'Notify', 'Project', 'CheckUsername', 'Delete')
        );
      break;
      case self::ROLE_GUEST:
      $rolePrivs = array(
        'Site' => array('Error', 'Login', 'NewLogin', 'Logout') );
      break;
    }
  }
  /**
   * Check if the user has the privlege to access spcific action
   * @param string $role user's role
   * @param string $controller the controller's 
   * @param string $action the action's id
   * @return bool whether the user has privilege or not.
   **/
  public static function checkPriv($role, $controller, $action){
    $privs = self::getPriv($role);
    if(isset($privs[ucfirst($controller)]) && in_array(ucfirst($action), $privs[$controller])){
      return true;
    }
    return false;
  }
  /**
   * Get user's manhour statistics information
   * @param int $userId user's id
   * @return array $stats
   **/
  public function getStats($userId = 0){
    if(empty($userId))
      $userId = Yii::app()->user->id;
    $manhour = Manhour::model()->findAllByAttributes(array(
     'user_id' => $userId
     ));
    $stats = array();
    foreach($manhour as $item){
     $stats[$item->type] += ($item->end_time - $item->start_time);
   }
   return $stats;
 }
 /**
  * Translate the role into readable format
  * @param string $role role's name
  * @return string $role's readable 
  **/
 public static function translateRole($role){
  return self::$roleIntl[$role];
}
public function getPassword(){
  return $this->password;
}
public function getUsername(){
  return $this->username;
}
public static function getUserRealname($id){
  $result = self::model()->findByPk($id);
  if(!empty($result->realname)){
      return $result->realname;
      }else{
        if(empty($result))
          return '';
        return $result->username;
      }
  }
}
?>