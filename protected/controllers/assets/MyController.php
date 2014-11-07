<?php
/**
 * 易班人积分
 * @author JohNnY 
 * 
 */
class MyController extends WebController {        
    
    public function actionIndex(){     
        $params = $this->params();
        $author = Bll_Author::check_ybr_assets_author();
        
        $uid = Yii::app()->user->id;
        $uname = Yii::app()->user->name;
        if ($author){
            $uid = !empty($params['createrid']) ? $params['createrid'] : Yii::app()->user->id;
            $uname = !empty($params['creater']) ? $params['creater'] : Yii::app()->user->name;
        }

        $data = API_OA::get_assets_by_id($uid);
        $deptArr = API_OA::get_all_dept();  
        
        $this->render('list',array('deptArr'=>$deptArr ,'uid'=>$uid ,'uname'=>$uname  ,'author'=>$author,'data'=>$data,'tabletitle'=>  $this->tabletitle()));    
    }


    private function tabletitle(){
//        owner:保管人
//eid:工号
//cid:公司固定资产编号
//tuid:电大固定资产编号
//type:资产类型
//brand:品牌
//model:型号
//config:配置
//remarks:备注
        return array('cid'=>'中心固定资产编号','tuid'=>'开大固定资产编号','asset_type'=>'资产类型','type'=>'设备类型','brand'=>'品牌','model'=>'型号','config'=>'配置','remarks'=>'备注');
    }
}