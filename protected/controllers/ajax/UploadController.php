<?php
class UploadController extends AjaxController {

    public function actionIndex() {
        $uploadedfile = $_FILES['files'];
        if (!is_uploaded_file($uploadedfile['tmp_name'][0])) {
            self::exitWithCodeAndMsg(1);
        }
        if (!isset($uploadedfile['name'][0])) {
            self::exitWithCodeAndMsg(1);
        }

        $params = $this->params();
        $name = $uploadedfile['name'][0];
        $type = @explode('.', $name);
        $type = $type[count($type)-1];
        $tp = array('JPG', 'jpg', 'jpeg', 'gif', 'png');
        if (!isset($params['file'])) {
            if (!in_array($type,$tp)) {
                self::exitWithCodeAndMsg(1, '格式错误');
            }
        }
        $dir = Yii::app()->basePath . '/../upload/' . date('Ymd') . '/' . Yii::app()->user->id . '/' . md5(Yii::app()->user->id . date('Ymd') . mt_rand(0, 10000));
        $path_arr = explode('/', $dir);
        $str = '';
        foreach($path_arr as $k => $path) {
            if ($k > 0) {
                $str = $str . '/' . $path;
                if (!is_dir($str)) {
                    mkdir($str);
                }
            }
        }
        $new_name = $dir . $uploadedfile['name'][0];
        if (move_uploaded_file($uploadedfile['tmp_name'][0], $new_name)) {
            self::exitWithCodeAndMsg(0, str_replace(Yii::app()->basePath . '/..', '', $new_name));
        } else {
            self::exitWithCodeAndMsg(1);
        }
    }

}