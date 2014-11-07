<?php
class WorkForm extends CActiveRecord {

    public $id;
    public $name;
    public $pid;
    public $dsporder;
    public $created;
    public $isDelete;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
	 * @return string the associated database table name
	 */
    public function tableName() {
        return 'work_form';
    }

    public function rules() {
        return array(
            array(
                'id,name,desc,pid,dsporder,created,updated,isDelete',
                'safe'
            ),
            array(
                'name',
                'unique'
            )
        );
    }

    public function attributeLabels() {
        return array(
            'name' => '名称'
        );
    }

    /**
     * 获取顶级分类
     */
    public function getTopMenu() {
        $result = Yii::app()->db->createCommand('select id, name from ' . $this->tableName() . ' where isDelete=0 and pid = 0 and dsporder >= 0 order by dsporder desc')->queryAll();
        $return = array();
        foreach ($result as $v) {
            $return[$v['id']] = $v['name'];
        }
        return $return;
    }

    /**
     * 获取父分类下的所有子流程
     * @param int $pid
     */
    public function getSubMenu($pid) {
        $result = Yii::app()->db->createCommand('select id, name from ' . $this->tableName() . ' where isDelete=0 and pid = ' . $pid . ' and dsporder >= 0 order by dsporder desc')->queryAll();
        $return = array();
        foreach ($result as $v) {
            $return[$v['id']] = $v['name'];
        }
        return $return;
    }

    public function relations() {
        return array(
            'items' => array(self::HAS_MANY, 'WorkForm', array('pid' => 'id')),
        );
    }

    public function beforeSave() {
        if ($this->isNewRecord) {
            $this->isDelete = 0;
            $this->created = date('Y-m-d H:i:s');
        }
        $this->updated = date('Y-m-d H:i:s');
        return true;
    }
}