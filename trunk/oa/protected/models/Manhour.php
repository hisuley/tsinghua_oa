<?php

class Manhour extends CActiveRecord{
    public $user_id,$type,$start_time,$end_time,$change_user, $reviewer_id, $is_review;
    public static function model($className = __CLASS__){
        return parent::model($className);
    }
    public function tableName(){
        return 'manhour';
    }
    public function rules(){
        return array(
            array('user_id,type,start_time,end_time,change_user, reviewer_id, is_review', 'safe')
        );
    }
    public function relations(){
        return array(
          'user'=>array(self::BELONGS_TO, 'User', 'user_id')
        );
    }
    const TYPE_OUT = 'out';
    const TYPE_NORMAL = 'normal';
    public static $typeIntl = array(
      self::TYPE_NORMAL => '考勤',
        self::TYPE_OUT => '外出'
    );
    const STATUS_END = 'end';
    const STATUS_START = 'start';
    const STATUS_UNSIGNED = 'un-sign-off';
    const STATUS_COMPLETE = 'complete';
    public static $statusIntl = array(
      self::STATUS_COMPLETE => '审核通过',
        self::STATUS_END => '结束，待审核',
        self::STATUS_START => '进行中',
        self::STATUS_UNSIGNED => '未签出'
    );
    /**
     * 自动清理未及时签出的记录
     */
    public function beforeFind(){
        self::autoSetSignoffState();
        Yii::log('cron job for cleaning un-stopped manhour counting record', 'info');
    }

    /**
     * 获取工时统计列表
     * @param array $users 用户
     * @return array
     */
    public static function getManhourStatsList(array $users){
        if(empty($users)){
            $users = Yii::app()->db->createCommand('SELECT * FROM users WHERE status = "'.User::ACTIVE.'"')->queryAll();
        }
        foreach($users as &$user){
            $user['manhour'] = self::getManhourInfo($user['id']);
        }
        return $users;
    }
    public static function getManhourStatsListByFilters(array $filters, array $order, array $users){

    }

    /**
     * 获得某个用户的工时数据
     * @param $userId 用户id
     * @return array
     */
    public static function getManhourInfo($userId){
        $criteria = new CDbCriteria();
        $criteria->addBetweenCondition('start_time',strtotime(date('Y-m-d')." +8 hours"), strtotime(date('Y-m-d')."+1 days +8 hours"));
        $criteria->addCondition('user_id = '.$userId, 'AND');
        $manHour = self::model()->find($criteria);
        if(!empty($manHour)){
            $manHour = (array)$manHour;
            $manHour['total_time'] = array();
            $manHour['over_time']['hour'] = 0;
            $manHour['over_time']['minute'] = 0;
            $manHour['over_time']['second'] = 0;
            $manHour['over_time']['time'] = 0;
            if(isset($manHour['end_time'])){
                if(($manHour['end_time']-$manHour['start_time']) < 28800){
                    $manHour['total_time']['hour'] = floor(($manHour['end_time']-$manHour['start_time'])/3600);
                    $manHour['total_time']['minute'] = floor((($manHour['end_time']-$manHour['start_time'])%3600)/60);
                    $manHour['total_time']['second'] = floor((($manHour['end_time']-$manHour['start_time'])%3600)%60);
                    $manHour['total_time']['time'] = $manHour['end_time'] - $manHour['start_time'];
                }else{
                    $manHour['total_time']['hour'] = 8;
                    $manHour['total_time']['minute'] = 0;
                    $manHour['total_time']['second'] = 0;
                    $manHour['total_time']['time'] = 28800;
                    $remainTime = $manHour['end_time']-$manHour['start_time']-28800;
                    $manHour['over_time']['hour'] = floor($remainTime/3600);
                    $manHour['over_time']['minute'] = floor($remainTime%3600/60);
                    $manHour['over_time']['second'] = floor(($remainTime%3600)%60);
                    $manHour['over_time']['time'] = $remainTime;
                }
                $manHour['width'] = intval($manHour['end_time']-$manHour['start_time'])/86400;
            }
            else{
                $currentTime = strtotime('now');
                if(($currentTime - $manHour['start_time']) < 28800){
                    $manHour['total_time']['hour'] = floor(($currentTime-$manHour['start_time'])/3600);
                    $manHour['total_time']['minute'] = floor((($currentTime-$manHour['start_time'])%3600)/60);
                    $manHour['total_time']['second'] = floor((($currentTime-$manHour['start_time'])%3600)%60);
                    $manHour['total_time']['time'] = $currentTime - $manHour['start_time'];
                }else{
                    $manHour['total_time']['hour'] = 8;
                    $manHour['total_time']['minute'] = 0;
                    $manHour['total_time']['second'] = 0;
                    $manHour['total_time']['time'] = 28800;
                    $remainTime = $currentTime-$manHour['start_time']-28800;
                    $manHour['over_time']['hour'] = floor($remainTime/3600);
                    $manHour['over_time']['minute'] = floor($remainTime%3600/60);
                    $manHour['over_time']['second'] = floor(($remainTime%3600)%60);
                    $manHour['over_time']['time'] = $remainTime;
                }
                $manHour['width'] = intval($currentTime-$manHour['start_time'])/86400;
            }
        }else{
            $manHour = array();
            $manHour['width'] = 0;
        }
        return $manHour;
    }

    /**
     * 根据用户身份获得工时列表
     * @param $userId
     * @param $userRole
     * @return array|CActiveRecord|mixed|null
     */
    public static function getManhourList($userId, $userRole){
        if(!empty($userId) && !empty($userRole)){
            switch($userRole){
                case 'project-manager':
                    return self::getProjectManagerManhourList($userId);
                    break;
                case 'admin':
                    return self::getAdminManhourList($userId);
                    break;
                case 'staff':
                    return self::getStaffManhourList($userId);
                    break;
                default:
                    return self::getStaffManhourList($userId);
                    break;
            }}
    }
    public static function getProjectManagerManhourList($userId){
        $users = Project::findUserUnderProject($userId);
        array_push($users, $userId);
        $criteria = new CDbCriteria();
        $criteria->addInCondition('user_id', $users);
        return self::model()->findAll($criteria);
    }
    public static function getAdminManhourList($userId){
        return self::model()->findAll();
    }
    public static function getStaffManhourList($userId){
        return self::model()->findAll('user_id = :user_id', array(':user_id'=>$userId));
    }

    /**
     * 计算加班、正常工时
     * @param $manhour
     * @return array
     */
    public static function calculateManhour($manhour){
        if(!empty($manhour)){
            $return = array();
            if(is_object($manhour)){
                $manhour->end_time = empty($manhour->end_time) ? strtotime('now') : $manhour->end_time;
                $return['overtime'] = (($manhour->end_time - $manhour->start_time)>28800) ? ($manhour->end_time - $manhour->start_time) : 0;
                $return['manhour'] =  (($manhour->end_time - $manhour->start_time)> 0) ? ((($manhour->end_time - $manhour->start_time) < 28800) ? ($manhour->end_time - $manhour->start_time) : 28800) : 0;
                $return['total'] = $manhour->end_time - $manhour->start_time;
            }elseif(is_array($manhour)){

            }
        }
        return $return;
    }

    /**
     * 审核工时
     * @param $id
     * @param $userId
     * @return bool
     */
    public static function setReview($id, $userId){
        $result = Manhour::model()->updateByPk($id, array('reviewer_id'=>$userId, 'is_review'=>1, 'status'=>'complete'));
        if($result > 0){
            return true;
        }
    }

    /**
     * 工时求和
     * @param $id
     */
    public static function sumManhour($id){

    }

    public static function translateType($type){
        return self::$typeIntl[$type];
    }
    public static function translateStatus($status){
        return self::$statusIntl[$status];
    }

    /**
     * Cron Job, 自动清理未签出记录
     * @return bool
     */
    public static function autoSetSignoffState(){
        $manhours = self::model()->updateAll(array('status'=>'un-sign-off'),'end_time IS NULL AND start_time < :max_start_time AND status != "un-sign-off" AND type="normal"', array(':max_start_time'=>(strtotime('now -24 hours'))));
        if(!empty($manhours)){
            return true;
        }
        return false;
    }
}
?>