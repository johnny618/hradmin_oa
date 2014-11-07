<?php
class WorkFormItem extends ExModel {

    public $model_keys = array('id','fid','db_field_name','field_name','field_type','field_attr','dsporder');

    public function Model_Vals($params) {
        if (!empty($params)){
            $arr = $this->init_model($params,$this->model_keys);
            foreach ($arr as $akey =>$val){
                $this->$akey = $val;
            }

        }

    }


    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'work_form_item';
    }

    public function beforeSave() {
        if ($this->getIsNewRecord()) {
            $this->created = date('Y-m-d H:i:s');
        }
        $this->updated = date('Y-m-d H:i:s');
        return true;
    }

    public function rules() {
        return array(
            array(
                'id,fid,db_field_name,field_name,field_type,field_attr,field_body,dsporder,type',
                'safe'
            )
        );
    }
}