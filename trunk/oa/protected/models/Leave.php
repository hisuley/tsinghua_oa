<?php
/**
 * Class Leave
 * @var status applying|approved|rejected
 */
class Leave extends CActiveRecord{
    public $user_id, $type, $start_time, $end_time, $notes, $create_time, $status, $time, $sub_type;
    /**
     * Define all type
     */
    const CHANGE = 'change'; //调休
    const NORMAL = 'normal'; //正常请假
    /**
     * Define all status
     */
    const APPROVED = 'approved'; //通过
    const REJECTED = 'rejected';//拒绝
    const PENDING = 'pending'; //等待审核
    const RESUBMIT = 'resubmit'; //重新提交
    public static $statusIntl = array(
        self::APPROVED => '通过',
        self::REJECTED => '拒绝',
        self::PENDING => '等待审核',
        self::RESUBMIT => '重新提交'
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
          array('user_id, type, start_time, end_time, notes, create_time , status, time, sub_type', 'safe')
        );
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
     * 格式化插入字段
     * @param $item
     * @return mixed
     */
    public static function formatCreation($item){
        $item->create_time = strtotime('now');
        $item->status = self::PENDING;
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
        if($role == User::STAFF){
            return self::model()->findAllByAttributes($filters, 'user_id = :user_id', array(':user_id'=>$user));
        }elseif($role == User::MANAGER || $role == User::ADMIN || $role == User::PRESIDENT){
            return self::model()->findAllByAttributes($filters);
        }elseif($role == User::PRJMGR){
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