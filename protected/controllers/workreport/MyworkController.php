<?php
/**
 * 工作小结列表
 * @author JohNnY
 *
 */
class MyworkController extends WebController {

    public function actionList(){
        /**
         * 分页
         */         
        $rows_count = LogicWorkReport::get_work_report_data_by_uid_count();    //得到数据条目总数   
        $page = MyTool::paging($rows_count, $currentPage = 1, $page_size = 10);        
        $currentPage = $page['cur'];            
        $rows = LogicWorkReport::get_work_report_data_by_uid($currentPage, $page_size);        
        $this->render('mylist',array('rows'=>$rows,'page'=>$page, 'rows_count'=>$rows_count));
    }

    
}