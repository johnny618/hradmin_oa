<?php
class RoleInfo extends CActiveRecord {

    public $id;
    public $roleid;
    public $userid;


    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
	 * @return string the associated database table name
	 */
    public function tableName() {
        return 'role_info';
    }

    public function rules() {
        return array(
            array(
                'id,roleid,userid',
                'safe'
            ),
            array(
                'roleid',
                'required'
            ),
        );
    }

    public function relations() {
        return array(
            'User' => array(self::HAS_ONE, 'User', array('uid' => 'userid')),
        );
    }

}