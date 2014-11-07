<?php
/**
 * 表单
 * @author Grant
 *
 */
class WorkformitemController extends WebController {

    /**
     * 表单列表
     */
    public function actionIndex() {
        $WorkForms = WorkForm::model()->findAll('pid=:pid and isDelete=0', array('pid' => 0));
        $this->render('work_form_list', array('WorkForms' => $WorkForms));
    }

    /**
     * 编辑表单
     */
    public function actionEdit($id) {
        $params = $this->params();
        $WorkFormItem = new WorkFormItem;
        if (isset($_POST['item'])) {
            $WorkFormItem->deleteAll('id=:id', array('id' => $id));

            foreach ($_POST['item'] as $post) {
                //$item = new WorkFormItem;
                WorkFormItem::instance(false)->Model_Vals($post);
                WorkFormItem::instance()->save();
//                $item->pid = $id;
//                $item->db_field_name = $post['db_field_name'];
//                $item->field_name = $post['field_name'];
//                $item->field_type = $post['field_type'];
//                $item->dsporder = $post['dsporder'];
//                $item->save();
            }
        }
        $items = $WorkFormItem->findAll('pid=:pid', array('pid' => $id));
        $this->render('work_form_item', array('items' => $items));
    }
}