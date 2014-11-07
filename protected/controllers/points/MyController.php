<?php
/**
 * 易班人积分
 * @author JohNnY 
 * 
 */
class MyController extends WebController {        
    
    public function actionIndex(){     
        $params = $this->params();
        $author = Bll_Author::check_ybr_jiankong_author();
        
        $uid = Yii::app()->user->id;
        $uname = Yii::app()->user->name;
        if ($author){
            $uid = !empty($params['createrid']) ? $params['createrid'] : Yii::app()->user->id;
            $uname = !empty($params['creater']) ? $params['creater'] : Yii::app()->user->name;
        }
        
        $deptArr = API_OA::get_all_dept();    
        $date = !empty($params['date']) ? $params['date'] : date('Y-m',time()) ;        
        $data = LogicPointsInfo::get_data_by_uid($uid,$date );
        $oldscore = LogicPointsInfo::get_old_score_by_uid($uid,$date);
        $sumscore = LogicPointsInfo::get_sum_score_by_uid($uid);
        if (empty($sumscore)){
            $sumscore = 0;
        }
        if (empty($oldscore)){
            $oldscore = 0;
        }
        $score = 0 ;
        $_items = array();
        if (!empty($data)){
            foreach ($data as $dataVal){
                $ids[] = $dataVal['pid'];
                $score = $score + $dataVal['score'];
            }   

            $items = LogicPointsItem::get_data_row_by_ids($ids);
            foreach ($items as $itemsVal){
                $_items[$itemsVal['id']] = $itemsVal['name'];
            }
        }
        $this->render('list',array('deptArr'=>$deptArr ,'uid'=>$uid ,'uname'=>$uname , 'author'=>$author ,'score'=>$score , 'oldscore'=>$oldscore , 'sumscore'=>$sumscore, 'date'=>$date, 'items'=>$_items,'data'=>$data));    
    }


}