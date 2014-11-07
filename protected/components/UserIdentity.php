<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	private $_id;

	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
        $login_type = 'pin';
	    if ($r_login = API_OA::get_OA_info_by_user($this->username, $this->password, JOHNNYTEST)) {    

                if ($r_login == 1){ //用RSA登录成功的情况
                    $result = API_OA::get_OA_info_by_id($this->username);         
                    if (empty($result)){
                        throw new CHttpException('500','用户信息不存在');
                    }   
                    $this->errorCode=self::ERROR_NONE;
                }else{
                    $login_type = 'mobile';
                    $userinfo = LogicUser::get_info_by_userid($this->username);
                    if ($userinfo['c_mobile'] == 1){  //需要启动手机验证的                        
                        $r_ad = API_OA::check_login_byad($this->username, $this->password);  //检查启动手机验证登录的pin码+附加码      
                        if ($r_ad == 1){   //成功                            
                            $result = API_OA::get_OA_info_by_id($this->username);    
                            $this->setState('mobile', $userinfo['mobile']);
                            $this->errorCode=self::MOBILE_CHECK;
                        }else{            //失败
                            return false;
                        }
                    }else{
                        return false;
                    }                                        
                }
                
                $this->_id = $result['id'];                
                $this->username = $result['displayName'];
                $this->setState('email', $result['email']);
                $this->setState('dept', $result['department']);
                $this->setState('dept_cn', $result['department_cn']);
                $this->setState('officePhone', $result['officePhone']);
                $this->setState('userAccount', $result['userAccountControl']);
                $this->setState('showRequestMenu', User::model()->showRequestMenu($result['id'], $result['department']));                
                $this->setState('author', LogicUserAuthority::get_info_by_uid($result['id']));
                $this->setState('title', $result['title']);
        } else {
	        $this->errorCode=self::ERROR_USERNAME_INVALID;
	    }

        if ($login_type === 'pin'){
            return $this->errorCode==self::ERROR_NONE;
        }else{
            return $this->errorCode==self::MOBILE_CHECK;
        }
	    
	}
	/**
	 * (non-PHPdoc)
	 * @see CUserIdentity::getId()
	 */
	public function getId(){
		return $this -> _id;
	}
}