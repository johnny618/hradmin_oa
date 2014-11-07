<?php
/**
 * OA_API AJAX接口控制器
 * @author JohnnyLin
 *
 */
class ApiajaxController extends WebController {    
    public function actionAjax(){
        $params = $this->params();
        $res = $this->_res;             
        switch($params['type']) {
            case 'resetPassword':
                if (!empty($params['pin']) && !empty($params['addpw']) && !empty($params['rsa'])){
                    $result = API_OA::reset_password_by_uid($params['pin'],$params['addpw'],$params['rsa']);
                    if ($result == 'ok'){
                        $res = $this->init_res();
                    }
                }
                break;  
            case 'check_Email':
                if (!empty($params['email'])){
                    $result = API_OA::check_Email($params['email']);
                    if ($result == 'ok'){
                        $res = $this->init_res();
                    }
                }
                break;   
            case 'checkEamil':
                if (!empty($params['email']) && !empty($params['uid'])){
                    $result = LogicUser::check_email_by_uid($params['uid'],$params['email']);
                    if (empty($result)){
                        $res = $this->init_res();
                    }
                }
                break;
            case 'check_uid':                
                if (!empty($params['uid'])){
                    $result = LogicUser::check_exite_by_uid($params['uid']);                    
                    if (empty($result)) {
                        $res = $this->init_res($result);
                    }
                }
                break;
            case 'getdeptinfo':
                if (!empty($params['deptid'])){
                    $result = API_OA::get_employees_by_dept($params['deptid']);                                        
                    $html = '';
                    foreach($result as $resultKey => $resultVal){
                        $html .= '<li><span style="cursor:pointer" id="e_'.$resultKey.'" class="fl" ondblclick="javascript:addemployee(this)" data-id="' .$resultKey  . '">'.$resultVal.'</span></li>';
                    }
                    $res = $this->init_res($html);
                }
                break;
            case 'openmail':
                if (!empty($params['uid']) && !empty($params['uname']) && !empty($params['email']) && !empty($params['dept'])){
                    $result = API_OA::check_Email($params['email']);
                    if ($result == 'ok'){
                        $open_mail_result = API_OA::open_mail($params['uid'],$params['email'],$params['uname'],$params['dept']);
                        if ($open_mail_result == 'ok'){
                            $res = $this->init_res();
                        }else{
                            $res = $this->error_res('邮箱开通失败');
                        }
                    }else{
                        $res = $this->error_res('邮箱已重复');
                    }
                }
                break;
            case 'openpower':
                if (!empty($params['uid']) && !empty($params['power'])){
                    $result = API_OA::add_user_power($params['uid'],$params['power']);
                    if ($result == 'ok'){
                        $res = $this->init_res();
                    }else{
                        $res = $this->error_res('網絡權限开通失败');
                    }
                }
                break;
            case 'getpower':
                if (!empty($params['uid']) ){
                    $res = $this->init_res(API_OA::get_user_power($params['uid']));
                }
                break;
            case 'deletepower':
                if (!empty($params['uid']) && !empty($params['power'])){
                    $result = API_OA::del_user_power($params['uid'],$params['power']);
                    if ($result == 'ok'){
                        $res = $this->init_res();
                    }else{
                        $res = $this->error_res('網絡權限刪除失败');
                    }
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

    private function error_res($result = ''){
        return array(
            "code" => "error",
            "mes" => "操作失败！",
            "info" => $result,
        );
    }

    private function init_res($result = null){
        $_res = array(
            "code" => "success",
            "mes" => "成功！",
            "info" => $result,
        );
        return $_res;
    }
    
}