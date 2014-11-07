<?php
class SendMailCommand extends CConsoleCommand {

    public $Mail;

    public function __construct() {
        $this->Mail = new Mail();
    }

    public function actionIndex() {
        $RedisList = new ARedisList("Mail");
        while ($RedisList->getCount()) {
            $data = unserialize($RedisList->shift());
            if (!isset($data['node_ids']) || !isset($data['request_id']) ) {
                continue;
            }
            $request = Yii::app()->db->createCommand('select * from work_form_request where id =' . $data['request_id'])->queryRow();
            if (!$request) {
                continue;
            }

            //辦結後發郵件通知申請人
            if ($data['type'] == 'notice'){
                $this->sendMail($request['uid'], $request,$data['type'],$data['memo']);
            }

            $nodes = Yii::app()->db->createCommand('select * from node_operate where node_id in (' . implode(',', $data['node_ids']) . ')')->queryAll();
            if (!$nodes) {
                continue;
            }

            $userArr = array();
            foreach ($nodes as $node) {
                if ($node['type'] == 2) {
                    $userArr[] = $node['operater'];
                    $this->sendMail($node['operater'], $request,$data['type'],$data['memo']);
                } elseif ($node['type'] == 1) {
                    $users = API_OA::get_employees_by_dept($node['operater']);
                    foreach ($users as $id => $name) {
                        $userArr[] = $id;
                        $this->sendMail($id, $request,$data['type'],$data['memo']);
                    }
                } elseif ($node['type'] == 3) {
                    $result = Yii::app()->db->createCommand('select userid from role_info where roleid = ' . $node['operater'])->queryColumn();
                    if (!$result) {
                        continue;
                    }
                    foreach ($result as $userid) {
                        $userArr[] = $userid;
                        $this->sendMail($userid, $request,$data['type'],$data['memo']);
                    }
                } elseif ($node['type'] == 4) {
                    $userid = Yii::app()->db->createCommand('select leader_id from user where uid = ' . $request['uid'])->queryColumn();
                    if (!$userid) {
                        continue;
                    }
                    $userArr[] = $userid[0];
                    $this->sendMail($userid[0], $request,$data['type'],$data['memo']);
                }
            }

        }
    }

    private function sendMail($to_user_id, $request,$type='handle',$memo = array()) {
        $user_info = API_OA::get_OA_info_by_id($to_user_id);
        if (!$user_info) {
            continue;
        }
        $redis = new ARedisCache();
        $key = md5($request['id'] . $user_info['id'] . time());
        $redis->set($key, $user_info['id'], 7 * 24 * 3600);
        $_url = 'http://10.21.168.170/request/do/' . $request['id'] . '?token=' . $key;
        //$user_info['email'] = 'linjia@yiban.cn';
        if ($type == 'handle'){
            //$this->Mail->mail($user_info['email'],'您有一个待审批事项[' . $request['title'] . ']', sprintf('点击链接审批:<a href="%s" target="_blank">%s</a>', $_url, $_url));
        }else{
            if (!empty($memo)){
                //$this->Mail->mail($user_info['email'],'办结提醒:[' . $request['title'] . ']已办结',sprintf('办结提醒["%s"]已办结!  邮箱关闭:%s  用户账户关闭：%s',$request['title'],$memo['mail'],$memo['user']));
            }else{
                //$this->Mail->mail($user_info['email'],'办结提醒:[' . $request['title'] . ']已办结',sprintf('办结提醒["%s"]已办结',$request['title']));
            }

        }

    }

    public function actionTest() {
        $request = Yii::app()->db->createCommand('select * from work_form_request where id = 732')->queryRow();
        $this->sendMail(10000405, $request);
    }
}