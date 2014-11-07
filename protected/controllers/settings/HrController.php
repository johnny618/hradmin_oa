<?php
/**
 * 查询人员
 * @author grant
 *
 */
class HrController extends WebController {

    public function actionSearch(){        
        $params = array_filter($this->params());
        $result = array();
        $CDbCriteria = new CDbCriteria;    
        $CDbCriteria->order='uid ';
        if (isset($params['id']) && Validate::digit($params['id'])) {
            $CDbCriteria->compare('uid', $params['id']);
        }
        if (isset($params['uname'])) {
            $CDbCriteria->compare('uname', $params['uname'], true);
        }
        if (isset($params['dept'])) {
            $CDbCriteria->compare('dept_cn', $params['dept'], true);
        }
        $count = User::model()->count($CDbCriteria);
        $pager = new CPagination($count);
        $pager->pageSize = 10;
        $pager->applyLimit($CDbCriteria);
        $result = User::model()->findAll($CDbCriteria);
        $this->render('search', array('result' => $result, 'pager' => $pager));
    }

    public function actionEdit($id) {
        $deptArr = API_OA::get_all_dept();
        $user = User::model()->findByPk($id);
        if (!$user) {
            throw new CHttpException(404, '用户不存在');
        }
        $params = $this->params();
        if (isset($params['leader_id'])) {
            $user->leader_id = $params['leader_id'];
            if ($user->save()) {
                if (isset($params['reffer'])) {
                    echo '<script>location.href="' . $params['reffer'] . '"</script>';
                    exit(0);
                } else {
                    $this->redirect($this->createUrl('/settings/hr/search'));
                }
            }
        }
        $this->render('edit', array('user' => $user, 'deptArr' => $deptArr));
    }
    
    public function actionAuthority($id){
        $deptArr = API_OA::get_all_dept();                
        $user = User::model()->findByPk($id);           
        $menu = LogicUserAuthority::get_info_by_uid($user->uid);        
        if (!$user) {
            throw new CHttpException(404, '用户不存在');
        }        
        $this->render('authority', array('user' => $user,'deptArr' => $deptArr,'menu'=>$menu));        
    }
    
    
    public function actionAjax(){
        $params = $this->params(); 
        $res = $this->_res;     
        
        switch($params['type']) {
            case 'setauthor':                               
                if (!empty($params['uid'])){
                    $WhereArr = array('uid'=>$params['uid']);
                    LogicUserAuthority::delete_info_by_uid($WhereArr);
                }
                if (!empty($params['data'])){
                    foreach($params['data'] as $Key => $Val){
                        $DataArr = array('uid'=>$params['uid'],'menuCode'=>$Val,'creater'=>  Yii::app()->user->id ,'created'=>time() );
                        LogicUserAuthority::insert_data_info($DataArr);
                    }                    
                }                
                $res = $this->init_res();
                break;
            case 'delete_data':
                if (!empty($params['uid'])){
                    Bll_Form::close_user($params['uid']);
                    $WhereArr = array('uid'=>$params['uid']);
                    LogicUser::delete_data_info($WhereArr);
                    $res = $this->init_res();
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
    
    private function init_res($result = null){
        $_res = array(
            "code" => "success",
            "mes" => "成功！",
            "info" => $result,
        );
        return $_res;
    }
    
}