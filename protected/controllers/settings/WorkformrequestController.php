<?php
/**
 * 新建流程
 * @author Grant
 *
 */
class WorkformrequestController extends WebController {

    /**
     * 表单列表
     */
    public function actionIndex() {
        $WorkForms = WorkForm::model()->findAll();
        $this->render('work_form_request_list', array('WorkForms' => $WorkForms));
    }

    /**
     * 新建申请
     */
    public function actionNew($id) {
        $form_info = WorkForm::model()->findByPk($id);
        if (isset($_POST) && $_POST) {
            $post = array();
            foreach ($form_info->items as $item) {
                if (array_key_exists($item->db_field_name, $_POST)) {
                    $post[$item->db_field_name]['value'] = $_POST[$item->db_field_name];
                    $post[$item->db_field_name]['field_type'] = $item->field_type;
                    $post[$item->db_field_name]['field_attr'] = $item->field_attr;
                    $post[$item->db_field_name]['dsporder'] = $item->dsporder;
                }
            }
            $WorkFormRequest = new WorkFormRequest;
            $WorkFormRequest->pid = $id;
            $WorkFormRequest->body = serialize($post);
            $WorkFormRequest->save();
        }
        $this->render('work_form_request_new', array('form_info' => $form_info));
    }

}