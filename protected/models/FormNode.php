<?php
class FormNode extends CActiveRecord {    
    public $id;
    public $fid;
    public $name;
    public $type;
    public $show;
    public $edit;
    public $notnull;
 

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
	 * @return string the associated database table name
	 */
    public function tableName() {
        return 'form_node';
    }

    public function rules() {
        return array(
            array(
                'id,fid,name,type,show,edit,notnull',
                'safe'
            ),        
        );
    }

    public function attributeLabels() {
        return array(
            'name' => '名称',
            'type' => '类型',
            'show' => '是否显示',
            'edit' => '是否编辑',
            'notnull' => '是否必填'
        );
    }
    
    public function relations() {
        return array(
            'items' => array(self::HAS_MANY, 'FormNode', array('fid' => 'id')),
        );
    }

}