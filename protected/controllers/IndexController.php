<?php
class IndexController extends WebController {

    public function actionIndex() {
        $this->layout = '//layouts/main2';    
        $this->render('index');        
    }

    public function actionShow() {
        $requests_did = WorkFormRequest::model()->findAll('uid= ' . Yii::app()->user->id . ' and status in (0,1) and isDelete = 0 order by created desc limit 5');
        $requests_done = WorkFormRequest::model()->findAll('uid= ' . Yii::app()->user->id . ' and status = 999 and isDelete = 0 order by created desc limit 5');
        $requests_to_do = $this->get_to_do_requests();

        //1=>'通知公告',2=>'中心制度',3=>'值班表',4=>'易班大事记'
        $doc_tongzhi = LogicDocInfo::get_index_data(1);
        $doc_zhongxin = LogicDocInfo::get_index_data(2,4);
        $doc_zhiban = LogicDocInfo::get_index_data(3,4);
        $doc_yiban = LogicDocInfo::get_index_data(4,4);

        $ids = array(51=>array('c'=>'waichu','n'=>'外出登记'),
            94=>array('c'=>'yongping','n'=>'用品申请'),
            69=>array('c'=>'jiangshi','n'=>'内部讲师'),
            72=>array('c'=>'rencai','n'=>'人才推荐'),
            29=>array('c'=>'mingpian','n'=>'名片申请'),
            59=>array('c'=>'haoma','n'=>'号码申请'),
            53=>array('c'=>'caida','n'=>'彩打申请'),
            62=>array('c'=>'wuliao','n'=>'物料打样'));             
        $this->render('showv2',array('requests_to_do'=>$requests_to_do,'requests_did' => $requests_did, 'requests_done' => $requests_done, 'ids'=>$ids,
            'doc_tongzhi'=>$doc_tongzhi,'doc_zhongxin'=>$doc_zhongxin,'doc_zhiban'=>$doc_zhiban,'doc_yiban'=>$doc_yiban));
        
        /**
         * 原首页代码 START
         */
////        $requests_wait = WorkFormRequest::model()->findAll('uid= ' . Yii::app()->user->id . ' and status = 0 and isDelete = 0 order by created desc limit 4');
////        $requests_did = WorkFormRequest::model()->findAll('uid= ' . Yii::app()->user->id . ' and status = 1 and isDelete = 0 order by created desc limit 4');
//        $requests_did = WorkFormRequest::model()->findAll('uid= ' . Yii::app()->user->id . ' and status in (0,1) and isDelete = 0 order by created desc limit 4');
//        $requests_done = WorkFormRequest::model()->findAll('uid= ' . Yii::app()->user->id . ' and status = 999 and isDelete = 0 order by created desc limit 4');
//        $request_list = Yii::app()->db->createCommand('select * from work_form as wf join (select fid,count(fid) as c from work_form_request where title not like "%辞职%" group by fid order by c desc limit 10) wfq on wf.id = wfq.fid')->queryAll();                
//        $this->render('show', array('requests_did' => $requests_did, 'requests_done' => $requests_done, 'request_list' => $request_list));
        /**
         * 原首页代码 END
         */
        
    }

    private function get_to_do_requests(){
        $find_handle_forms = Bll_Form::find_need_show_form_info(1,5);
        $request_ids = array();
        foreach ($find_handle_forms as $form) {
            $request_ids[] = $form['request_id'];
        }
        $forms = array();
        if (!empty($request_ids)){
            $forms = LogicFormRequest::get_done_list_by_request_id($request_ids);
        }
        return $forms;
    }

    public function actionOut() {
        Yii::app()->user->logout();
        $this->redirect($this->createUrl('/login'));
    }
}