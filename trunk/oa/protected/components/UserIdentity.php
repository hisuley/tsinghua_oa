<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	public $username, $role, $realname;
	private $_id;
	private $_role;

 	
    public function authenticate()
    {
        $username=strtolower($this->username);
        $user=User::model()->find('LOWER(username)=?',array($username));
        if($user===null)
            $this->errorCode=self::ERROR_USERNAME_INVALID;
        else if(!$user->validatePassword($this->password,$user->password))
            $this->errorCode=self::ERROR_PASSWORD_INVALID;
        else
        {
            $this->_id=$user->id;
            $this->username=$user->username;
            $this->realname = $user->realname;
            $this->role = $user->role;
            $this->setState('role', $user->role);
            $this->setState('email', $user->email);
            $this->setState('realname', $user->realname);
            // $this->setState('stats', $user->stats());
            $this->_role = $user->role;
            $this->errorCode=self::ERROR_NONE;
        }
        return $this->errorCode==self::ERROR_NONE;
    }
 
    public function getId()
    {
        return $this->_id;
    }
    public function getRole(){
    	return $this->_role;
    }
    public function getUsername(){
    	return $this->username;
    }
}