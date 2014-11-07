<?php
/**
 * 工作流
 * @author Grant
 *
 */
class WorkflowController extends WebController {

    /**
     * 新增流程类型
     */
    public function actionAddWorkType() {
        $model = new WorkFormForm();
        $success = $error = false;
        if (isset($_POST['WorkFormForm'])) {
            $model->attributes = $_POST['WorkFormForm'];
            $model->pid = 0;
            if ($model->validate()) {
                $WorkForm = new WorkForm;
                $WorkForm->attributes = $model->attributes;
                $WorkForm->created = date('Y-m-d H:i:s', time());
                $WorkForm->isDelete = 0;
                if ($WorkForm->insert()) {
                    $success = true;
                } else {
                    $error = true;
                }
            }
        }
        $this->render('add_work_type', array('model' => $model, 'success' => $success, 'error' => $error));
    }

    /**
     * 流程列表
     */
    public function actionListType() {
        $lists = WorkForm::model()->findAll('pid=0 and isDelete=0');
        $this->render('list_type', array('lists' => $lists));
    }

    /**
     * 新建流程
     */
    public function actionAdd() {
        $model = new WorkFormForm('top');
        $params = $this->params();
        if (isset($params['WorkFormForm'])) {
            $model->attributes = $params['WorkFormForm'];
            $model->pid = 0;
            if ($model->validate()) {
                $item = WorkForm::instance();
                $item->setAttributes($model->attributes);
                $item->pid = 0;
                if (!$item->save()) {
                    $model->addErrors($item->getErrors());
                } else {
                    $this->redirect($this->createUrl('/settings/workflow/listtype'));
                }
            }
        }
        $this->render('add_type', array('model' => $model));
    }

    /**
     * 编辑流程
     */
    public function actionEdit($id) {
        $item = WorkForm::model()->findByPk($id);
        if (!$item || $item->pid != 0) {
            throw new CHttpException(404, '页面不存在');
        }
        $model = WorkFormForm::instance();
        $model->attributes = $item->attributes;
        $params = $this->params();
        if (isset($params['WorkFormForm'])) {
            $model->attributes = $params['WorkFormForm'];
            if ($model->validate()) {
                $item->setAttributes($model->attributes);
                if (!$item->save()) {
                    $model->addErrors($item->getErrors());
                } else {
                    $this->redirect($this->createUrl('/settings/workflow/listtype'));
                }
            }
        }
        $this->render('edit_type', array('model' => $model, 'item' => $item));
    }
}