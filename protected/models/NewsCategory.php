<?php
class NewsCategory extends CActiveRecord {

    const TOPCODE = 0;

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
        return 'news_category';
    }
    


    public function beforeSave() {
        if ($this->isNewRecord) {
         $this->code = NewsCategory::TOPCODE;
         $this->created = time();
        }
    }

    public function rules() {
        return array(
            array(
                'id,name,code,created,creater,isDelete',
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

    public function delete() {
        $this->isDelete = 1;
        $this->save();
    }

    public function getTopCategory() {
        return $this->findAll('code = 0');
    }

    public function relations() {
        return array(
           'subCategories' => array(self::HAS_MANY, 'NewsCategory', array('code' => 'id')),
        );
    }

}