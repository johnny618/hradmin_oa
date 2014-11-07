<?php
/**
 * 新建文档
 * @author JohNnY 
 * 
 */
class CreateController extends WebController {
  
    
    public function actionIndex(){ 
        $data = LogicDocAuthority::get_user_author_of_tid();            
        $this->render('list',array('tidArr'=>$data));
    }
    
    public function actionAdd(){ 
        $params = $this->params();               
        if (!empty($params['tid']) && !empty($params['title']) && !empty($params['tip'])){
            $DataArr = array(
                        'tid'=>$params['tid'],
                        'uid'=> Yii::app()->user->id,
                        'uname'=>Yii::app()->user->name,
                        'title'=>$params['title'],
                        'tip'=>htmlspecialchars(MyTool::html_to_code($params['tip'])),                    
                        'created'=>time()
                    );
                
            $result = LogicDocInfo::insert_data_row($DataArr);     
            if (empty($result)){ //添加成功 到自己列表页
                throw new CHttpException('500','插入数据失败');
            }
            echo '<script type="text/javascript">location.href="'.Yii::app()->createUrl('/document/create/list').'"</script>';
            exit;
        }
        $this->render('add',array('tid'=>$params['tid']));
    }
    
    public function actionList(){        
        $params = $this->params();  
        $author = Bll_Author::check_ybr_document_author();

        $uid = !empty($params['id']) ? $params['id'] : '';
        $uname = !empty($params['uname']) ? $params['uname'] : '';
        $title = !empty($params['title']) ? $params['title'] : '';
        $tid = !empty($params['tid']) ? $params['tid'] : '';

        if ($author){


            $rows_count = LogicDocInfo::get_data_by_term_count($uid,$uname,$title,$tid);
            $page = MyTool::paging($rows_count, $currentPage = 1, $page_size = 15);
            $currentPage = $page['cur'];
            $data = LogicDocInfo::get_data_by_term($uid,$uname,$title,$tid,$currentPage, $page_size);
        }else{
            $tids = LogicDocAuthority::get_user_author_of_tid();
            $rows_count = LogicDocInfo::get_data_by_owner_count($tids,$uid,$uname,$title,$tid);
            $page = MyTool::paging($rows_count, $currentPage = 1, $page_size = 15);
            $currentPage = $page['cur'];
            $data = LogicDocInfo::get_data_by_owner($tids,$uid,$uname,$title,$tid,$currentPage, $page_size);
        }

        $this->render('my',array('data'=>$data,'page'=>$page, 'rows_count'=>$rows_count,'author'=>$author ,'params'=>$params,'uname'=>$uname,'tid'=>!empty($params['tid']) ? $params['tid'] : ''));
    }
    
    public function actionEdit(){
        $params = $this->params();                
        if (empty($params['id'])){
            throw new CHttpException('500','无参数');
        }              
        if (!empty($params['title']) && !empty($params['tip']) && !empty($params['id']) ){
            $DataArr = array(                        
                        'uid'=> Yii::app()->user->id,
                        'uname'=>Yii::app()->user->name,
                        'title'=>$params['title'],
                        'tip'=>htmlspecialchars(MyTool::html_to_code($params['tip']))
                    );
            $WhereArr = array('id'=>$params['id']);
            LogicDocInfo::update_data_row($DataArr,$WhereArr);                 
            echo '<script type="text/javascript">location.href="'.Yii::app()->createUrl('/document/create/list').'"</script>';
            exit;
        }
        $data = LogicDocInfo::get_data_by_id($params['id']);
        $this->render('edit',array('data'=>$data));
    }
    
    public function actionLook(){
        $params = $this->params();                
        if (empty($params['id'])){
            throw new CHttpException('500','无参数');
        }    
        $data = LogicDocInfo::get_data_by_id($params['id']);
        $this->render('look',array('data'=>$data));
    }

    public function actionAjax(){
        $params = $this->params();
        $res = $this->_res;
        switch($params['type']) {
            case 'delete_data':
                if (!empty($params['id']) ){
                    //根据模块ID删除原来的数据
                    $WhereArr = array('id'=>$params['id']);
                    LogicDocInfo::delete_data_info($WhereArr);
                    $res = $this->init_res();
                }
                break;
            case 'top_data':
                if (!empty($params['id']) ){
                    //根据模块ID删除原来的数据
                    $status = !empty($params['status']) ? 0 : 1;
                    $dataArr = array('top'=>$status);
                    $WhereArr = array('id'=>$params['id']);
                    LogicDocInfo::update_data_row($dataArr,$WhereArr);
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