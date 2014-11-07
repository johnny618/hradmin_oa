<?php
class NewsInfoForm extends CFormModel {

    public $name;
    public $content;

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'name' => '标题',
            'content' => '内容'
        );
    }

    public function rules() {
        return array(
            array(
                'name,content',
                'required'
            )
        );
    }
}