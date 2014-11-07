du<?php
/**
 * 固定资产监控
 * @author JohnnyLin
 *
 */
class MonitorController extends WebController {

    public function beforeAction($action) {
        if (!Bll_Author::check_ybr_assets_author() && !Bll_Author::check_is_director()) {
            throw new CHttpException('500','无权限访问');
        }
        return true;
    }
    
    public function actionIndex(){    
        $params = $this->params();
        $author = Bll_Author::check_ybr_assets_author();
        $classify = array();
        if (!empty($params)){
            foreach ($params as $paramsKey => $paramsVal){
                if (!empty($paramsVal)){
                    $classify[$paramsKey] = $paramsVal;
                }
            }
        }
        if (!$author){
            $classify['dept'] = Yii::app()->user->dept_cn;
        }
        $dataAll = API_OA::get_assets_by_classify($classify);
        $this->render('list',array('dataAll'=>$dataAll,'params'=>$params,'author'=>$author));
    }

    

}