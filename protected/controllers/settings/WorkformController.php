<?php
/**
 * 表单模块控制器
 * @author Grant
 *
 */
class WorkformController extends WebController {

    /**
     * 表单列表
     */
    public function actionIndex() {
        $CDbCriteria = new CDbCriteria;
        $CDbCriteria->compare('isDelete', 0);
        $CDbCriteria->order = 'created desc';
        $CDbCriteria->addCondition('pid!=0');
        $params = $this->params();
        if (!empty($params['id'])) {
            WorkForm::instance()->updateByPk($params['id'], array('isDelete' => 1));
        }
        $searched_name = '';
        if (isset($params['names'])) {
            $searched_name = $params['names'];
            $CDbCriteria->compare('name', $searched_name, true);
        }
        $forms = WorkForm::instance()->findAll($CDbCriteria);
        $form_ids = array();
        foreach ($forms as $form) {
            $form_ids[] = $form->id;
        }
        $can_not_delete_ids = array();
        $can_not_delete_results = Yii::app()->db->createCommand('select fid,count(fid) as c from ' . WorkFormRequest::model()->tableName() . ' where fid in (' . implode(',', $form_ids) . ') group by fid')->queryAll();
        foreach ($can_not_delete_results as $v) {
            $can_not_delete_ids[] = $v['fid'];
        }
        $this->render('list', array('forms' => $forms, 'searched_name' => $searched_name, 'can_not_delete_ids' => $can_not_delete_ids));
    }

    /**
     * 新增表单类型
     */
    public function actionAddForm() {
        $model = new WorkFormForm();
        $success = $error = false;
        if (isset($_POST['WorkFormForm'])) {
            $model->attributes = $_POST['WorkFormForm'];
            if ($model->validate()) {
                $WorkForm = new WorkForm;
                $WorkForm->attributes = $model->attributes;
                if ($WorkForm->save()) {
                    $this->redirect($this->createUrl('/settings/workform/editform/' . $WorkForm->getPrimaryKey()));
                } else {
                    $model->addErrors($WorkForm->getErrors());
                }
            }
        }
        $this->render('add_form', array('model' => $model));
    }

    /**
     *  编辑表单
     */
    public function actionEditform($id) {
        $model = WorkFormForm::instance();
        $item = WorkForm::instance()->findByPk($id);
        if ($item->isDelete == 1 || $item->pid == 0) {
            throw new CHttpException(404);
        }
        $model->attributes = $item->attributes;
        $params = $this->params();
        if (isset($params['WorkFormForm'])) {
            $model->attributes = $params['WorkFormForm'];
            if ($model->validate()) {
                $item->attributes = $params['WorkFormForm'];
                if (!$item->save()) {
                    $model->addErrors($item->getErrors());
                } else {
                    $model->attributes = $item->attributes;
                }
            }
        }
        $form_items = WorkFormItem::instance()->findAll('fid=:fid and type = 0 and field_type not in(101,102)', array('fid' => $item->id));
        $this->render('edit_form', array('item' => $item, 'model' => $model, 'form_items' => $form_items));
    }

    /**
     * 编辑表单字段
     */
    public function actionEditformitem($id) {
        $form = WorkForm::instance()->findByPk($id);
        if ($form->isDelete == 1 || $form->pid == 0) {
            throw new CHttpException(404);
        }
        $main_items = WorkFormItem::instance()->findAll('fid=:fid and type=0 and field_type not in(101,102)', array('fid' => $id));
        $detail_result = WorkFormItem::instance()->findAll('fid=:fid and type<>0', array('fid' => $id));
        $detail_items = array();
        foreach ($detail_result as $detail_item) {
            $detail_items[$detail_item->type][] = $detail_item;
        }
        $can_del = WorkFormRequest::model()->count('fid=:fid', array('fid' => $id));
        $this->render('edit_form_item', array('main_items' => $main_items, 'detail_items' => $detail_items, 'form' => $form, 'can_del' => $can_del));
    }
}