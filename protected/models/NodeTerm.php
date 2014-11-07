<?php
class NodeTerm extends CActiveRecord {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
	 * @return string the associated database table name
	 */
    public function tableName() {
        return 'node_term';
    }

    public function rules() {
        return array(
            array(
                'id,fid,node_id,item_id,term,term_content,term_type',
                'safe'
            ),
        );
    }

    public function getTerms($fid, $current_node_id) {
        $db_results = Yii::app()->db->createCommand('select fp.init_id,fp.node_id,nt.fid,nt.item_id,nt.term,nt.term_content,nt.term_type from form_process fp join node_term nt on fp.id = nt.node_id where fp.fid=' . $fid. ' and fp.init_id=' . $current_node_id)->queryAll();
        $terms = $number_terms = $finded = array();
        foreach ($db_results as $result) {
            if ($result['term_type'] == 103) {
                if (!array_key_exists($result['item_id'], $finded)) {
                    $work_item = WorkFormItem::instance()->findByPk($result['item_id']);
                    $finded[$result['item_id']] = $work_item->attributes;
                }
                $number_terms[$finded[$result['item_id']]['db_field_name']][] = $result;
            } else {
                $terms[] = $result;
            }
        }
        $terms[] = $number_terms;
        return $terms;
    }

}