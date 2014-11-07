<?php
class RequestProcess extends CActiveRecord {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
	 * @return string the associated database table name
	 */
    public function tableName() {
        return 'request_process';
    }

    public function rules() {
        return array(
            array(
                'id,request_id,status,next_status,operate,tip,updated',
                'safe'
            ),
        );
    }

    public function relations() {
        return array(
            'operater' => array(self::HAS_ONE, 'User', array('uid' => 'operate')),
            'current_node' => array(self::HAS_ONE, 'FormNode', array('id' => 'status')),
        );
    }

    public function beforeSave() {
        $this->updated = date('Y-m-d H:i:s');
        return true;
    }

}