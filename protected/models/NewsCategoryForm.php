<?php
class NewsCategoryForm extends CFormModel {

    public $name;
    public $code;

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'name' => '名称',
            'code' => '类别'
        );
    }

    public function rules() {
        return array(
            array(
                'name',
                'required'
            )
        );
    }
}