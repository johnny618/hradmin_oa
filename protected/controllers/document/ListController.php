<?php
/**
 * 新建文档
 * @author JohNnY 
 * 
 */
class ListController extends WebController {
  
    
    public function actionIndex(){
        $params = $this->params();
        if (empty($params['tid'])){
            throw new CHttpException('500','无参数');
        }
        $rows_count = LogicDocInfo::get_data_by_tid_count($params['tid']);
        $page = MyTool::paging($rows_count, $currentPage = 1, $page_size = 15);
        $currentPage = $page['cur'];
        $data = LogicDocInfo::get_data_by_tid($params['tid'] , $currentPage , $page_size);
        $this->render('list',array('data'=>$data,'page'=>$page, 'rows_count'=>$rows_count,'params'=>$params));
    }
    

}