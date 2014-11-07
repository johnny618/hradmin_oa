<?php
class API_OA{

    public static function get_all_dept(){
        $url = MyConst::OA_API_URL.'/getdept';
        $json_data = self::postData($url);
        $result = json_decode($json_data,true);        
        return  $result;
    }


    public static function get_employees_by_dept($deptid){
        $url = MyConst::OA_API_URL.'/getdept_users?dept='.$deptid;
        $json_data = self::postData($url);
        $array = json_decode($json_data,true);
        return  $array;
    }
    
    /**
     * 重置RSA的pin码，及附加码
     * id=工号&pin=RSA的pin码&addpw=附加码&password=RSA动态密码
     * @param 修改成功返回ok，修改失败返回error
     */
    public static function reset_password_by_uid($pwd,$notepwd,$RSA){
        $params = array('id'=>Yii::app()->user->id,'pin'=>$pwd,'addpw'=>$notepwd,'password'=>$RSA);
        $url = MyConst::OA_API_URL.'/resetPassword?'.http_build_query($params);                   
        return self::postData($url);
    }
    
    /**
     * 检查邮箱是否重复
     * email=邮箱地址
     * @param 可以使用返回ok，有重复返回repeat，系统问题返回0
     */
    public static function check_Email($email){
        $params = array('email'=>$email);
        $url = MyConst::OA_API_URL.'/checkEmail?'.http_build_query($params);
        return self::postData($url);
    }
    
    /**
     * 开通OA帐号，开通后，约5分钟生效，可能存在意外失败的情况，尝试重新提交便可
     * id=员工工号&giveName=名&surName=姓&name=拼音名&displayName=中文名&email=邮箱&officePhone=座机&department=部门&title=职位&division=小部门
     * @param 插入成功返回ok，插入失败返回error
     */
    public static function insert_Account($uid,$giveName,$surName,$name,$displayName,$email,$officePhone,$department,$title,$division=''){
        if (!empty($division)){
            $params = array('id'=>$uid,
                'giveName'=>$giveName,
                'surName'=>$surName,
                'name'=>$name,
                'displayName'=>$displayName,
                'email'=>$email,
                'officePhone'=>$officePhone,
                'department'=>$department,
                'title'=>$title,
                'division'=>$division
            );
        }else{
            $params = array('id'=>$uid,
                'giveName'=>$giveName,
                'surName'=>$surName,
                'name'=>$name,
                'displayName'=>$displayName,
                'email'=>$email,
                'officePhone'=>$officePhone,
                'department'=>$department,
                'title'=>$title
            );
        }
        
        $url = MyConst::OA_API_URL.'/insertAccount?'.http_build_query($params);          
        return self::postData($url);
    }
    
    /**
     * 修改OA帐号，修改后，约5分钟生效，员工拼音名字暂时不可修改
     * id=员工工号&giveName=名&surName=姓&displayName=中文名&email=邮箱&officePhone=座机&department=部门&title=职位&division=小部门
     * @param 修改成功返回ok，修改失败返回error
     */
    public static function update_Account($uid,$giveName,$surName,$displayName,$email,$officePhone,$department,$title,$division=''){
        if (!empty($division)){
            $params = array('id'=>$uid,
                'giveName'=>$giveName,
                'surName'=>$surName,            
                'displayName'=>$displayName,
                'email'=>$email,
                'officePhone'=>$officePhone,
                'department'=>$department,
                'title'=>$title,            
                'division'=>$division
            );
        }else{
            $params = array('id'=>$uid,
                'giveName'=>$giveName,
                'surName'=>$surName,            
                'displayName'=>$displayName,
                'email'=>$email,
                'officePhone'=>$officePhone,
                'department'=>$department,
                'title'=>$title,                            
            );
        }        
        $url = MyConst::OA_API_URL.'/updateAccount?'.http_build_query($params);       
        return self::postData($url);
    }
    
    /**
     * 根据用户和pin码加附加码登录 验证成功返回1，验证失败返回0
     * @param type $usr
     * @param type $pwd
     * @return type
     */
    public static function check_login_byad($usr,$pwd){
        $params = array('usr'=>$usr,'pwd'=>$pwd);
        $url = MyConst::OA_API_URL.'/byAd?'.http_build_query($params);
        $json_data = self::postData($url);
        return json_decode($json_data,true);
    }

    public static function get_OA_info_by_user($usr,$pwd, $test = false){        
        $params = array('usr'=>$usr,'pwd'=>$pwd);
        if ($test) {
            $url = MyConst::OA_API_URL.'/byrsa_test?'.http_build_query($params);
        } else {            
            $url = MyConst::OA_API_URL.'/byrsa?'.http_build_query($params);
        }        
        $json_data = self::postData($url);
        return json_decode($json_data,true);
    }


    public static function get_OA_info_by_id($id){
        $url = MyConst::OA_API_URL.'/getuserinfo?id='.$id;
        $json_data = self::postData($url);
        $array = json_decode($json_data,true);
        return  $array;
    }
    
    /**
     * 固定资产接口 START
     */
    public static function get_assets_by_id($id){
        $url = 'http://10.21.5.32/fixed_assets/views/user?id='.$id;
        $json_data = self::postData($url);
        $array = json_decode($json_data,true);
        return  $array;
    }
    
    public static function get_assets_all(){
        $url = 'http://10.21.5.32/fixed_assets/views/all';
        $json_data = self::postData($url);
        $array = json_decode($json_data,true);
        return  $array;
    }
    
    public static function get_assets_by_classify($params = array()){
        $url = 'http://10.21.5.32/fixed_assets/views/classify?'.http_build_query($params);
        $json_data = self::postData($url);
        $array = json_decode($json_data,true);
        return  $array;
    }
    
    /**
     * 固定资产接口 END
     */


    /**
     * 郵箱接口 获取邮件组
     */
    public static function get_mail_list(){
        $url = MyConst::OA_API_URL.'/getMaillist';
        $json_data = self::postData($url);
        return json_decode($json_data,true);
    }

    /**
     * 郵箱接口 开通邮箱
     * id=工号&email=邮箱地址&disname=邮箱中显示的名字&dept=邮箱组
     * 成功返回ok，失败返回error
     */
    public static function open_mail($id,$email,$disname,$dept){
        $params = array('id'=>$id,'email'=>$email,'disname'=>$disname,'dept'=>$dept);
        $url = MyConst::OA_API_URL.'/insertMail?'.http_build_query($params);
        return self::postData($url);
    }

    /**
     * 郵箱接口 关闭邮箱
     * id=工号
     * 成功返回ok，失败返回error
     */
    public static function close_mail($id){
        $params = array('id'=>$id);
        $url = MyConst::OA_API_URL.'/disableMail?'.http_build_query($params);
        return self::postData($url);
    }


    /**
     * 网络权限接口 获取网络权限组
     * 所有的网络权限
     */
    public static function get_power_list(){
        $url = MyConst::OA_API_URL.'/getallpower';
        $json_data = self::postData($url);
        return json_decode($json_data,true);
    }

    /**
     * 网络权限接口 获取用户网络权限
     * 请求参数:id=员工ID
     * 返回值: 用户所拥有的网络权限，json格式
     */
    public static function get_user_power($id){
        $params = array('id'=>$id);
        $url = MyConst::OA_API_URL.'/getUsrpower?'.http_build_query($params);
        $json_data = self::postData($url);
        return json_decode($json_data,true);
    }

    /**
     * 网络权限接口 增加用户网络权限
     * 请求参数:id=工号&power=权限名
     * 返回值: 成功返回ok，失败返回error
     */
    public static function add_user_power($id,$power){
        $params = array('id'=>$id,'power'=>$power);
        $url = MyConst::OA_API_URL.'/addPower?'.http_build_query($params);
        return self::postData($url);
    }

    /**
     * 网络权限接口 删除用户网络权限
     * 请求参数:id=工号&power=权限名
     * 返回值: 成功返回ok，失败返回error
     */
    public static function del_user_power($id,$power){
        $params = array('id'=>$id,'power'=>$power);
        $url = MyConst::OA_API_URL.'/delPower?'.http_build_query($params);
        return self::postData($url);
    }

    /**
     * URL:http://10.21.5.30/disableUser
     * HTTP请求方式:GET
     * 请求参数:id=工号
     * 返回值: 成功返回ok，失败返回error
     */
    public static function closeUser($id){
        $params = array('id'=>$id);
        $url = MyConst::OA_API_URL.'/disableUser?'.http_build_query($params);
        return self::postData($url);
    }


    public static function postData($url){
        $ch = curl_init();
        $timeout = 300;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $handles = curl_exec($ch);
        curl_close($ch);
        return $handles;
    }

    
    //http://10.21.118.240/wiki/doku.php?id=newclinet&#%E5%90%91%E7%94%A8%E6%88%B7%E6%89%8B%E6%9C%BA%E5%8F%91%E9%80%81%E9%AA%8C%E8%AF%81%E7%A0%81
    public static function sendmsg($mobile = '15900678785'){
        $info = array(
            'phone'       => $mobile,      //手机号, 必传参数 
            'numLimit'    => 6,            //验证码位数， 默认为 4 位 (纯数字)
            'expire'      => 300,          //验证码有效时间(秒), 默认为 900 秒
            'dailyLimit'  => 0             //是否需要每天次数限制方式进行发送
                                           //  默认为 1 需要限制， 反之为 0
        );
        return YbApiClient::factory('Sms')->sendVerificationCode($info);
    }
    
    public static function checkVerificationCode($mobile,$code){
        return YbApiClient::factory('Sms')->checkVerificationCode($mobile,$code);
    }

}
?>
