<?php
/**
 * Created by Kimi Tourism.
 * @author Suley<luzhang@jmlvyou.com>
 * @time 13-11-1
 * @version 1.0
 * @copyright 
 **/

class GlobalMenuWidget extends CWidget{
    public $role;
    public static $menu = array(
        ''
    );
    public function run(){
        if(!empty($this->role)){
            switch($this->role){
                case 'admin':
                    $this->adminWidget();
                    break;
                case 'staff':
                    $this->staffWidget();
                    break;
                case 'manager':
                    $this->managerWidget();
                    break;
                case 'project-manager':
                    $this->projectManagerWidget();
                    break;
                case 'superintendent':
                    $this->superIntendentWidget();
                    break;
                default:
                    break;
            }
        }
    }
    public function adminWidget(){

    }
    public function staffWidget(){

    }
    public function managerWidget(){

    }
    public function projectManagerWidget(){

    }
    public function superIntendentWidget(){

    }
}