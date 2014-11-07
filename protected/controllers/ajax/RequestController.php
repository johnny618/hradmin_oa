<?php
class RequestController extends AjaxController {

    public function actionUpdate() {
        $params = $this->params();
        $id = $params['id'];
        $form = WorkForm::instance()->findByPk($id);
        if (!$form || $form->dsporder < 0 || $form->isDelete != 0) {
            self::exitWithCodeAndMsg(1, '参数错误');
        }
        $FormNode = FormNode::instance()->findByPk($params['current_form_node_id']);
        if (!$FormNode) {
            self::exitWithCodeAndMsg(1, '节点参数设置错误');
        }
        $body = array();
        if (isset($params['request_id'])) {
            $Request = WorkFormRequest::instance()->findByPk($params['request_id']);
            if (!$Request) {
                self::exitWithCodeAndMsg(1, '非法操作');
            }
            if (!Bll_Form::check_operation($params['current_form_node_id'], $Request->id)) {
                throw new CHttpException(500, '无权操作');
            }
        } else {
            $Request = new WorkFormRequest();
            $Request->fid = $id;
            $Request->uid = Yii::app()->user->id;
            $Request->uname = Yii::app()->user->name;
            $Request->dept = Yii::app()->user->dept;
            $Request->title = $form->name . '-' . Yii::app()->user->name . '-' . date('Y-m-d');
        }
        if (!isset($params['mobile'])) {
            $columns = Yii::app()->db->createCommand('select db_field_name,field_attr,field_name from ' . WorkFormItem::instance()->tableName() . ' where fid=' . $id)->queryAll();                  
            foreach ($columns as $column) {
                if (isset($params[$column['db_field_name']])) {
                    if ($column['field_attr'] == 103) {
                        if (!is_numeric($params[$column['db_field_name']])) {
                            self::exitWithCodeAndMsg(1, $column['field_name'] . ' 必须为数字 !');
                        }
                    }
                    $body[$column['db_field_name']] = $params[$column['db_field_name']];
                }
            }

            $results = Yii::app()->db->createCommand('select `type`, db_field_name, field_attr,field_name from ' . WorkFormItem::instance()->tableName() . ' where type<>0 and fid=' . $id)->queryAll();
            $types = $numbers = array();
            foreach ($results as $result) {
                $types[$result['type']][] = $result['db_field_name'];
                if ($result['field_attr'] == 103) {
                    $numbers[$result['db_field_name']] = array(
                        'field_name' => $result['field_name']
                    );
                }
            }
            $detail_datas = $detail_columns = array();
            foreach ($types as $type => $_colums) {
                if (isset($params['detail_form_' . $type])) {
                    $data = array();
                    foreach ($params['detail_form_' . $type] as $post) {
                        if ($post['name'] == 'detail_line_type') {
                            $detail_datas[$type][] = $data;
                            $data = array();
                            continue;
                        }                        
                        if (isset($numbers[$post['name']]) && !is_numeric($post['value'])) {      
                            self::exitWithCodeAndMsg(1, $numbers[$post['name']]['field_name'] . ' 必须为数字');
                        }
                        $data[$type][$post['name']] = $post['value'];
                    }
                }
                $detail_columns[$type] = $_colums;
            } 
            $post_detail_datas = array();
            foreach ($detail_datas as $_type => $_datas) {
                foreach ($_datas as $_data) {
                    $new_data = array();
                    $new_data = array_intersect_key($_data[$_type], array_flip($detail_columns[$_type]));
                    foreach ($detail_columns[$_type] as $v) {
                        if (!isset($new_data[$v])) {
                            $new_data[$v] = '';
                        }
                    }
                    $post_detail_datas[$_type][] = $new_data;
                }
            }
            $edits = $not_null = array();
            if ($FormNode->edit) {
                $edits_result = Yii::app()->db->createCommand('select db_field_name,field_name from ' . WorkFormItem::instance()->tableName() . ' where id in (' . $FormNode->edit . ')')->queryAll();
                foreach ($edits_result as $v1) {
                    $edits[$v1['db_field_name']] = $v1['field_name'];
                }
            }
            if ($FormNode->notnull) {
                $not_null_result = Yii::app()->db->createCommand('select db_field_name,field_name from ' . WorkFormItem::instance()->tableName() . ' where id in (' . $FormNode->notnull . ')')->queryAll();
                foreach ($not_null_result as $v2) {
                    $not_null[$v2['db_field_name']] = $v2['field_name'];
                }
            }
            foreach ($body as $key => $val) {
                if (!array_key_exists($key, $edits)) {
                    unset($body[$key]);
                }
            }
            foreach ($not_null as $k => $v) {
                if (!isset($body[$k]) || !$body[$k]) {
                    self::exitWithCodeAndMsg(1, $v . '为必填项目');
                }
            }
            foreach ($body as $k => $v) {
                if (isset($Request->body[$k])) {
                    $Request->body[$k] = $v;
                }
            }
            if ($FormNode->type == 0) {
                $body['detail_datas'] = $post_detail_datas;
                $Request->status = 0;
            }
            $Request->body = serialize(array_merge($body, $Request->body ? $Request->body : array()));
        }
        if ($Request->save()) {
            $DataArr = Bll_Form::run_process($Request->id, $params['current_form_node_id']);
            if (!is_array($DataArr)) {
                $RequestProcess = new RequestProcess();
                $RequestProcess->request_id = $Request->id;
                $RequestProcess->status = $DataArr;
                $RequestProcess->operate = Yii::app()->user->id;
                $RequestProcess->tip = isset($params['UE_tip']) ? $params['UE_tip'] : '';
                $RequestProcess->save();
                $this->updateRequestStatus($Request, array(
                    $DataArr
                ));
                self::exitWithCodeAndMsg(0, '提交成功');
            }
            if (!empty($DataArr)) {
                //需要添加的下一个节点                
                $no_operation_next_ids = $has_operation_next_ids = array();
                foreach ($DataArr as $DataArrKey => $_DataArrVal) {
                    foreach($_DataArrVal as $_DataArrValKey => $DataArrVal){                         
                        if (isset($has_operation_next_ids[$DataArrKey]) && $has_operation_next_ids[$DataArrKey] == true) {
                            break;
                        }  
                        unset($has_operation_next_ids[$DataArrKey]);                        
                        //没有条件，只有下一个节点ID
                        if (!is_array($DataArrVal) && is_string($DataArrVal)) {
                            $no_operation_next_ids[] = $DataArrVal;
                        } else {
                            foreach ($DataArrVal as $DataArrValKey => $Val) {
                                if (is_integer($DataArrValKey)) {
                                    foreach ($Val as $DataArrValVal) {                                        
                                        if (isset($has_operation_next_ids[$DataArrKey]) && $has_operation_next_ids[$DataArrKey] == false) {
                                            break;
                                        }                                       
                                        if (isset($DataArrValVal['term_type']) && $DataArrValVal['term_type'] == 101) {
                                            if ($DataArrValVal['term'] == '=' && in_array($Request->uid, explode(', ', $DataArrValVal['term_content']))) {
                                                $has_operation_next_ids[$DataArrKey] = true;
                                            } elseif ($DataArrValVal['term'] == '!=' && !in_array($Request->uid, explode(', ', $DataArrValVal['term_content']))) {
                                                $has_operation_next_ids[$DataArrKey] = true;
                                            } else {
                                                $has_operation_next_ids[$DataArrKey] = false;
                                            }
                                        } elseif (isset($DataArrValVal['term_type']) && $DataArrValVal['term_type'] == 102) {
                                            if ($DataArrValVal['term'] == '=' && in_array($Request->dept, explode(',', $DataArrValVal['term_content']))) {
                                                $has_operation_next_ids[$DataArrKey] = true;
                                            } elseif ($DataArrValVal['term'] == '!=' && !in_array($Request->dept, explode(',', $DataArrValVal['term_content']))) {
                                                $has_operation_next_ids[$DataArrKey] = true;
                                            } else {
                                                $has_operation_next_ids[$DataArrKey] = false;
                                            }
                                        } elseif (isset($DataArrValVal['term_type']) && $DataArrValVal['term_type'] == 104) {
                                            $r = Yii::app()->db->createCommand('select count(id) as c from role_info where roleid in (' . $DataArrValVal['term_content'] . ') and userid=' . $Request->uid)->queryRow();
                                            if ($DataArrValVal['term'] == '=' && $r['c'] > 0) {
                                                $has_operation_next_ids[$DataArrKey] = true;
                                            } else if ($DataArrValVal['term'] == '!=' && $r['c'] == 0) {
                                                $has_operation_next_ids[$DataArrKey] = true;
                                            } else {
                                                $has_operation_next_ids[$DataArrKey] = false;
                                            }
                                        } elseif (isset($DataArrValVal['term_type']) && $DataArrValVal['term_type'] == 103) {
                                            $body = unserialize($Request->body);
                                            $body_field = WorkFormItem::model()->findByPk($DataArrValVal['item_id']);
                                            if (!$body_field) {
                                                self::exitWithCodeAndMsg(1, '条件字段不存在');
                                            }
                                            if (Validate::compare($body[$body_field->db_field_name], $DataArrValVal['term_content'], $DataArrValVal['term'])) {
                                                $has_operation_next_ids[$DataArrKey] = true;
                                            } else {
                                                $has_operation_next_ids[$DataArrKey] = false;
                                            }
                                        } elseif (isset($DataArrValVal['term_type']) && $DataArrValVal['term_type'] == 4) {                                        
                                            $body = unserialize($Request->body);
                                            $body_field = WorkFormItem::model()->findByPk($DataArrValVal['item_id']);
                                            if ($DataArrValVal['term'] == '=' && $body[$body_field->db_field_name] == $DataArrValVal['term_content']) {
                                                $has_operation_next_ids[$DataArrKey] = true;
                                            } elseif ($DataArrValVal['term'] == '!=' && $body[$body_field->db_field_name] != $DataArrValVal['term_content']) {
                                                $has_operation_next_ids[$DataArrKey] = true;
                                            } else {
                                                $has_operation_next_ids[$DataArrKey] = false;
                                            }
                                        }
                                    }
                                } elseif (is_string($DataArrValKey)) {
                                    if (isset($has_operation_next_ids[$DataArrKey]) && $has_operation_next_ids[$DataArrKey] == false) {
                                        break;
                                    }
                                    if (is_array($Val)) {
                                        $body = unserialize($Request->body);
                                        if (count($Val) == 2) {
                                            if (Validate::compare($body[$DataArrValKey], $Val[0]['term_content'], $Val[0]['term']) && Validate::compare($body[$DataArrValKey], $Val[1]['term_content'], $Val[1]['term'])) {
                                                $has_operation_next_ids[$DataArrKey] = true;
                                            }
                                        } else {
                                            if (Validate::compare($body[$DataArrValKey], $Val[0]['term_content'], $Val[0]['term'])) {
                                                $has_operation_next_ids[$DataArrKey] = true;
                                            }
                                        }
                                    }
                                }
                            }
                        }                        
                    }
                }            
//                var_dump($no_operation_next_ids,$has_operation_next_ids);
//                exit;
                $has_operation_next_ids = array_keys(array_filter($has_operation_next_ids));
                if (!$no_operation_next_ids && !$has_operation_next_ids) {
                    self::exitWithCodeAndMsg(1, '获取节点信息失败');
                }
                if (!$has_operation_next_ids) {
                    foreach ($no_operation_next_ids as $_id) {
                        $RequestProcess = new RequestProcess();
                        $RequestProcess->request_id = $Request->id;
                        $RequestProcess->status = $params['current_form_node_id'];
                        $RequestProcess->tip = isset($params['UE_tip']) ? $params['UE_tip'] : '';
                        $RequestProcess->next_status = $_id;
                        $RequestProcess->operate = Yii::app()->user->id;
                        $RequestProcess->save();
                    }
                    $this->updateRequestStatus($Request, $no_operation_next_ids, true);
                } else {
                    foreach ($has_operation_next_ids as $_id) {
                        $RequestProcess = new RequestProcess();
                        $RequestProcess->request_id = $Request->id;
                        $RequestProcess->status = $params['current_form_node_id'];
                        $RequestProcess->tip = isset($params['UE_tip']) ? $params['UE_tip'] : '';
                        $RequestProcess->next_status = $_id;
                        $RequestProcess->operate = Yii::app()->user->id;
                        $RequestProcess->save();
                    }
                    $this->updateRequestStatus($Request, $has_operation_next_ids, true);
                }
            }
            self::exitWithCodeAndMsg(0, '提交成功');
        }
        self::exitWithCodeAndMsg(1, '失败，请联系管理员');
    }

    public function updateRequestStatus($Request, $node_ids, $send_mail = false) {
        $nodes = FormNode::instance()->findAllByPk($node_ids);
        if (count($nodes) == 1 && $nodes[0]->type == 999) {
            $api_result = $this->close_user($Request->fid,$Request->uid);
            if ($send_mail) {
                $RedisList = new ARedisList("Mail");
                $content = array(
                    'node_ids' => $node_ids,
                    'request_id' => $Request->id,
                    'type' => 'notice',
                    'memo' => $api_result
                );
                $RedisList->add(serialize($content));
            }
            $Request->status = 999;
        } else {
            if ($send_mail) {
                $RedisList = new ARedisList("Mail");
                $content = array(
                    'node_ids' => $node_ids,
                    'request_id' => $Request->id,
                    'type' => 'handle',
                    'memo' => array()
                );
                $RedisList->add(serialize($content));
            }
            if ($Request->status == 1) {
                return;
            }
            $Request->status = 1;
        }
        $Request->save();
    }

    private function close_user($fid,$uid){
        //74 员工辞职申请
        $result = array();
        if ( $fid == 74 ){
            $result = Bll_Form::close_user($uid);
        }
        return $result;
    }

    public function actionBack() {
        $params = $this->params();
        $request = WorkFormRequest::instance()->findByPk($params['id']);
        if (!$request) {
            self::exitWithCodeAndMsg(1, '失败，该流程不存在');
        }
        $request->status = 0;
        $request->body = serialize($request->body);
        $request->save();
        $node = FormNode::instance()->find('fid=:fid and type=0', array(
            'fid' => $request->fid
        ));
        if (!$node) {
            self::exitWithCodeAndMsg(1, '获取节点失败');
        }
        $request_process = new RequestProcess();
        $request_process->request_id = $request->id;
        $request_process->status = $node->id;
        $request_process->operate = Yii::app()->user->id;
        $request_process->tip = $params['UE_tip'];
        $request_process->save();
        self::exitWithCodeAndMsg(0, '提交成功');
    }
    
    public function actionUndo() {
        $params = $this->params();
        $request = WorkFormRequest::instance()->findByPk($params['id']);
        if (!$request) {
            self::exitWithCodeAndMsg(1, '失败，该流程不存在');
        }
        $request->status = 0;
        $request->body = serialize($request->body);
        $request->save();
        $node = FormNode::instance()->find('fid=:fid and type=0', array(
            'fid' => $request->fid
        ));
        if (!$node) {
            self::exitWithCodeAndMsg(1, '获取节点失败');
        }
        $request_process = new RequestProcess();
        $request_process->request_id = $request->id;
        $request_process->status = $node->id;
        $request_process->operate = Yii::app()->user->id;        
        $request_process->save();
        self::exitWithCodeAndMsg(0, '提交成功');
    }

    public function actionDel() {
        $params = $this->params();
        $request = WorkFormRequest::instance()->findByPk($params['id']);
        if (!$request) {
            self::exitWithCodeAndMsg(1, '失败，该流程不存在');
        }
        if ($request->uid != Yii::app()->user->id || $request->isDelete == 1) {
            self::exitWithCodeAndMsg(1, '权限错误');
        }
        WorkFormRequest::model()->updateByPk($params['id'], array('isDelete' => 1));
        self::exitWithCodeAndMsg(0);
    }


    /**
     * 辦結後的流程發郵件通知
     * @param $request_id
     * @param $node_ids
     */
    private function get_mail_user($request,$node_ids){
        if (!isset($node_ids) || !isset($request->id) ) {
            return false;
        }
        $request = Yii::app()->db->createCommand('select * from work_form_request where id =' . $request->id)->queryRow();
        if (!$request) {
            return false;
        }
        $nodes = Yii::app()->db->createCommand('select * from node_operate where node_id in (' . implode(',', $node_ids) . ')')->queryAll();
        if (!$nodes) {
            return false;
        }

        foreach ($nodes as $node) {
            if ($node['type'] == 2) {
                self::send_Mail($node['operater'], $request);
            } elseif ($node['type'] == 1) {
                $users = API_OA::get_employees_by_dept($node['operater']);
                foreach ($users as $id => $name) {
                    $this->send_Mail($id, $request);
                }
            } elseif ($node['type'] == 3) {
                $result = Yii::app()->db->createCommand('select userid from role_info where roleid = ' . $node['operater'])->queryColumn();
                if (!$result) {
                    continue;
                }
                foreach ($result as $userid) {
                    $this->send_Mail($userid, $request);
                }
            } elseif ($node['type'] == 4) {
                $userid = Yii::app()->db->createCommand('select leader_id from user where uid = ' . $request['uid'])->queryColumn();
                if (!$userid) {
                    continue;
                }
                $this->send_Mail($userid[0], $request);
            }
        }
    }

    private function send_Mail($to_user_id, $request) {
        $SendMail = new Mail();

        $user_info = API_OA::get_OA_info_by_id($to_user_id);
        if (!$user_info) {
            return false;
        }
        $user_info['email'] = 'linjia@yiban.cn';
        $SendMail->mail($user_info['email'],'事项[' . $request['title'] . ']已办结',sprintf('事项["%s"]已办结',$request['title']));
    }
}