<?php
class NodeOperate extends CActiveRecord {    
    public $id;
    public $node_id;
    public $term;
    public $type;
    public $operater;
    public $operater_zh;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
	 * @return string the associated database table name
	 */
    public function tableName() {
        return 'node_operate';
    }

    public function rules() {
        return array(
            array(
                'id,node_id,term,type,operater,operater_zh',
                'safe'
            ),            
        );
    }


}
