<?php
/**
 * 易班人积分
 * @author JohNnY 
 * 
 */
class SetController extends WebController {
    
    public function beforeAction($action) {        
        if (!Bll_Author::check_ybr_author()) {            
            throw new CHttpException('500','无权限访问');
        }
        return true;
    }
    
    public function actionIndex(){        
        /**
         * 分页
         */                 
        $parent = LogicPointsItem::get_parent_all();
        $_parent = $this->_init_arr($parent);        
        $rows_count = LogicPointsItem::get_data_all_count_by_child();    //得到数据条目总数   
        $page = MyTool::paging($rows_count, $currentPage = 1, $page_size = 15);        
        $currentPage = $page['cur'];            
        $rows = LogicPointsItem::get_data_all_by_child($currentPage, $page_size); 
        $this->render('list',array('rows'=>$rows,'page'=>$page, 'rows_count'=>$rows_count,'parent'=>$_parent));        
    }

    public function actionInfo(){
        $params = $this->params();
        if (empty($params['id'])){
            throw new CHttpException(500,'无访问参数');
        }
        /**
         * 分页
         */
        $item_info = LogicPointsItem::get_data_row_by_id($params['id']);
        $rows_count = LogicPointsInfo::get_info_by_id_count($params['id']);    //得到数据条目总数
        $page = MyTool::paging($rows_count, $currentPage = 1, $page_size = 15);
        $currentPage = $page['cur'];
        $rows = LogicPointsInfo::get_info_by_id($params['id'],$currentPage, $page_size);
        $this->render('point_list',array('params'=>$params,'rows'=>$rows,'page'=>$page, 'rows_count'=>$rows_count,'item_info'=>$item_info));
    }
    
    public function actionPoints(){        
        $params = $this->params();
        if (empty($params['pid']) ){
            throw new CHttpException('500','无访问参数');
        }
        $pData = LogicPointsItem::get_data_row_by_id($params['pid']);
        if (empty($pData)){
            throw new CHttpException('500','参数错误');
        }

        $deptArr = API_OA::get_all_dept();  //部门接口

        $data = array();
        if(!empty($params['date'])){
            $data = LogicPointsInfo::get_data_by_pid_date($params['pid'],$params['date']);
        }
        $date = !empty($data[0]['date']) ? $data[0]['date'] : '';
        $score = !empty($data[0]['score']) ? $data[0]['score'] : '';
        $cycle = !empty($data[0]['cycle']) ? $data[0]['cycle'] : '';

        $this->render('points',array('row'=>$pData,'deptArr'=>$deptArr,'cycleArr'=>Bll_YBR::cycle_arr(),'date'=>$date,'score'=>$score,'cycle'=>$cycle,'data'=>$data,'pid'=>$params['pid']));
    }

    
    public function actionAjax(){
        $params = $this->params();          
        $res = $this->_res;             
        switch($params['type']) {           
            case 'add_data':
                if (!empty($params['date']) &&  isset($params['cycle'])  && !empty($params['ids']) && !empty($params['pid']) && isset($params['score']) ){
                    //根据模块ID删除原来的数据
                    $WhereArr = array('pid'=>$params['pid'],'date'=>$params['date']);
                    LogicPointsInfo::delete_data_info($WhereArr);
                    //添加新数据
                    foreach($params['ids'] as $Val){
                        $DataArr = array('uid'=>$Val['0'],
                            'uname'=>$Val[1],
                            'pid'=>$params['pid'],
                            'date'=>$params['date'],
                            'score'=>$params['score'],
                            'cycle'=>$params['cycle']);
                        LogicPointsInfo::insert_data_row($DataArr);
                    }
                    $res = $this->init_res();
                }
                break;              
            default :
                $res = $this->_res;
                break;
        }
        echo json_encode($res);
        exit;        
    }
    
    
    private $_res = array(
        "code" => "error",
        "mes" => "操作失败！",
        "info" => array(),
    );
    
    private function init_res($result = null){
        $_res = array(
            "code" => "success",
            "mes" => "成功！",
            "info" => $result,
        );
        return $_res;
    }

    private function _init_arr($arr){
        if (empty($arr)){
            return array();
        }
        
        foreach ($arr as $arrKey => $arrVal){
            $result[$arrVal['id']] = $arrVal['name'];
        }
        return $result;
    }
    

}