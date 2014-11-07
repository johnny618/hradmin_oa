<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class ExModel extends CActiveRecord{
    public function init_model($params,$tabKey){
            $result = array();
            if (!empty($params)){
                foreach($params as $paramsKey => $paramsVal){
                    $result[$paramsKey] = $paramsVal;
                }
            }
            return $result;
            //return $this->Model_Vals();
    }
    //abstract public function Model_Vals();
}
