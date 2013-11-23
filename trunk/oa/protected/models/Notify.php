<?php
/**
 * Created by Kimi Tourism.
 * @author Suley<luzhang@jmlvyou.com>
 * @time 13-10-29
 * @version 1.0
 * @copyright 
 **/

class Notify extends CActiveRecord{
    /**
     * 数据库结构
     * @var $title 通知的标题
     * @var $content 通知的消息内容
     * @var $route 消息指向的链接
     * @var $from_user 消息来源用户
     * @var $user_id 消息发送给谁
     * @var $is_read 消息是否已读
     */
    public $title, $content, $route, $from_user, $user_id, $is_read, $create_time;

    /**
     * 规则
     * @return array
     */
    public function rules(){
        return array(
            array('title, content,route,from_user,user_id, is_read, create_time', 'safe')
        );
    }
    public static function model($className = __CLASS__){
        return parent::model($className);
    }

    public function tableName(){
        return 'notify';
    }

    /**
     * 获得未读消息数量
     * @param $user_id
     * @return CDbDataReader|mixed|resource|string
     */
    public static function getUnreadCount($user_id){
        return self::model()->count('user_id = :user_id AND is_read = 0', array(':user_id'=>$user_id));
    }

    /**
     * 设置消息已读
     * @param $id integer 消息的id
     * @return bool
     */
    public static function setRead($id = null){
        if(isset($id)){
            self::model()->updateByPk($id, array('is_read'=>1));
            return true;
        }
        return false;
    }

    /**
     * @param $userId integer 要设置已读的用户
     * @return bool
     */
    public static function setAllRead($userId){
        if(isset($userId)){
            self::model()->updateAll(array('is_read'=>1, 'user_id = :user_id AND is_read = 0', array(':user_id'=>$userId)));
            return true;
        }
    }


    /**
     * 增加一个新通知
     * @param $message = array('title', 'content', 'route', 'from_user', 'user_id');
     * @return boolean
     */
    public function addMessage($message){
        if(!empty($message) && is_array($message)){
            $template = array('content'=>0, 'route'=>0, 'from_user'=>0, 'user_id'=>0);
            $compareResult = array_diff_key($template, $message);
            if(empty($compareResult)){
                $this->attributes = $message;
                $this->create_time = strtotime('now');
                if($this->save()){
                    return true;
                }
            }
        }
        return false;
    }
}
?>