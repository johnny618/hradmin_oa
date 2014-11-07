<?php
class UserForm extends CFormModel {

    public $username;

    public $password;

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'username' => '用户名',
            'password' => '密码'
        );
    }

    public function rules() {
        return array(
            array(
                'username,password',
                'required'
            )
        );
    }
}