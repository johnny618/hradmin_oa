<?php
class AjaxController extends WebController {

    public static function exitWithCodeAndMsg($code, $msg = '') {
        if (!is_int($code)) {
            throw new Exception('code not int');
        }

        if (!is_string($msg)) {
            throw new Exception('msg not string');
        }

        exit(json_encode(array(
            'code' => $code,
            'msg' => $msg
        )));
    }
}