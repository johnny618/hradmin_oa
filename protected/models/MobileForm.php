<?php
class MobileForm extends CFormModel {

    public $password;

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'password' => '验证码'
        );
    }

    public function rules() {
        return array(
            array(
                'password',
                'required'
            )
        );
    }
}