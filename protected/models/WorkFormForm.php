<?php
class WorkFormForm extends CFormModel {

    public $name;
    public $desc;
    public $pid;
    public $dsporder = 0;

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'name' => '名称',
            'desc' => '描述',
            'dsporder' => '显示顺序',
            'pid' => '类型'
        );
    }

    public function rules() {
        return array(
            array(
                'pid',
                'safe',
                'on' => 'top'
            ),
            array(
                'name,desc,pid',
                'required'
            ),
            array(
                'dsporder',
                'numerical',
                'integerOnly' => true
            )
        );
    }

    public function _isExists($attr) {
        if (WorkForm::model()->exists('name=:name and pid=:pid and isDelete=0', array('name' => $this->$attr, 'pid' => $this->pid))) {
            $this->addError('name', '该名称已存在');
            return false;
        }
        return true;
    }
}