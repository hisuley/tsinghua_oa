<?php

class User extends CActiveRecord{
	
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
  public static $roleIntl = array(
    self::ROLE_ADMIN => '管理员',
    self::ROLE_PRESIDENT => '所长',
    self::ROLE_STAFF => '员工',
    self::ROLE_PRJMGR => '项目经理',
    self::ROLE_MANAGER => '主管'
    );
    // User status
  const STATUS_DISABLED = 'disabled';
  const STATUS_ACTIVE = 'active';
  const STATUS_DELETED = 'deleted';
  public function checkAccess($role){

  }
  public function beforeSave(){
    if($this->isNewRecord){
      $this->create_time = strtotime('now');
    }
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
  public static function update(array $user){
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
  public function getPassword(){
    return $this->password;
  }
  public function getUsername(){
    return $this->username;
  }
  public static function getUserInfo($userId){
    $manhour = Manhour::model()->findAllByAttributes(array('user_id'=>$userId));


  }
  public static function getUserRealname($userId){
   $user = User::model()->findByPk($userId);
   return empty($user) ? '' : (empty($user->realname) ? $user->username : $user->realname);
 }
 public static function getUserList(){
   return self::model()->findAll();
 }
 public function getStats(){
  $manhour = Manhour::model()->findAllByAttributes(array(
   'user_id' => Yii::app()->user->id
   ));
  $stats = array();
  foreach($manhour as $item){
   $stats[$item->type] += ($item->end_time - $item->start_time);
 }
 return $stats;
}
public static function translateRole($role){
  return self::$roleIntl[$role];
}
}
?>