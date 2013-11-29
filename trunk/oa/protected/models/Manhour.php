<?php
/**
 * The Manhour model which use to count manhour
 * @author Suley <dearsuley@gmail.com>
 * @version 1.0
 * @copyright © Beijing Backpacker Information Consulting Center
 **/
class Manhour extends ActiveRecord{
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
    /** Define Late-time **/
    const LATE_TIME = '1000';
    const EXIT_TIME = '1800';
    /** Define Type **/
    const TYPE_OUT = 'out';
    const TYPE_NORMAL = 'normal';
    public static $typeIntl = array(self::TYPE_NORMAL => '考勤',self::TYPE_OUT => '外出');
    /** Define Status **/
    const STATUS_END = 'end';
    const STATUS_START = 'start';
    const STATUS_UNSIGNED = 'un-sign-off';
    const STATUS_COMPLETE = 'complete';
    public static $statusIntl = array(self::STATUS_COMPLETE => '审核通过',self::STATUS_END => '结束，待审核', self::STATUS_START => '进行中', self::STATUS_UNSIGNED => '未签出');

    /**
     * Add new manhour record
     * @param array $data the data of manhour record
     * @version 1.0 11/25/13 08:33:08
     * @return bool
     **/
    public static function addNew(array $data = array()){
        if(!empty($data)){
            $model = new Manhour;
            $model->attributes = $data;
            if($model->type == self::TYPE_NORMAL){
                $model->status = self::STATUS_START;
            }
            if($model->save()){
                return true;
            }
        }
        return false;
    }

    /**
     * Update the manhour information
     * @param array $data the manhour record data
     * @return bool
     **/
    public static function updateInfo(array $data = array()){
        if(!empty($data)){
            $model = self::model()->findByPk($data['id']);
            unset($data['id']);
            $data['start_time'] = strtotime($data['start_time']);
            $data['end_time'] = strtotime($data['end_time']);
            $model->attributes = $data;
            if($model->save()){
                return true;
            }
        }
        return false;
    }

    /**
     * 自动清理未及时签出的记录
     */
    public function beforeFind(){
        self::autoSetSignoffState();
        Yii::log('cron job for cleaning un-stopped manhour counting record', 'info');
        return true;
    }

    /**
     * 获取工时统计列表
     * @param array $users 用户
     * @return array
     */
    public static function getManhourStatsList(array $users){
        if(empty($users)){
            $users = Yii::app()->db->createCommand('SELECT * FROM users WHERE status = "'.User::STATUS_ACTIVE.'"')->queryAll();
        }
        foreach($users as &$user){
            $user['manhour'] = self::getManhourInfo($user['id']);
        }
        return $users;
    }
    /**
     * Get manhour list by filters
     * @param array $filter
     * @param array $order
     * @param array $users
     **/
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

    /**
     * Get manhour stats array
     **/
    public static function getManhourStatInfo(array $filters = array()){
        $criteria = new CDbCriteria;
        //Filters, by project
        if(!empty($filters['project'])){
            $users = Project::getUsersOfProject($filters['project']);
            $criteria->addInCondition('user_id', $users);
        }
        if(!empty($filters['start_time'])){
            $criteria->addCondition("create_time >= ".strtotime($filters['start_time']));
        }
        if(!empty($filters['end_time'])){
            $criteria->addCondition("create_time <= ".strtotime($filters['end_time']));
        }
        return self::model()->findAll($criteria);
    }

    public static function translateManhour($time){
        $hour = intval($time/3600);
        $minutes = intval(($time%3600)/60);
        $seconds = intval(($time%60));
        $return = '';
        if(!empty($hour))
            $return = $hour."时";
        if(!empty($minutes))
            $return = $return.$minutes."分";
        if(!empty($seconds))
            $return = $return.$seconds."秒";
        if(empty($return)){
            $return = '0';
        }
        return $return;
    }

    /* Manhour Staticstic Method */

    /**
     * Get Today's Manhour stat
     * @return CActiveRecord the records of today's manhour
     **/
    public static function statOfToday(){
        $currentDate = strtotime(date('Y-m-d')." +8 hours");
        $nextDate    = strtotime(date('Y-m-d')." +1 days +8 hours");
        $result = self::statByDate($currentDate, $nextDate);
        return $result;
    }

    /**
     * Get staticstic of any month
     * @return CActiveRecord the records
     **/
    public static function statOfMonth($year, $month){
        $currentTime = $year."-".$month."-1";
        if($month == 12){
            $year++;
            $month = 1;
        }else{
            $month++;
        }
        $nextTime = $year."-".$month."-1";
        $currentDate = strtotime($currentTime);
        $nextDate = strtotime($nextTime);
        $result = self::statByDate($currentDate, $nextDate, true);
    }

    public static function statByProject(array $filters = array()){

    }

    public static function statByUser($userId, $startDate, $endDate, $filters = array()){
        $criteria = new CDbCriteria;
        $criteria->addCondition('user_id', $userId);
        $criteria->addBetweenCondition('start_time', $startDate, $endDate, 'AND');
        $criteria->addBetweenCondition('end_time', $startDate, $endDate, 'AND');
        $result = self::model()->findAll($criteria);
     }

    /**
     * Filter by date
     **/
    public static function statByDate($startDate, $endDate, $combo = false, array $filters = array()){
        $criteria  = new CDbCriteria;
        $criteria->addCondition('type', self::TYPE_NORMAL);
        $criteria->addBetweenCondition('start_time', $startDate, $endDate, 'AND');
        $criteria->addBetweenCondition('end_time', $startDate, $endDate, 'AND');
        $result = self::model()->findAll($criteria);
        if($combo){

        }
        return $result;
    }

    public static function statByDateHelperUsersSummary($result, $startDate, $endDate){
        $users = array();
        foreach($result as $record){
            if(!isset($users[$record->user_id])){
                $users[$record->user_id] = array(
                    'late_count'=>0, 'exit_count'=>0, 'attendance_count'=>0, 'overtime_count'=>0, 'leave_count'=>0
                    );
            }
            if(self::checkLateHelper($record))
                $users[$record->user_id]['late_count']++;
            if(self::checkExitHelper($record))
                $users[$record->user_id]['exit_count']++;
            $users[$record->user_id]['attendance_count']++;
        }
    }

    public static function checkLateHelper($record){
        if(intval(date('Hs', $record->start_time)) > intval(self::LATE_TIME)){
            return true;
        }else{
            return false;
        }
    }

    public static function checkExitHelper($record){
        if(intval(date('Hs', $record->end_time)) < intval(self::EXIT_TIME))
            return true;
        else
            return false;
    }

    public static function checkOverTimeHelper($record){
        if(($record->end_time - $record->start_time) > 28800)
            return true;
        return false;
    }

}
?>