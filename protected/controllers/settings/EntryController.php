<?php
/**
 * 员工入职
 * @author JohnnyLin
 *
 */
class EntryController extends WebController {

    public function actionIndex(){             
        $deptArr = API_OA::get_all_dept();
        $this->render('index',array('deptArr'=>$deptArr));
    }

    public function actionEntry(){
        $params = $this->params();
        $result = LogicUser::check_exite_by_uid($params['uid']);                    
        if (!empty($result)) {
            throw new CHttpException('500','员工工号已存在');
            exit(0);
        }
        
        if (!empty($params['uid']) && !empty($params['sur']) && !empty($params['give']) && !empty($params['name']) && !empty($params['name_cn']) 
                && !empty($params['email']) && !empty($params['phone']) && !empty($params['deptid']) && !empty($params['title']) ){
                    $DataArr = array('uid'=>$params['uid'],
                        'uname'=>$params['name_cn'],
                        'dept_id'=>$params['deptid'],
                        'dept_cn'=>$params['dept'],
                        'email'=>$params['email'],
                        'user_account'=>66048
                    );
                    $result = LogicUser::insert_user_info($DataArr);                    
                    if (!empty($result)){
                        //id=员工工号&giveName=名&surName=姓&name=拼音名&displayName=中文名&email=邮箱&officePhone=座机&department=部门&title=职位&division=小部门
                        $api_result = API_OA::insert_Account($params['uid'], $params['give'], $params['sur'], $params['name'], $params['name_cn'], $params['email'], $params['phone'], $params['deptid'], $params['title'], $params['division']);                        
                        if ($api_result == 'ok'){
                            echo '<script>location.href="'.Yii::app()->createUrl('/settings/hr/search/').'"</script>';
                            exit;
                        }else{
                            throw new CHttpException('500','接口插入数据库失败');
                            exit(0);
                        }
                    }else{
                        throw new CHttpException('500','插入数据库失败');
                        exit(0);
                    }
                }
    }
    
    public function actionEdit(){  
        $params = $this->params();
        if (empty($params['uid'])){
            throw new CHttpException('500','请选择员工');
            exit(0);
        }
        $deptArr = API_OA::get_all_dept();
        $userinfo = API_OA::get_OA_info_by_id($params['uid']);      
        $userother = LogicUser::get_info_by_userid($params['uid']);        
        $is_mobile = array(0 => '否',1 => '是');
        $this->render('modify',array('deptArr'=>$deptArr,'user'=>$userinfo,'userother'=>$userother,'is_mobile'=>$is_mobile));        
    }
    
    public function actionModify(){
        $params = $this->params();                
        if (!empty($params['uid']) && !empty($params['sur']) && !empty($params['give']) && !empty($params['name_cn']) 
                && !empty($params['email']) && !empty($params['phone']) && !empty($params['deptid']) && !empty($params['title']) ){
                    $DataArr = array(
                        'uname'=>$params['name_cn'],
                        'dept_id'=>$params['deptid'],
                        'dept_cn'=>$params['dept'],
                        'email'=>$params['email'],
                        'leader_id'=>null,
                        'user_account'=>66048,
                        'mobile'=>$params['mobile'],
                        'c_mobile'=>$params['c_mobile'],
                    );
                    $WhereArr = array('uid'=>$params['uid']);
                    LogicUser::update_user_info($DataArr,$WhereArr);
                    //id=员工工号&giveName=名&surName=姓&displayName=中文名&email=邮箱&officePhone=座机&department=部门&title=职位&division=小部门
                    $api_result = API_OA::update_Account($params['uid'], $params['give'], $params['sur'], $params['name_cn'], $params['email'], $params['phone'], $params['deptid'], $params['title'], $params['division']);                        
                    if ($api_result == 'ok'){
                        echo '<script>location.href="'.Yii::app()->createUrl('/settings/hr/search/').'"</script>';
                        exit;
                    }else{
                        throw new CHttpException('500','接口插入数据库失败');
                        exit(0);
                    }
                    
                }
    }
}