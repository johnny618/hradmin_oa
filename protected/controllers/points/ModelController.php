<?php
/**
 * 易班人积分
 * @author JohNnY 
 * 
 */
class ModelController extends WebController {

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
        $rows_count = LogicPointsItem::get_data_all_count();    //得到数据条目总数   
        $page = MyTool::paging($rows_count, $currentPage = 1, $page_size = 15);        
        $currentPage = $page['cur'];            
        $rows = LogicPointsItem::get_data_all($currentPage, $page_size);        
        $this->render('list',array('rows'=>$rows,'page'=>$page, 'rows_count'=>$rows_count));
    }

    public function actionAdd(){    
        $params = $this->params();

        if (!empty($params['tname'])){
            $parent = 0;
            if (!empty($params['sel_type']) && isset($params['sel_pclass'])){
                $parent = $params['sel_pclass'];
            }
            $DataArr = array('name'=>$params['tname'],'parent_id'=>$parent);
            LogicPointsItem::insert_data_row($DataArr);
            echo '<script>location.href="'.Yii::app()->createUrl('/points/model/index').'"</script>';
        }

        $pitem = LogicPointsItem::get_parent_item_all();
        $this->render('add',array('pitem'=>$pitem));
    }
    
    public function actionModify(){            
        $params = $this->params();
        if (empty($params['id'])){
            throw new CHttpException('500','无参数');
        }

        if (!empty($params['id']) && !empty($params['tname'])){
            $DataArr = array('name'=>$params['tname']);
            $WhereArr = array('id'=>$params['id']);
            LogicPointsItem::update_data_row($DataArr,$WhereArr);
            echo '<script>location.href="'.Yii::app()->createUrl('/points/model/index').'"</script>';
        }
        $data = LogicPointsItem::get_data_row_by_id($params['id']);        
        $this->render('modify',array('data'=>$data));
    }
    
    public function actionAjax(){
        $params = $this->params();         
        $res = $this->_res;             
        switch($params['type']) {           
            case 'check_name':
                if (!empty($params['name'])){                    
                    $result = LogicPointsItem::check_name($params['name']);
                    if (empty($result)){                    
                        $res = $this->init_res();
                    }
                }
                break;  
            case 'modify_check_name':
                if (!empty($params['name']) && !empty($params['cid'])){                    
                    $result = LogicPointsItem::check_name($params['name'],$params['cid']);
                    if (empty($result)){                    
                        $res = $this->init_res();
                    }
                }
                break;
            case 'delete_data':
                if (!empty($params['id'])){
                    $cids = LogicPointsItem::get_child_item_by_parent_id($params['id']);
                    $del_ids = array_merge($cids,array($params['id']));
                    LogicPointsInfo::delete_data_info_by_pids($del_ids);
                    LogicPointsItem::delete_data_info($params['id']);
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

}