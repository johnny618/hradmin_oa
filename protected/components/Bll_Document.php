<?php

class Bll_Document{
    
    
    static public $doc_title = array(1=>'通知公告',
            2=>'中心制度',
            3=>'值班表',
            4=>'易班大事记');
    
    
    public static function create_author(){
        $data = LogicDocAuthority::get_user_author_of_tid();     
        if (!empty($data)){
            return true;
        }
        return false;
    }
    
    static public function reg_html_p_st($html){
        return preg_match("/<p.*?/p>/", $html);
    }
    
    static public function filter_html_str($str){
        $str=str_replace("<br>",chr(10),$str);
        $str=str_replace("&nbsp;",chr(32),$str);
        return MyTool::cut_str($str, 170);
    }
    
}
