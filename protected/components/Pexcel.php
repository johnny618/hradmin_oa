<?php

class Pexcel { 
    
    public static function autoload(){
        // get a reference to the path of PHPExcel classes 
        $phpExcelPath = Yii::getPathOfAlias('ext.pexcel');
        // Turn off our amazing library autoload 
        spl_autoload_unregister(array('YiiBase','autoload'));        

        // making use of our reference, include the main class
        // when we do this, phpExcel has its own autoload registration
        // procedure (PHPExcel_Autoloader::Register();)
        include_once($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel.php');
//        include_once($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel/IOFactory.php');
//        include_once($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel/Writer/Excel2007.php'); 
        $objPHPExcel = new PHPExcel();  

        $objPHPExcel->getProperties()->setCreator("JohNnY")  
                                     ->setLastModifiedBy("JohNnY")  
                                     ->setTitle("Office 2007 XLSX Test Document")  
                                     ->setSubject("Office 2007 XLSX Test Document")  
                                     ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")  
                                     ->setKeywords("office 2007 openxml php")  
                                     ->setCategory("result file");  
        
        return $objPHPExcel;
    }
    
    public static function save_excel($objPHPExcel,$name = ''){
        //          $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');  
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);  
        
        $xlsName = !empty($name) ? $name.date('Ymd',time()) : date('Ymd',time());
        ob_start(); ob_flush(); 
        header("Content-Type: application/force-download"); 
        //header('Content-Type: application/vnd.ms-excel;charset=utf8');
        header("Content-Type:application/vnd.ms-execl");  
        header("Content-Type: application/octet-stream"); 
        header("Content-Type: application/download"); 
        header('Content-Disposition:inline;filename="'.$xlsName.'.xls'.'"'); 
        header("Content-Transfer-Encoding: binary"); 
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
        header("Pragma: no-cache"); 
        $objWriter->save( "php://output" );

        Yii::app()->end();  
        spl_autoload_register(array('YiiBase','autoload'));  
    }
    
    public static function &set_val(){
        //$objPHPExcel = self::autoload();   //载入PHPEXCEL插件
        
//        $objPHPExcel->setActiveSheetIndex(0); 
//        $objActSheet = $objPHPExcel->getActiveSheet(); 
//        $objPHPExcel->setActiveSheetIndex(0)  
//                    ->setCellValue('A1', '商品编码')  
//                    ->setCellValue('B1', '商品名称')
//                    ->setCellValue('C1', '商品规格')  
//                    ->setCellValue('D1', '盘点库存')  
//                    ->setCellValue('E1', '账面库存');  
//
//        $objPHPExcel->setActiveSheetIndex(0)  
//                    ->setCellValue("A2", '$one->gd_sn')  
//                    ->setCellValue("B2", '$one->gd_name')  
//                    ->setCellValue("C2", '123123')  
//                    ->setCellValue("D2", '$one->order_num')  
//                    ->setCellValue("E2", '$one->stock_num');              
//        $objPHPExcel->getActiveSheet()->setTitle('盘点单');  
//
//        $objPHPExcel->createSheet(); 
//        $objPHPExcel->setActiveSheetIndex(1)->setTitle('测试2');                   
//        $objPHPExcel->setActiveSheetIndex(1)
//                    ->setCellValue('A1', '商品编码')  
//                    ->setCellValue('B1', '商品名称')  
//                    ->setCellValue('C1', '商品规格')  
//                    ->setCellValue('D1', '盘点库存')  
//                    ->setCellValue('E1', '账面库存');  
//        $objPHPExcel->setActiveSheetIndex(1)
//                    ->setCellValue("A2", '真的可以么')  
//                    ->setCellValue("B2", 'adfsdadfASDDAS123!#^%$#@')  
//                    ->setCellValue("C2", '123123')  
//                    ->setCellValue("D2", '$one->order_num')  
//                    ->setCellValue("E2", '$one->stock_num');  

        //self::save_excel($objPHPExcel);    //生成EXCEL
        
    }
}
