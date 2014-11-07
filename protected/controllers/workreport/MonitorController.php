<?php
/**
 * 每日工作小结监控
 * @author JohNnY 
 * 
 */
class MonitorController extends WebController {

    public function actionIndex(){        
        if (in_array(MyConst::MENU_REPORT, Yii::app()->user->author)){             //拥有看所有人的权限
            $deptArr = API_OA::get_all_dept();   
            $params = $this->params();      
            //设置参数
            $params['startTime'] = !empty($params['startTime']) ? $params['startTime'] :  ''; 
            $params['endTime'] = !empty($params['endTime']) ? $params['endTime'] :  '';
            $params['creater'] = !empty($params['creater']) ? $params['creater'] :  '';
            $params['createrid'] = !empty($params['createrid']) ? $params['createrid'] :  '';
            $params['late'] = isset($params['late']) ? $params['late'] :  '';             
            /**
            * 分页
            */         
           $rows_count = LogicWorkReport::get_work_report_data_all_count(strtotime($params['startTime']),strtotime($params['endTime']),$params['createrid'],$params['late']);    //得到数据条目总数   
           $page = MyTool::paging($rows_count, $currentPage = 1, $page_size = 10);        
           $currentPage = $page['cur'];            
           $rows = LogicWorkReport::get_work_report_data_all(strtotime($params['startTime']),strtotime($params['endTime']),$params['createrid'],$params['late'],$currentPage, $page_size);        
           $this->render('report_monitor',array('rows'=>$rows,'page'=>$page, 'rows_count'=>$rows_count,'deptArr'=>$deptArr,'params'=>$params));
           exit(0);
        }
        
        if (LogicUser::check_is_leader()){                                         //只能看下属的权限
            $deptArr = API_OA::get_all_dept();   
            $params = $this->params();              
            //设置参数
            $params['startTime'] = !empty($params['startTime']) ? $params['startTime'] :  ''; 
            $params['endTime'] = !empty($params['endTime']) ? $params['endTime'] :  '';
            $params['creater'] = !empty($params['creater']) ? $params['creater'] :  '';
            $params['createrid'] = !empty($params['createrid']) ? $params['createrid'] :  '';
            $params['late'] = isset($params['late']) ? $params['late'] :  '';   
            
            /**
            * 分页
            */         
            //$subArr = LogicUser::get_sub_of_leader();

            $this->getsub();

            if (empty(self::$subs)){
                throw new CHttpException(500,'没有下属');
                exit;
            }
            $rows_count = LogicWorkReport::get_work_report_data_by_leader_count(self::$subs,strtotime($params['startTime']),strtotime($params['endTime']),$params['createrid'],$params['late']);
            $page = MyTool::paging($rows_count, $currentPage = 1, $page_size = 10);        
            $currentPage = $page['cur'];            
            $rows = LogicWorkReport::get_work_report_data_by_leader(self::$subs,strtotime($params['startTime']),strtotime($params['endTime']),$params['createrid'],$params['late'] ,$currentPage, $page_size);
            $this->render('report_monitor',array('rows'=>$rows,'page'=>$page, 'rows_count'=>$rows_count,'deptArr'=>$deptArr,'params'=>$params));
            exit(0);
        }       
        
        throw new CHttpException(500,'无访问权限');
    }

    private static $subs = array();

    private function getsub($userArr = array()){
        if (empty($userArr)){
            $userArr[] = Yii::app()->user->id;
            //$userArr[] = '10000999';
        }

        $sub = LogicUser::get_subs_of_leader($userArr);
        if (empty($sub)){
            return self::$subs;
        }else{
            self::$subs = array_unique(array_merge(self::$subs,$sub));
            $this->getsub($sub);
        }
    }
    
    public function actionExport(){
        $params = $this->params();         
        if (!empty($params['sdate']) && !empty($params['edate'])){            
            $data = LogicWorkReport::get_work_data_all(strtotime($params['sdate']),strtotime($params['edate']));            

            $objPHPExcel = Pexcel::autoload();
            $_index = 1 ;
            foreach ($this->_build_excel_header() as $Key => $Val){                
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($Key.$_index, $Val);
            }
            $_index++ ;
            
            if (!empty($data)){
                foreach ($data as $dataKey => $dataVal){     
                    $info = array();
                    $info['A'] = date('Y-m-d',$dataVal['reportTime']);
                    $info['B'] = $this->Week[date('w',$dataVal['reportTime'])];
                    $info['C'] = $dataVal['uname'];
                    $info['D'] = date('Y-m-d H:i:s',$dataVal['created']);;
                    $info['E'] = empty($dataVal['late']) ? '否' : '是';  
                    foreach ($info as $infoKey => $infoVal){
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($infoKey.$_index, $infoVal);
                    }
                    $_index++;
                }
            }
        
            $objPHPExcel->getActiveSheet()->setTitle('小结统计');  
            Pexcel::save_excel($objPHPExcel,'小结统计');
            exit;
        


        }
        $this->render('report_export');
    }
    
    private $Week = array(0=>"星期日",1=>"星期一",2=>"星期二",3=>"星期三",4=>"星期四",5=>"星期五",6=>"星期六",7=>"星期日");
    
    /**
     * 文件头
     * @return array
     */
    private function _build_excel_header() {
        return array("A"=>"小结日期","B"=>"日历","C"=>"创建人","D"=>"创建时间","E"=>"是否迟交");
    }

    /**
     * 向文件输入数据
     * @param $params
     */
    private function _getExecl($params) {
        if(is_array($params) && !empty($params)) {
            $out = implode("\t", $params);
            $_out = mb_convert_encoding($out, "GBK", "UTF-8") . '\r\n';
            echo $_out;
        }
    }

    public function actionBack(){
        $params = $this->params(); 
        if ($params['nolate']){
            Bll_Report::do_create($params['nolate']);            
        }
        
    }
    
    public function actionInit(){
        $params = $this->params(); 
        if ($params['nolate']){
            $DataArr = array('late'=>0);
            $WhereArr = array('id'=>$params['nolate']);
            LogicWorkReport::update_work_report_data($DataArr,$WhereArr);                    
        }
        
    }
    

}