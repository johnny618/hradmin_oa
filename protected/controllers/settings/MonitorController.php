<?php
/**
 * 流程监控
 * @author JohnnyLin
 *
 */
class MonitorController extends WebController {

    public function actionIndex($currentPage=1){              
        $params = $this->params();
        //设置参数
        $params['startTime'] = !empty($params['startTime']) ? $params['startTime'] :  ''; 
        $params['endTime'] = !empty($params['endTime']) ? $params['endTime'] :  '';
        $params['r_title'] = !empty($params['r_title']) ? $params['r_title'] :  '';
        $params['nodetype'] = isset($params['nodetype']) ? $params['nodetype'] :  '';
        $params['creater'] = !empty($params['creater']) ? $params['creater'] :  '';
        $params['createrid'] = !empty($params['createrid']) ? $params['createrid'] :  '';
        $params['typename'] = !empty($params['typename']) ? $params['typename'] :  '';
        $params['typeid'] = !empty($params['typeid']) ? $params['typeid'] :  '';        
        $deptArr = API_OA::get_all_dept();                
        $typedata = Bll_Form::get_from_type();        
        /**
         * 分页
         */         
        $rows_count = Bll_Form::getMonitorCount($params['startTime'],$params['endTime'],$params['r_title'],$params['nodetype'],$params['createrid'],$params['typeid']);    //得到数据条目总数   
        $page = MyTool::paging($rows_count, $currentPage = 1, $page_size = 15);        
        $currentPage = $page['cur'];             
        $rows = Bll_Form::getMonitorList($params['startTime'],$params['endTime'],$params['r_title'],$params['nodetype'],$params['createrid'],$params['typeid'],$currentPage, $page_size);        
        $this->render('list',array('rows'=>$rows,'page'=>$page, 'rows_count'=>$rows_count,'typedata'=>$typedata,'deptArr'=>$deptArr,'params'=>$params));
    }

    

}