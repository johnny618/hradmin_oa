<?php
class LoginController extends CController {

    public function actionIndex() {
        if (isset($_COOKIE['islogin'])){
            setcookie('islogin',0,time()-1,'/');
        }

        if (!Yii::app()->user->isGuest) {
            echo '<script>top.location.href = "' . $this->createUrl('/login') . '"</script>';
            Yii::app()->user->logout();
        }
        $model = new UserForm;
        if (isset($_POST['UserForm'])) {
            $model->attributes = $_POST['UserForm'];
            if ($model->validate()) {
                $identity = new UserIdentity($model->username, $model->password);                  
                if($identity->authenticate()) {
                    Yii::app()->user->login($identity);
                    $user = User::instance()->find('uid=:uid', array('uid' => Yii::app()->user->id));
                    if (!$user) {
                        $user = new User;
                    }                    
                    $user->uid = Yii::app()->user->id;
                    $user->uname = Yii::app()->user->name;
                    $user->dept_id = Yii::app()->user->dept;
                    $user->dept_cn = Yii::app()->user->dept_cn;
                    $user->email = Yii::app()->user->email;
                    $user->user_account = Yii::app()->user->userAccount;
                    $user->save();         
                    setcookie('loginuid',Yii::app()->user->id,time()+3600*24);
                  
                  
                    if ($identity->errorCode == 999){
                        if (!empty(Yii::app()->user->mobile)){
                            $send_status = API_OA::sendmsg(Yii::app()->user->mobile);                            
                            if ($send_status['status']){
                                $this->redirect(Yii::app()->createUrl('/login/msgcode'));
                                exit;
                            }else{
                                $model->addError('username', '短信发送失败');
                            }   
                        }else{
                            $model->addError('username', '该工号没有绑定手机号');
                        }                        
                    }
                    
                    if ($identity->errorCode == 0){
                        setcookie('islogin',1,time()+3600*24,'/');
                        if (isset($_COOKIE['defaulturl']) ){                                 
                            echo '<script>location.href = "'.$_COOKIE['defaulturl'].'"</script>';
                            exit;
                        }
                        $this->redirect($this->createUrl('/index'));
                    }
                    
                } else {
                    $model->addError('username', '用户名密码不匹配');
                }
            }
        }
        $this->render('index', array('model' => $model));
    }

    public function actionOut() {
        Yii::app()->user->logout();
        echo '<script>top.location.href = "' . $this->createUrl('/login') . '"</script>';
        exit;
    }     
    
    public function actionMsgcode(){
        $model = new MobileForm;
        if (isset($_POST['MobileForm'])) {
            $model->attributes = $_POST['MobileForm'];
            if ($model->validate()) {
                if (!empty(Yii::app()->user->mobile) && !empty($model->password)){
                    $result = API_OA::checkVerificationCode(Yii::app()->user->mobile,$model->password);
                    if ($result['status']){
                        setcookie('islogin',1,time()+3600*24,'/');
                        if (isset($_COOKIE['defaulturl']) ){                                 
                            echo '<script>location.href = "'.$_COOKIE['defaulturl'].'"</script>';
                            exit;
                        }
                        $this->redirect($this->createUrl('/index'));
                    }else{
                        $model->addError('username', '验证码错误');     
                    }
                    
                }         
            }
        }
        $this->render('msgcode',array('model' => $model));
    }
    
    public function actionAjax(){
        $params = $this->params(); 
        $res = $this->_res;             
        switch($params['type']) {
            case 'ag_msg':
                if (!empty(Yii::app()->user->mobile)){
                    $send_status = API_OA::sendmsg(Yii::app()->user->mobile);                            
                    if ($send_status['status']){
                        $res = $this->init_res('success','短信发送成功');
                    }else{
                        $res = $this->init_res('error','短信发送失败');
                    }   
                }else{
                    $res = $this->init_res('error','该工号没有绑定手机号');
                }  
                break;              
            default :
                $res = $this->_res;
                break;
        }
        echo json_encode($res);
        exit;  
    }
    
    private $_res = array(
        "code" => "error",
        "mes" => "操作失败！",
        "info" => array(),
    );
    
    private function init_res($status='success',$result = null){
        $_res = array(
            "code" => $status,
            "mes" => "成功！",
            "info" => $result,
        );
        return $_res;
    }
}