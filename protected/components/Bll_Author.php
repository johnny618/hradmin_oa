<?php

class Bll_Author{
    
    /**
     * 是否有权限显示工作小结监控
     * @return boolean
     */
    public static function check_report_author(){
        if (in_array(MyConst::MENU_REPORT, Yii::app()->user->author)){            
            return true;
        }
        
        if (LogicUser::check_is_leader()){
            return true;
        }
        return false;
    }
    
    /**
     * 是否有权限显示工作小结监控
     * @return boolean
     */
    public static function check_ybr_author(){
        if (in_array(MyConst::MENU_YBR, Yii::app()->user->author)){            
            return true;
        }                
        return false;
    }
    
    /**
     * 是否有权限显示工作小结监控
     * @return boolean
     */
    public static function check_ybr_jiankong_author(){
        if (in_array(MyConst::MENU_YBR_JIANKONG, Yii::app()->user->author)){            
            return true;
        }                
        return false;
    }
    
    /**
     * 是否有权限显示固定资产监控
     * @return boolean
     */
    public static function check_ybr_assets_author(){
        if (in_array(MyConst::MENU_YBR_ASSETS, Yii::app()->user->author)){            
            return true;
        }                
        return false;
    }
    
    /**
     * 是否有权限显示文档
     * @return boolean
     */
    public static function check_ybr_document_author(){
        if (in_array(MyConst::MENU_YBR_DOC, Yii::app()->user->author)){            
            return true;
        }                
        return false;
    }
    
    /**
     * 是否有权限显示创建文档
     * @return type
     */
    public static function check_ybr_create_doc_author(){
        return Bll_Document::create_author();
    }

    /**
     * 是否有查看固定資產權限
     * 根據員工職位判斷是否是總監
     * @return bool
     */
    public static function check_is_director(){
        $findStr = strpos(Yii::app()->user->title,'总监');
        $findZL = strpos(Yii::app()->user->title,'总监助理');
        if ($findStr === false || isset($findZL) ){
            return false;
        }
        return true;
    }
    
}
