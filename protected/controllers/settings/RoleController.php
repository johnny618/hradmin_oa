<?php
/**
 * 表单
 * @author JohnnyLin
 *
 */
class RoleController extends WebController {

    public function actionIndex(){
        $params = $this->params();
        if (isset($params['role_id'])) {
            Role::instance()->deleteAll('id in (:role_id)', array('role_id' => implode(',', $params['role_id'])));
            RoleInfo::instance()->deleteAll('roleid in (:roleid)', array('roleid' => implode(',', $params['role_id'])));
        }
        $roles = LogicRole::get_role_and_count();
        $this->render('list', array('roles' => $roles));
    }

    public function actionRoleEdit($id){
        $deptArr = API_OA::get_all_dept();
        $role = Role::instance()->findByPk($id);
        if (!$role) {
            $role = new Role;
        }
        $params = $this->params();
        if (isset($params['Role'])) {
            $role->attributes = $params['Role'];
            if ($role->save()) {
                if (isset($params['role_ids'])) {
                    $role_ids = array_filter(array_unique(explode(',', $params['role_ids'])));
                    if (count($role_ids)) {
                        RoleInfo::instance()->deleteAll('roleid=:roleid', array('roleid' => $role->getPrimaryKey()));
                        foreach ($role_ids as $rid) {
                            $role_info = new RoleInfo;
                            $role_info->roleid = $role->getPrimaryKey();
                            $role_info->userid = $rid;
                            $role_info->save();
                        }
                    }
                }
                $this->redirect($this->createUrl('/settings/role/roleedit/' . $role->getPrimaryKey()));
            }
        }
        $role_infos = RoleInfo::instance()->findAll('roleid=:roleid', array('roleid' => $id));
        $this->render('edit',array('deptArr'=>$deptArr, 'role' => $role, 'role_infos' => $role_infos));
    }

    public function actionAjax(){
        $params = $this->params();
        $res = $this->_res;
        switch($params['type']) {
            case 'getroleinfo':
                $data = LogicRole::get_like_name($params['searchtxt']);
                $html = '';
                if (!empty($data)){
                    foreach($data as $dataKey => $dataVal){
                        $html .= '<li class="aut_jusbg"><span class="fl" id="'.$dataVal['id'].'" name="roles">'.$dataVal['name'].'</span><div for="'.$dataVal['id'].'" class="aut_justxt_bg"></div></li>';
                    }
                }
                $res = $this->init_res($html);
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