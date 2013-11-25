<?php

class Project extends ActiveRecord{
	public $paid_price, $name, $cat,$sn,$user_id,$sign_date,$location,$total_price,$real_contract_price,$payment_times,$first_pay,$second_pay,$third_pay,$fourth_pay,$fifth_pay,$sixth_pay,$seventh_pay;
    // 项目常用属性
    const ATTR_CATEGORY = 'project_cat';
	public function rules(){
		return array(
			array('name, cat,sn,sign_date,location,total_price,real_contract_price,payment_times,first_pay, second_pay, third_pay, fourth_pay, fifth_pay, sixth_pay, seventh_pay', 'safe')
			);
	}
	public function tableName(){
		return 'project';
	}
	public static function model($className = __CLASS__){
		return parent::model($className);
	}
    public function relations(){
        return array(
          'users' => array(self::HAS_MANY, 'ProjectUser', 'project_id')
        );
    }
    public function beforeSave(){
        $this->sign_date = strtotime($this->sign_date);
        return parent::beforeSave();
    }
    /**
     * Add new project record
     * @param array $data the attributes of this project
     * @param array $users the users who involved in this
     * @return bool
     **/
    public static function addNew(array $data, array $users){
        if(isset($data)){
            $model = new Project;
            $model->attributes = $data;
            $model = self::reform($model);
            if($model->save()){
                foreach($users as $user){
                    $userModel = new ProjectUser;
                    $userModel->attributes = $user;
                    $userModel->project_id = $model->id;
                }
                return true;
            }
        }
        return false;
    }
    /**
     * Update the project's information
     * @param array $data the project's data
     * @param array $users 
     * @return bool
     **/
    public static function updateInfo(array $data, array $users){
        if(isset($data['id'])){
            $model = self::model()->findByPk($data['id']);
            unset($data['id']);
            $model->attributes = $data;
            $model = self::syncPaymentTimes($model);
            if($model->save()){
                ProjectUser::model()->deleteAllByAttributes(array('project_id'=>$model->id));
                foreach($users as $user){
                    $userModel = new ProjectUser;
                    $userModel->attributes = $user;
                    $userModel->project_id = $model->id;
                }
                return true;
            }
        }
        return false;
    }

    /**
     * 处理数据
     * @param $result
     * @return int
     */
    public static function reform($result){
        if(!empty($result)){
            $total = 0;
            for($i=0;$i<$result->payment_times;$i++){
                $timesArray = array('first_pay', 'second_pay', 'third_pay', 'fourth_pay', 'fifth_pay', 'sixth_pay', 'seventh_pay');
                $total += empty($result->$timesArray[$i]) ? 0 : $result->$timesArray[$i];
            }
            $result->paid_price = $total;
            return $result;
        }
        return 0;
    }
    public static function batchReform($result){
        if(!empty($result)){
            $total = 0;
            foreach($result as &$item){
                $item = self::reform($item);
            }
            return $result;
        }
        return false;
    }
    public static function syncPaymentTimes($result){
        if(!empty($result)){
            for($i=$result->payment_times;$i<6;$i++){
                $timesArray = array('first_pay', 'second_pay', 'third_pay', 'fourth_pay', 'fifth_pay', 'sixth_pay', 'seventh_pay');
                $result->$timesArray[$i] = NULL;
            }
            return $result;
        }
    }
    public static function dateFix($result){
        $result->sign_date = strtotime($result->sign_date);
        return $result;
    }
    public static function format($result){
        if(!empty($result)){
            $result = self::syncPaymentTimes($result);
            $result = self::dateFix($result);
            return $result;
        }
    }
    public static function findUserUnderProject($ownerId){
        $result = self::model()->findAll('user_id = :userId', array(':userId'=>$ownerId));
        $users = array();
        foreach($result as $project){
            foreach($project->users as $user){
                array_push($users, $user->user_id);
            }
        }
        return $users;
    }
    public static function isUserInProject($ownerId, $userId){
        if(!empty($ownerId) && !empty($userId)){
            $users = self::findUserUnderProject($ownerId);
            return in_array($userId, $users) ? true : false;
        }
       return false;
    }
    public static function getProjectList($role, $userId){
        if(isset($role) && in_array($role, array(User::ROLE_STAFF, User::ROLE_PRJMGR, User::ROLE_MANAGER, User::ROLE_ADMIN, User::ROLE_PRESIDENT))){
            switch($role){
                case User::ROLE_ADMIN:
                    return self::model()->findAll();
                    break;
                case User::ROLE_PRESIDENT:
                    return self::model()->findAll();
                    break;
                case User::ROLE_PRJMGR:
                    return self::model()->findAll('user_id = :user_id', array(':user_id'=>$userId));
                    break;
                case User::ROLE_MANAGER:
                    return self::model()->findAll();
                    break;
                case User::ROLE_STAFF:
                    throw new CHttpException(401, '您的身份是普通用户，无法执行该操作，请确认您的权限是否可以查看项目。');
                    break;
            }
        }
    }

	
}
?>