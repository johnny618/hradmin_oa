<?php
class FormProcess extends CActiveRecord {    
    public $id;
    public $fid;
    public $isback;
    public $next_goal;
    public $init_id;
    public $node_id;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
	 * @return string the associated database table name
	 */
    public function tableName() {
        return 'form_process';
    }

    public function rules() {
        return array(
            array(
                'id,fid,isback,next_goal,init_id,node_id',
                'safe'
            ),            
        );
    }


}
