<?php
class MenuController extends WebController {

    public function actionIndex() {
        $this->layout = 'layout';        
        $this->render('/layouts/left');
    }

    public function actionTop() {
        $this->layout = 'layout';
        $this->render('/layouts/top');
    }
}