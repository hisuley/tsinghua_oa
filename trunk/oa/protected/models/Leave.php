<?php
/**
 * Class Leave
 * @var status applying|approved|rejected
 */
class Leave extends ActiveRecord{
    public $user_id, $type, $start_time, $end_time, $notes, $create_time, $status, $time, $sub_type, $reviewer_id;
    /**
     * Define all type
     */
    const TYPE_CHANGE = 'change'; //调休
    const TYPE_NORMAL = 'normal'; //正常请假
    private static $typeIntl = array(
        self::TYPE_NORMAL => '请假',
        self::TYPE_CHANGE => '调休'
        );
    /**
     * Define all status
     */
    const STATUS_APPROVED = 'approved'; //通过
    const STATUS_REJECTED = 'rejected';//拒绝
    const STATUS_PENDING = 'pending'; //等待审核
    const STATUS_RESUBMIT = 'resubmit'; //重新提交
    private static $statusIntl = array(
        self::STATUS_APPROVED => '通过',
        self::STATUS_REJECTED => '拒绝',
        self::STATUS_PENDING => '等待审核',
        self::STATUS_RESUBMIT => '重新提交'
    );
    const SUBTYPE_CASUAL = 'casual', SUBTYPE_SICK = 'sick', SUBTYPE_YEAR = 'year', SUBTYPE_MARRIAGE = 'marriage', SUBTYPE_MATERNITY = 'maternity', SUBTYPE_HOME = 'home';
    public static $subTypeIntl = array(
        self::SUBTYPE_CASUAL => '事假', self::SUBTYPE_SICK => '病假', self::SUBTYPE_YEAR => '年假', self::SUBTYPE_MARRIAGE => '婚假', self::SUBTYPE_MATERNITY => '产假', self::SUBTYPE_HOME => '探亲假'
    );
    public static function model($className = __CLASS__){
        return parent::model($className);
    }
    public function tableName(){
        return 'leaves';
    }
    public function rules(){
        return array(
          array('user_id, type, start_time, end_time, notes, create_time , status, time, sub_type, reviewer_id', 'safe')
        );
    }

    public function beforeSave(){
        if($this->isNewRecord){
            $this->create_time = strtotime('now');
        }
        return parent::beforeSave();
    }
    /**
     * Add new leave data
     * @param array $data the data of leave record
     **/
    public static function addNew($data){
        $data['status'] = self::STATUS_PENDING;
        if($data['type'] == self::TYPE_NORMAL){
            if(!array_key_exists($data['sub_type'], self::$subTypeIntl)){
                return false;
            }
        }
        $model = new Leave;
        $model->attributes = $data;
        if($model->save()){
            return true;
        }
        return false;
    }
    /**
     * Update leave data
     * @param array $data the data of leave record
     * @return bool
     **/
    public static function updateInfo($data){
        if(empty($data['id']))
            return false;
        $model = self::model()->findByPk($data['id']);
        unset($data['type']);
        unset($data['sub_type']);
        unset($data['status']);
        unset($data['id']);
        $model->attributes = $data;
        // If this record is rejected, change the status to resubmit mode
        if($model->status == self::STATUS_REJECTED)
            self::setResubmit($model->id);
        if($model->save()){
            return true;
        }
        return false;
    }

    /**
     * set status
     * @param int $id the record's id
     * @param int $user user's id
     * @return bool
     **/
    public static function setLeaveStatus($stauts, $id, $user = false){
        if($status == self::STATUS_APPROVED){
            return self::setApproved($id, $user);
        }else{
            $setStatus = "set".ucfirst($status);
            return self::$setStatus($id);
        }
    }

    /**
     * Set status approved
     * @param int $id the record's 
     * @return bool
     **/
    public static function setApproved($id, $user){
        return self::model()->updateByPk($id, array('status'=>self::STATUS_APPROVED, 'reviewer_id' => $user));
    }

    /**
     * Set status reject
     * @param int $id the record's id
     * @return bool
     **/
    public static function setRejected($id){
        return self::model()->updateByPk($id, array('status'=>self::STATUS_REJECTED));
    }

    /**
     * Set status resubmit
     * @param int $id the record's id
     * @return bool
     **/
    private static function setResubmit($id){
        return self::model()->updateByPk($id, array('status'=>self::STATUS_RESUBMIT));
    }



    /**
     * 将状态翻译为中文
     * @param $status
     * @return mixed
     */
    public static function translateStatus($status){
        if(array_key_exists($status, self::$statusIntl)){
            return self::$statusIntl[$status];
        }
    }

    /**
     * Translate the type to chinese
     * @param string $type the type of record
     * @return string $translated_name the translated version of type
     **/
    public static function translateType($type){
        return self::$typeIntl[$type];
    }

    /**
     * 格式化插入字段
     * @param array $item
     * @return mixed
     */
    public static function formatCreation($item){
        $item->create_time = strtotime('now');
        $item->status = self::STATUS_PENDING;
        $item->start_time = strtotime($item->start_time);
        $item->end_time = strtotime($item->end_time);
        return $item;
    }

    /**
     * 格式化保存数据
     * @param $item
     * @return mixed
     */
    public static function formatSave($item){
        $item->start_time = strtotime($item->start_time);
        $item->end_time = strtotime($item->end_time);
        return $item;
    }

    /**
     * 设置请假/调休的状态
     * @param $item 实例
     * @param $status
     * @param bool $reviewer
     * @param bool $execNow
     * @return bool
     */

    public static function setStatus($item, $status, $reviewer = false, $execNow = false){
        if(!in_array($status, array(self::APPROVED, self::REJECTED, self::PENDING, self::RESUBMIT))){
            return false;
        }
        $item->status = $status;
        if(in_array($status, array(self::APPROVED, self::REJECTED)) && !$reviewer){
            $item->reviewer = $reviewer;
        }
        if($execNow){
            $item->save();
        }
        return $item;
    }

    /**
     * @param $id
     * @param $status
     * @return bool|int
     */
    public static function reviewLeave($id, $status){
        if(in_array($status, array('approved', 'rejected'))){
            return Leave::updateByPk($id, array('status'=>$status));
        }
        return false;
    }

    /**
     * 获取请假/调休的列表
     * @param $role 用户角色
     * @param $user 用户id
     * @param array $filters 筛选条件
     * @param mixed $page 当前页面
     * @return array|CActiveRecord|mixed|null
     */
    public static function getList($role, $user, $filters = array(), $page = false){
        if($role == User::ROLE_STAFF){
            return self::model()->findAllByAttributes($filters, 'user_id = :user_id', array(':user_id'=>$user));
        }elseif($role == User::ROLE_MANAGER || $role == User::ROLE_ADMIN || $role == User::ROLE_PRESIDENT){
            return self::model()->findAllByAttributes($filters);
        }elseif($role == User::ROLE_PRJMGR){
            $users = Project::findUserUnderProject($user);
            array_push($users, $user);
            $criteria = new CDbCriteria();
            $criteria->addInCondition('user_id', $users);
            return self::model()->findAllByAttributes($filters, $criteria);
        }
    }

    /**
     * 获取可调休的工时
     * @param $userId 用户id
     * @return int 可调休工时
     */
    public static function getAvailHour($userId){
        $totalHour = Yii::app()->db->createCommand('select sum(workinghour) as total from (select (end_time - start_time - 28800) as workinghour from manhour where end_time IS NOT NULL AND user_id = '.$userId.') as temp WHERE workinghour > 0;')->queryRow();
        $leaveHour = Yii::app()->db->createCommand('select sum(changehour) as usedhour from (select (start_time - end_time) as changehour from leaves where end_time IS NOT NULL and user_id = '.$userId.') as temp where changehour > 0;')->queryRow();
        if(empty($leaveHour['usedhour'])){
            $leaveHour['usedhour'] = 0;
        }
        if(empty($totalHour['total'])){
            $totalHour['total'] = 0;
        }
        return (($totalHour['total']-$leaveHour['usedhour']) > 0) ? ($totalHour['total']-$leaveHour['usedhour']) : 0;
    }
    public static function getTimeLength($start, $end){
        return intval(($end - $start)/3600);
    }

    
}
?>