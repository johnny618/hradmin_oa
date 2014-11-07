<?php
class NewsInfo extends CActiveRecord {

    /**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
	 */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
	 * @return string the associated database table name
	 */
    public function tableName() {
        return 'news_info';
    }

    public function rules() {
        return array(
            array(
                'id,name,content,created,creater,updated,isDelete',
                'safe'
            )
        );
    }

    public function defaultScope() {
        return array(
            'condition' => 'isDelete = 0'
        );
    }

    /**
	 * @return array customized attribute labels (name=>label)
	 */
    public function attributeLabels() {
        return array();
    }

    public function beforeSave() {
        if (!$this->getIsNewRecord()) {
            $this->updated = date('Y-m-d H:i:s');
        }
        return true;
    }

    public function delete() {
        $this->isDelete = 1;
        $this->save();
    }

}