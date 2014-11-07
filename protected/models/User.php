<?php
class User extends CActiveRecord {
    public $id;
    public $uid;
    public $uname;
    public $dept_id;
    public $dept_cn;
    public $leader_id;
    public $email;
    public $user_account;


    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
	 * @return string the associated database table name
	 */
    public function tableName() {
        return 'user';
    }

    public function relations() {
        return array(
            'leader' => array(self::HAS_ONE, 'User', array('uid' => 'leader_id')),
        );
    }

    public function showRequestMenu($userid, $dept) {
        $role = Yii::app()->db->createCommand('select id from ' .  RoleInfo::model()->tableName() . ' where userid = ' . $userid)->queryScalar();
        if ($role) {
            return true;
        }
        $leader = Yii::app()->db->createCommand('select id from ' . User::model()->tableName() . ' where leader_id = ' . $userid)->queryScalar();
        if ($leader) {
            return true;
        }
        $operater = Yii::app()->db->createCommand('select * from node_operate where (type = 2 and operater = ' . $userid . ') or (type = 1 and operater = "' . $dept . '")')->queryScalar();
        if ($operater) {
            return true;
        }
        return false;
    }
}