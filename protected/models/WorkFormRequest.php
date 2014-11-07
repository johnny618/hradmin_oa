<?php
class WorkFormRequest extends CActiveRecord {

    public $id;
    public $pid;
    public $body;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
	 * @return string the associated database table name
	 */
    public function tableName() {
        return 'work_form_request';
    }

    public function rules() {
        return array(
            array(
                'id,fid,uid,uname,dept,title,body,created,updated,isDelete,status',
                'safe'
            )
        );
    }

    public function relations() {
        return array(
            'WorkForm' => array(self::HAS_ONE, 'WorkForm', array('id' => 'fid')),
            'User' => array(self::HAS_ONE, 'User', array('uid' => 'uid'))
        );
    }

    public function canRequest($fid) {
        if (!MyTool::digit($fid)) {
            throw new CHttpException(500, '参数错误');
        }
        $results = Yii::app()->db->createCommand('select * from node_operate where node_id in (select id from form_node where fid = ' . $fid . ' and type=0)')->queryAll();
        if (!$results) {
            return false;
        }
        $return = false;
        $user_ids = $depts = array();
        $depts['in'] = $depts['not_in'] = array();
        $user_ids['in'] = $user_ids['not_in'] = array();
        foreach ($results as $result) {
            if ($result['type'] == 0) {
                return true;
            } elseif ($result['type'] == 1) {
                if ($result['term'] == 0) {
                    $depts['in'][] = $result['operater'];
                } else {
                    $depts['not_in'][] = $result['operater'];
                }
            } elseif ($result['type'] == 2) {
                if ($result['term'] == 0) {
                    $user_ids['in'][] = $result['operater'];
                } else {
                    $user_ids['not_in'][] = $result['operater'];
                }
            }
        }
        if (in_array(Yii::app()->user->dept, $depts['in']) && !in_array(Yii::app()->user->dept, $depts['not_in']) && in_array(Yii::app()->user->id, $user_ids['in']) && !in_array(Yii::app()->user->id, $user_ids['not_in'])) {
            return true;
        }
        return false;
    }

    public function beforeSave() {
        if ($this->getIsNewRecord()) {
            $this->created = time();
            $this->isDelete = 0;
        }
        $this->updated = date('Y-m-d H:i:s');
        return true;
    }

    public function afterFind() {
        $this->body = unserialize($this->body);
    }
}