<?php

class Bll_Report{

    public static function do_create($nolate){ 
        $row = LogicWorkReport::get_work_report_info_by_id($nolate);        
        $time = date('Y-m-d',$row['reportTime']).' 18'.':'.str_pad(rand(1,59),2,'0',STR_PAD_LEFT).':'.str_pad(rand(1,59),2,'0',STR_PAD_LEFT);
        $DataArr = array('created'=>strtotime($time),'late'=>0);
        $WhereArr = array('id'=>$nolate);
        LogicWorkReport::update_work_report_data($DataArr,$WhereArr);
    }
}
