<?php
class MenuWidget extends CWidget {

    public function run() {
        $top_menus = WorkForm::instance()->getTopMenu();
        $sub_menus = array();
        foreach ($top_menus as $key => $menu) {
            $sub_menus[$key] = WorkForm::instance()->getSubMenu($key);
        }
        $this->render('menu', array('top_menus' => $top_menus, 'sub_menus' => $sub_menus));
    }
}