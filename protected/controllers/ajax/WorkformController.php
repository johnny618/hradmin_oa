<?php
/**
 * 表单模块控制器
 * @author Grant
 *
 */
class WorkformController extends AjaxController {

    private function validate($data) {
        $validate_name = array();
        foreach ($data as $param) {
            if (in_array($param[0], $validate_name)) {
                self::exitWithCodeAndMsg(1, '数据库字段名称不能重复');
            }
            $validate_name[] = $param[0];
            if ($param[0] == '' || $param[1] == '') {
                self::exitWithCodeAndMsg(1, '请完成填写所需信息');
            }
            if ($param[2] == 2 && $param[3] == '') {
                self::exitWithCodeAndMsg(1, '请完成填写所需信息');
            }
            if ($param[2] == 4 && $param[5] == '') {
                self::exitWithCodeAndMsg(1, '请完成填写所需信息');
            }
            if ($param[2] == 5 && $param[3] == 2 && $param[5] == '') {
                self::exitWithCodeAndMsg(1, '请完成填写所需信息');
            }
            if ($param[2] == 6) {
                if ($param[3] == 1) {
                    $text = array_filter(explode('&', $param[5]));
                    if (count($text) < 2) {
                        self::exitWithCodeAndMsg(1, '请完成填写所需信息');
                    }
                } else {
                    if ($param[5] == '') {
                        self::exitWithCodeAndMsg(1, '请完成填写所需信息');
                    }
                }
            }
        }
    }

    private function setData($data) {
        if ($data[7] != '') {
            $item = WorkFormItem::instance()->findByPk($data[7]);
        } else {
            $item = new WorkFormItem;
        }
        $item->db_field_name = $data[0];
        $item->field_name = $data[1];
        $item->field_type = $data[2];
        $item->field_attr = $data[3];
        $item->dsporder = $data[4];
        if ($data[5]) {
            $item->field_body = json_encode(array_filter(explode('&', $data[5])));
        }
        $item->type = $data[6] ? $data[6] : $item->type;
        return $item;
    }

    public function actionEditItem() {
        // datas.push([db_field_name, field_name, field_type, field_attr, dsporder, field_body, type, id]);
        $params = $this->params();
        $validate_name = array();
        if (!isset($params['datas'])) {
            self::exitWithCodeAndMsg(1, '参数错误');
        }
        // 主表字段
        $this->validate($params['datas']);
        if (WorkFormItem::instance()->count('fid=' . $params['id'] . ' and field_attr = 101 ') == 0) {
            $default_items = array('sqr' => array('name' => '申请人', 'type' => 101), 'dept' => array('name' => '所属部门', 'type' => 102));
            foreach ($default_items as $key => $val) {
                $default = new WorkFormItem;
                $default->fid = $params['id'];
                $default->type = 0;
                $default->db_field_name = $key;
                $default->field_type = $val['type'];
                $default->field_name = $val['name'];
                $default->field_attr = $val['type'];
                $default->save();
            }
        }
        foreach ($params['datas'] as $param) {
            $item = $this->setData($param);
            $item->fid = $params['id'];
            $item->type = 0;
            $item->save();
        }
        // 明细字段
        if (isset($params['detail_datas'])) {
            foreach($params['detail_datas'] as $detail_data) {
                $this->validate($detail_data);
            }
            foreach($params['detail_datas'] as $detail_data) {
                $detail_type = false;
                foreach ($detail_data as $_data) {
                    if ($_data[6] != '') {
                        $detail_type = $_data[6];
                    }
                    if (!$detail_type) {
                        $result = Yii::app()->db->createCommand('select `type` from ' . WorkFormItem::instance()->tableName() . ' where fid=' . $params['id'] . ' order by type desc limit 1')->queryRow();
                        if (!$result) {
                            $detail_type = 1;
                        } else {
                            $detail_type = $result['type'] + 1;
                        }
                    }
                    $item = $this->setData($_data);
                    if ($item->type) {
                        $detail_type = $item->type;
                    }
                    $item->type = $detail_type;
                    $item->fid = $params['id'];
                    $item->save();
                }
            }
        }
        self::exitWithCodeAndMsg(0);
    }

    public function actionDelete() {
        $params = $this->params();
        $item = WorkFormItem::model()->findByPk($params['id']);
        if ($item) {
            $can_del = WorkFormRequest::model()->count('fid=:fid', array('fid' => $item->fid));
            if (!$can_del) {
                WorkFormItem::model()->deleteByPk($params['id']);
            }
        }
    }

    public function actionDelform() {
        $params = $this->params();
        if (!isset($params['id']) || !Validate::digit($params['id'])) {
            self::exitWithCodeAndMsg(1, '参数错误');
        }
        $result = Yii::app()->db->createCommand('select count(fid) as c from ' . WorkFormRequest::model()->tableName() . ' where fid=' . $params['id'])->queryRow();
        if ($result['c'] > 0) {
            self::exitWithCodeAndMsg(1, '该流程已有人申请，不可删除');
        }
        if (WorkForm::model()->updateByPk($params['id'], array('isDelete' => 1))) {
            self::exitWithCodeAndMsg(0, '删除成功');
        }
        self::exitWithCodeAndMsg(1, '删除失败');
    }
}