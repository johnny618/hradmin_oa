<?php
class RequestController extends WebController {

    public function beforeAction($action) {        
        if (in_array($action->id, array('needdolist', 'donelist')) && !Yii::app()->user->showRequestMenu) {
            throw new CHttpException(404);
        }
        return true;
    }

    /**
     * 流程列表
     */
    public function actionIndex() {
        $top_menus = WorkForm::instance()->getTopMenu();
        $sub_menu = array();
        foreach ($top_menus as $key => $menu) {
            $menus = WorkForm::instance()->getSubMenu($key);
            foreach ($menus as $id => $name) {
                if (WorkFormRequest::instance()->canRequest($id)) {
                    $sub_menu[$key][$id] = $name;
                }
            }
        }
        foreach ($top_menus as $id => $name) {
            if (!isset($sub_menu[$id])) {
                unset($top_menus[$id]);
            }
        }
        $data = array();
        $i = 0;
        foreach ($top_menus as $key => $top_meun) {
            $data[$i%3][] = array('id' => $key, 'value' => $top_meun);
            $i++;
        }
        $top_menus = $data;
        $this->render('index', array('top_menus' => $top_menus, 'sub_menu' => $sub_menu));
    }

    public function actionNew($id) {
        $node_id = Bll_Form::find_init_node_id($id);
        if (!$node_id) {
            throw new CHttpException(500, '请管理员先设置节点信息字段');
        }
        $current_form_node = FormNode::model()->findByPk($node_id);
        $this->render('new', array('id' => $id, 'current_form_node' => $current_form_node));
    }

    public function actionEdit($id) {
        $request = WorkFormRequest::instance()->findByPk($id);
        if (!$request || $request->uid != Yii::app()->user->id || $request->status != 0) {
            throw new CHttpException(500, '当前状态不能编辑');
        }
        $node_id = Bll_Form::find_init_node_id($request->fid,$id);
        if (!$node_id) {
            throw new CHttpException(500, '请管理员先设置节点信息字段');
        }
        $current_form_node = FormNode::model()->findByPk($node_id);
        $this->render('edit', array('id' => $id, 'current_form_node' => $current_form_node, 'request' => $request));
    }

    public function actionShow($id) {
        if (in_array(Yii::app()->user->id, MyConst::$ad_users) || LogicFormRequest::check_show_by_id_uid($id) || LogicRequestProcess::check_show_by_request_id_uid($id)) {
            $current_node_id = Bll_Form::get_current_node_by_requestId($id);
            $request = WorkFormRequest::instance()->findByPk($id);
            $node_id = Bll_Form::find_init_node_id($request->fid,$id);
            $current_form_node = FormNode::model()->findByPk($current_node_id);
            if (!$current_form_node) {
                throw new CHttpException(500, '请管理员先设置节点信息字段');
            }
            $this->render('show', array('id' => $id, 'current_form_node' => $current_form_node, 'request' => $request));
        }else{
            throw new CHttpException(500,'請不要看！');
        }

    }

    public function actionDo($id) {
        $request = WorkFormRequest::instance()->findByPk($id);
        if (!$request) {
            throw new CHttpException(500, '当前状态不能编辑');
        }
        $request_process = RequestProcess::instance()->find('request_id=:request_id order by id desc', array('request_id' => $id));
        if (!Bll_Form::check_operation($request_process->next_status, $id)) {
            throw new CHttpException(500, '无权访问');
        }
        $current_form_node = FormNode::instance()->findByPk($request_process->next_status);
        if (!$current_form_node) {
            throw new CHttpException(500, '请管理员先设置节点信息字段');
        }
        $params = $this->params();
        if (isset($params['type']) && $params['type'] == 'mobile') {
            $this->layout = '//';
            $this->render('do_mobile', array('id' => $id, 'current_form_node' => $current_form_node, 'request' => $request, 'request_process' => $request_process));
        } else {
            $this->render('do', array('id' => $id, 'current_form_node' => $current_form_node, 'request' => $request, 'request_process' => $request_process));
        }
    }

    public function actionDoMobile($id) {
        $this->layout = '//';
        $request = WorkFormRequest::instance()->findByPk($id);
        if (!$request) {
            throw new CHttpException(500);
        }
        $request_process = RequestProcess::instance()->find('request_id=:request_id order by id desc', array('request_id' => $id));
        $current_form_node = FormNode::instance()->findByPk($request_process->next_status);
        if (!$current_form_node) {
            throw new CHttpException(500, '请管理员先设置节点信息字段');
        }
        $nodes = array('show' => explode(',', $current_form_node->show));
        $main_items = WorkFormItem::instance()->findAll('type = 0 and field_type not in (101, 102) and fid=' . $request->fid . ' order by dsporder desc');
        $detail_items = WorkFormItem::instance()->findAll('type <> 0 and fid=' . $request->fid . ' order by dsporder desc');
        $_detail_items = array();
        if ($detail_items) foreach ($detail_items as $detail_item) {
            $_detail_items[$detail_item->db_field_name] = $detail_item->attributes;
        }
        $next_node = Bll_Form::get_form_info_by_request_id($request->id, $request_process->status);
        $this->render('do_mobile', array('next_node' => $next_node, 'id' => $id, 'current_form_node' => $current_form_node, 'request' => $request, 'request_process' => $request_process, 'nodes' => $nodes, 'main_items' => $main_items, 'detail_items' => $_detail_items));
    }

    public function actionMy() {
        $params = $this->params();
        if (!in_array($params['type'], array(0, 1, 999))) {
            throw new CHttpException(404);
        }
        $CDbCriteria = new CDbCriteria;        
        if (isset($params['type']) && $params['type'] == '999'){            
            $CDbCriteria->compare('status', $params['type']);            
        }else{
            $CDbCriteria->compare('status', array(0,1)); 
        }               
        $CDbCriteria->compare('isDelete', 0);
        $CDbCriteria->compare('uid', Yii::app()->user->id);
        $CDbCriteria->order = 'created desc';
        $count = WorkFormRequest::model()->count($CDbCriteria);
        $pager = new CPagination($count);
        $pager->pageSize = 10;
        $pager->applyLimit($CDbCriteria);
        $requests = WorkFormRequest::model()->findAll($CDbCriteria);        
        $this->render('my', array('requests' => $requests, 'type' => $params['type'], 'pager' => $pager));
    }

    public function actionNeedDoList() {
        $find_handle_count = Bll_Form::find_need_show_form_count();
        $page = MyTool::paging($find_handle_count, $currentPage = 1, $page_size = 15);
        $currentPage = $page['cur'];
        $find_handle_forms = Bll_Form::find_need_show_form_info($currentPage,$page_size);

        $request_ids = array();
        foreach ($find_handle_forms as $form) {
            $request_ids[] = $form['request_id'];
        }
        $forms = array();
        if (!empty($request_ids)){
            $forms = LogicFormRequest::get_done_list_by_request_id($request_ids);
        }
        //$forms = WorkFormRequest::instance()->findAllByPk($request_ids);
        $this->render('need_do_list', array('find_handle_forms' => $find_handle_forms, 'forms' => $forms,'page'=>$page));
    }

    public function actionDonelist(){
        /**
         * 分页
         */
        $rows_count = Bll_Form::getDoneListCount();    //得到数据条目总数
        $page = MyTool::paging($rows_count, $currentPage = 1, $page_size = 15);
        $currentPage = $page['cur'];
        $rows = Bll_Form::getDoneList($currentPage, $page_size);
        $this->render('donelist',array('rows'=>$rows,'page'=>$page, 'rows_count'=>$rows_count));
    }

    public function actionTest() {
        $RedisList = new ARedisList("Mail");
        echo $RedisList->count();
        if (isset($_GET['token'])) {
            $redis = new ARedisCache();
            $token = $redis->get($_GET['token']);
            var_dump($token);
        }
    }

    public function actionMail() {
        $Mail = new Mail();
        $Mail->mail('linjia@yiban.cn', 'test', 'test');
    }

}