<?php
class WebController extends CController {

    public function init() {
        if (isset($_GET['token'])) {
            $url='http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"];         
//            $n=strpos($url,'?');//寻找位置
//            if ($n){ 
//                $str=substr($url,0,$n);//删除后面     
//            }  
            setcookie('defaulturl',$url,time()+300,'/'); 
            $redis = new ARedisCache();
            $token = $redis->get($_GET['token']);
            if (!$token) {
                throw new CHttpException(500, 'token失效');
            }
            $identity = new UserIdentity($token, 1);
            if($identity->authenticate(true)) {
                Yii::app()->user->login($identity);
            }
        }

        if (Yii::app()->user->isGuest || !isset($_COOKIE['islogin'])) {
                setcookie('islogin',0,time()-1,'/');
                echo '<script>parent.document.location.href = "' . $this->createUrl('/login') . '"</script>';
                exit;
        }
        if (strpos($this->getRoute(), 'settings/') !== false && !in_array(Yii::app()->user->id, MyConst::$ad_users)) {
            if (strpos($this->getRoute(), 'settings/formview') === false) {
                exit;
            }
        }
    }
}