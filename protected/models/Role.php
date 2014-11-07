<?php
class Role extends CActiveRecord {
    public $id;
    public $name;


    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
	 * @return string the associated database table name
	 */
    public function tableName() {
        return 'role';
    }

    public function rules() {
        return array(
            array(
                'id,name',
                'safe'
            ),
            array(
                'name',
                'unique'
            ),
        );
    }

    public function attributeLabels() {
        return array(
            'name' => '角色名称',
        );
    }

}