<?php
class RequestTableWidget extends CWidget {

    public $fid;

    public $current_form_node;

    public $is_edit = false;

    public $request;

    public $is_approve = false;

    public $request_process = false;

    public $is_show = false;

    public function run() {
        $work_form = WorkForm::instance()->findByPk($this->fid);
        if (!$work_form || $work_form->pid == 0 || $work_form->isDelete == 1 || $work_form->dsporder < 0) {
            throw new CHttpException(404);
        }
        $default_items = WorkFormItem::instance()->findAll('field_type in (101, 102) and fid = ' . $this->fid);
        if (!$default_items) {
            throw new CHttpException(404);
        }
        $nodes = array('show' => explode(',', $this->current_form_node->show), 'edit' => explode(',', $this->current_form_node->edit));
        $main_items = WorkFormItem::instance()->findAll('type = 0 and field_type not in (101, 102) and fid=' . $this->fid . ' order by dsporder asc');
        $detail_items = WorkFormItem::instance()->findAll('type <> 0 and fid=' . $this->fid . ' order by dsporder asc');
        $_detail_items = array();
        if ($detail_items) foreach ($detail_items as $detail_item) {
            $_detail_items[$detail_item->type][] = $detail_item;
        }
        $columns = $request = array();
        if ($this->is_edit || $this->is_approve) {
            $results = Yii::app()->db->createCommand('select db_field_name,field_name from work_form_item where fid=' . $this->request->fid)->queryAll();
            foreach ($results as $result) {
                $columns[$result['db_field_name']] = $result['field_name'];
            }
            $request = $this->request->attributes;
            $request['dept_cn'] = $this->request->User ? $this->request->User->dept_cn : '';
        }
        $next_node = array();
        if ($this->is_approve) {            
            $next_node = Bll_Form::get_form_info_by_request_id($request['id'], $this->request_process->status);                        
        }        
        $operate_table = false;
        if (isset($request['id'])) {
            $operate_table = RequestProcess::instance()->findAll('request_id=:request_id', array('request_id' => $request['id']));
        }        
        $this->render('request_table', array('operate_table' => $operate_table, 'next_node' => $next_node, 'request' => $request, 'columns' => $columns, 'work_form' => $work_form, 'default_items' => $default_items, 'main_items' => $main_items, 'detail_items' => $_detail_items, 'nodes' => $nodes));
    }
}