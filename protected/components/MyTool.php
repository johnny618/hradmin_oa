<?php
class MyTool{
    /**
     *  得到Excel表格的信息
     * @param type $rows 行
     * @param type $cols 列
     * @param type $cells 元素集合
     * @return type
     */
    public static function getExcelInfo($rows, $cols, $cells){
        $blacklist = array();
        for($i=1;$i<=$rows-1;$i++){
            for($j=1;$j<=$cols;$j++){
                $blacklist[$i][$j] = iconv('gbk', 'utf-8',$cells[$i+1][$j] );
            }
        }
        return $blacklist;
    }
    /**
     *  移动临时文件到 uploads目录中
     * @param type $tmpFile
     * @param type $destination
     * @return type
     */
    public static function moveTmpfile($tmpFile, $destination){
        try{
            if(!move_uploaded_file($tmpFile, $destination)){
                throw new Exception("上传文件的uploads目录有错误，请检查文件权限和属性。");
            }
        }catch(Exception $e){
            return $e->getMessage();

        }
    }

    /**
     *  允许上传的MIME类型
     * @param type $file_type
     * @return type
     */
    public static function allowedMimes($file_type){
        $allowedMimes = array("application/vnd.ms-excel");
        try {
            if(!in_array($file_type, $allowedMimes)){
                throw new Exception("错误，文件类型必须为.xls文件。你上传的
                            文件类型为：".$file_type);
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * 检查文件大小，不超过500k
     * @param type $file_size
     * @return type
     */
    public static function checkFileSize($file_size){
        try{
            if($file_size > 500*1024){
                throw new Exception("对不起，文件不能超过500K，当前大小为：".intval($file_size/1024)."KB");
            }
        }catch (Exception $e){
            return $e->getMessage();
        }
    }

    /**
     *  检查文件长度是否为0
     * @param type $file_size
     * @return type
     */
    public static function isEmptyFile($file_size) {
        try{
            if($file_size == 0){
                throw new Exception("对不起，不能上传空文件或其他格式文件。");
            }
        }catch(Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * 验证文件名钟的非法字符，替换为 _
     * @param type $upload_file
     * @return type
     */
    public static function validIllegalChar($upload_file){
        $errorchar = array("-"," ","~","!","@","#","$","%","^","&","(",
                ")","+",",","（","）","？","！","“","”","《","》","：","；","——"); //定义非法字符集;
        foreach($errorchar as $char){
            if(strpos($upload_file, $char)){
                $new_upload_file = str_replace($char, '_', $upload_file);
                //echo "文件名中含有非法字符！已经替换为\"_\"<br />";
                return $new_upload_file;
            }else{
                return $upload_file;
            }
        }
    }


    /*
     *  新建一个文件目录
     * @param type $dir
     */
    public static function setDir($dir){
        if(!is_dir($dir)){
            mkdir($dir);
        }
    }

    /**
     * 分页功能
     * @author Johnnylin
     * @version 2012-8-20 9:30
     *
     * @return Array(
     *      'final'=>$finalPage,   最后页
     *      'prev'=>$previousPage, 前一页
     *      'next'=>$nextPage,     后一页
     *      'init'=>$init,         初始页（第一页）
     *      'cur'=>$currentPage,   当前页
     *      'size'=>$page_size,    每页显示条目数
     *      'data_count'=>$data_count) 数据总条目数
     *
     * @param type $page_size     每页显示条目数
     * @param type $data_count    数据总条目数
     * @param type $currentPage   当前页
     */
    public static function paging( $data_count, $currentPage, $page_size=10){
        $finalPage = (int)($data_count/$page_size);
        if($data_count % $page_size !=0){
            $finalPage = (int)($data_count/$page_size+1);
        }
        //判断是否有当前页参数，默认设置为第一页
        if(isset($_GET['currentPage'])){
            $currentPage = intval($_GET['currentPage']);
            if($currentPage <= 0 || $currentPage > $finalPage ){
                $currentPage = 1;
            }
        }else{
            $currentPage = 1;
        }
        $init=1;

        $previousPage = $currentPage-1;
        if($previousPage == 1 || $previousPage <= 0){
            $previousPage = 1;
        }

        $nextPage = $currentPage+1;
        if($nextPage == $finalPage || $nextPage == $finalPage+1){
            $nextPage = $finalPage;
        }

        return array('final'=>$finalPage, 'prev'=>$previousPage, 'next'=>$nextPage
            ,'init'=>$init, 'cur'=>$currentPage, 'size'=>$page_size,'data_count'=>$data_count);
    }
    
    /**
     * 页面显示分页的组件
     * @param type $request_uri URL地址
     * @param type $page_info   分页数据内容* @return Array(
     *      'final'=>$finalPage,   最后页
     *      'prev'=>$previousPage, 前一页
     *      'next'=>$nextPage,     后一页
     *      'init'=>$init,         初始页（第一页）
     *      'cur'=>$currentPage,   当前页
     *      'size'=>$page_size,    每页显示条目数
     *      'data_count'=>$data_count) 数据总条目数
     * @param type $show_num   显示页数的长度
     * @param type $start_num   显示页数的数量
     * @return string
     */
    public static function page_show($request_uri = '' , $page_info = array(),$params = array() , $show_num = 5,$start_num = 4 ){        
        $html = '';
        if (empty($page_info) || empty($request_uri)){
            return $html;
        }

        foreach ($params as $paramsKey => $paramsVal){
            if (trim($paramsVal) === ''){
                unset($params[$paramsKey]);
            }
        }        
        $html .= '<div class="page_box">';
        $html .=  '每页显示'.$page_info['size'].' 条，共'.$page_info['data_count'].'条记录，共'.$page_info['final'].'页';
        $html .= '<a href="'.Yii::app()->createUrl($request_uri , array_merge($params , array('currentPage'=>$page_info['init']) ) ) .'">第一页</a>';
        $html .= '<a href="'.Yii::app()->createUrl($request_uri , array_merge($params , array('currentPage'=>$page_info['prev']) ) ) .'">上一页</a>';
        if ($page_info['final'] <= $show_num){
            for($i=1;$i <= $page_info['final'];$i++){ 
                if ($page_info['cur'] == $i){
                    $html .= '<a class="cur" href="'.Yii::app()->createUrl($request_uri , array_merge($params , array('currentPage'=>$i)) ) .'">['.$i.']</a>';
                }else{
                    $html .= '<a href="'.Yii::app()->createUrl($request_uri , array_merge($params , array('currentPage'=>$i)) ) .'">['.$i.']</a>';
                } 
            }
        }else{           
            $page = empty($page_info['cur']) ? 1 : $page_info['cur'];
            if (intval($page)  == 1){
                for($i=1;$i <= 5;$i++){ 
                    if ($page == $i){
                        $html .= '<a class="cur" href="'.Yii::app()->createUrl($request_uri , array_merge($params , array('currentPage'=>$i) ) ) .'">['.$i.']</a>';
                    }else{
                        $html .= '<a href="'.Yii::app()->createUrl($request_uri , array_merge($params , array('currentPage'=>$i) ) ) .'">['.$i.']</a>';
                    }                    
                }
                $html .= '···';
                $html .= '<a href="'.Yii::app()->createUrl($request_uri , array_merge($params , array('currentPage'=>$page_info['final']) ) ) .'">['.$page_info['final'].']</a>';
            }
            
            if (intval($page)  > 1){
                $e_page = $page_info['final'] - $page;
                if ($e_page < $start_num){
                    for($i=$page_info['final'] - $start_num + 1 ;$i <= $page_info['final'];$i++){ 
                        if ($page == $i){
                            $html .= '<a class="cur" href="'.Yii::app()->createUrl($request_uri , array_merge($params , array('currentPage'=>$i) ) ) .'">['.$i.']</a>';
                        }else{
                            $html .= '<a href="'.Yii::app()->createUrl($request_uri , array_merge($params , array('currentPage'=>$i) ) ) .'">['.$i.']</a>';
                        }                        
                    }
                }else{
                    for($i=$page;$i < $page + $start_num -1 ;$i++){ 
                        if ($page == $i){
                            $html .= '<a class="cur" href="'.Yii::app()->createUrl($request_uri , array_merge($params , array('currentPage'=>$i) ) ) .'">['.$i.']</a>';
                        }else{
                            $html .= '<a href="'.Yii::app()->createUrl($request_uri , array_merge($params , array('currentPage'=>$i) ) ) .'">['.$i.']</a>';
                        }  
                    }
                    $html .= '···';
                    $html .= '<a href="'.Yii::app()->createUrl($request_uri , array_merge($params , array('currentPage'=>$page_info['final']) ) ) .'">['.$page_info['final'].']</a>';
                }
            }
        }        
        $html .= '<a href="'.Yii::app()->createUrl($request_uri , array_merge($params , array('currentPage'=>$page_info['next']) ) ) .'">下一页</a>';
        $html .= '<a href="'.Yii::app()->createUrl($request_uri , array_merge($params , array('currentPage'=>$page_info['final']) ) ).'">最后一页</a>';
        $html .= '</div>';
        return $html;
    }


    /**
     * 因为某一键名的值不能重复，删除重复项
     * @param type $arr
     * @param type $key
     * @return type
     */
    public static function assoc_unique($arr, $key){
        $tmp_arr = array();
        foreach($arr as $k => $v){
            if(in_array($v[$key], $tmp_arr)){//搜索$v[$key]是否在$tmp_arr数组中存在，若存在返回true
                unset($arr[$k]);
            }else {
                  $tmp_arr[] = $v[$key];
            }
        }
        sort($arr); //sort函数对数组进行排序
        return $arr;
    }

    /**
     * 因内部的一维数组不能完全相同，而删除重复项
     * @param type $array2D
     * @return type
     */
    public static function array_unique_fb($array2D){
        foreach ($array2D as $v){
            $v = join(",",$v); //降维,也可以用implode,将一维数组转换为用逗号连接的字符串
            $temp[] = $v;
        }
        $temp = array_unique($temp);    //去掉重复的字符串,也就是重复的一维数组
        foreach ($temp as $k => $v){
            $temp[$k] = explode(",",$v);   //再将拆开的数组重新组装
        }
        return $temp;
    }

    /**
     * 判断是否为数字
     * @param  $str
     * @param  $utf8
     * @return boolean
     */
    public static function digit($str, $utf8 = FALSE) {
        if ($utf8 === TRUE) {
            return (bool)preg_match('/^\pN++$/uD', $str);
        } else {
            return (is_int($str) and $str >= 0) or ctype_digit($str);
        }
    }
    
    /**
     * 
     * @param type $arr
     * @param type $key
     */
    public static function init_key_of_arrays($arr,$key){
        if (empty($arr)){ return array(); }
        $result = array();
        foreach($arr as $arrKey => $arrVal){
            $result[$arrVal[$key]][] = $arrVal;
        }
        return $result;
    }
    
    /**
     * 
     * @param type $arr
     * @param type $key
     */
    public static function init_key_of_array($arr,$key){
        if (empty($arr)){ return array(); }
        $result = array();
        foreach($arr as $arrKey => $arrVal){
            $result[$arrVal[$key]] = $arrVal;
        }
        return $result;
    }
    
    /**
     * 
     * @param type $arr
     * @param type $key
     */
    public static function _init_key_of_array($arr,$key,$val){
        if (empty($arr)){ return array(); }
        $result = array();
        foreach($arr as $arrKey => $arrVal){
            $result[$arrVal[$key]] = $arrVal[$val];
        }
        return $result;
    }

    public static function html_to_code($str){
        $str = trim($str); 
        $str = str_replace("\t","",$str); 
        $str = str_replace("\r\n","",$str); 
        $str = str_replace("\r","",$str); 
        $str = str_replace("\n","",$str); 

        return trim($str); 
    }
    
    public static function get_val_of_key($arr,$key){
        if (!empty($arr[$key])){
            return $arr[$key];
        }
        return '';
    }
    
    /**     
     * @param type $date 日期
     * @param type $number 增加/减少
     * @param type $ntype 类型 day week months 
     * @param type $format 
     * @return type
     */   
    public static function init_date_format($date,$number = 1,$ntype = 'day' ,$format = 'Y-m-d'){
        return date($format, strtotime("{$number} {$ntype}", strtotime($date)));
    }
    
    /*
      Utf-8、gb2312都支持的汉字截取函数
      cut_str(字符串, 截取长度, 开始长度, 编码);
      编码默认为 utf-8
      开始长度默认为 0
     */
    public static function cut_str($string, $sublen, $start = 0, $code = 'UTF-8') {
        if ($code == 'UTF-8') {
            $pa = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";

            $re['UTF-8']  = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
            $re['GB2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
            $re['GBK']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
            $re['BIG5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";

            preg_match_all($pa, $string, $t_string);
            if (count($t_string[0]) - $start > $sublen) {
                return join('', array_slice($t_string[0], $start, $sublen)) . "...";
            } else {
                return join('', array_slice($t_string[0], $start, $sublen));
            }
        } else {
            $start = $start * 2;
            $sublen = $sublen * 2;
            $strlen = strlen($string);
            $tmpstr = '';
            for ($i = 0; $i < $strlen; $i++) {
                if ($i >= $start && $i < ($start + $sublen)) {
                    if (ord(substr($string, $i, 1)) > 129) {
                        $tmpstr.= substr($string, $i, 2);
                    } else {
                        $tmpstr.= substr($string, $i, 1);
                    }
                }
                if (ord(substr($string, $i, 1)) > 129)
                    $i++;
            }
            if (strlen($tmpstr) < $strlen) {
                $tmpstr.= "...";
            } else {
                $tmpstr .= "...";
            }
            return $tmpstr;
        }
    }


    /*********************************************************************
    函数名称:encrypt
    函数作用:加密解密字符串
    使用方法:
    加密     :encrypt('str','E','nowamagic');
    解密     :encrypt('被加密过的字符串','D','nowamagic');
    参数说明:
    $string   :需要加密解密的字符串
    $operation:判断是加密还是解密:E:加密   D:解密
    $key      :加密的钥匙(密匙);
     *********************************************************************/
    function encrypt($string,$operation,$key='nowamagic')
    {
        $key=md5($key);
        $key_length=strlen($key);
        $string=$operation=='D'?base64_decode($string):substr(md5($string.$key),0,8).$string;
        $string_length=strlen($string);
        $rndkey=$box=array();
        $result='';
        for($i=0;$i<=255;$i++)
        {
            $rndkey[$i]=ord($key[$i%$key_length]);
            $box[$i]=$i;
        }
        for($j=$i=0;$i<256;$i++)
        {
            $j=($j+$box[$i]+$rndkey[$i])%256;
            $tmp=$box[$i];
            $box[$i]=$box[$j];
            $box[$j]=$tmp;
        }
        for($a=$j=$i=0;$i<$string_length;$i++)
        {
            $a=($a+1)%256;
            $j=($j+$box[$a])%256;
            $tmp=$box[$a];
            $box[$a]=$box[$j];
            $box[$j]=$tmp;
            $result.=chr(ord($string[$i])^($box[($box[$a]+$box[$j])%256]));
        }
        if($operation=='D')
        {
            if(substr($result,0,8)==substr(md5(substr($result,8).$key),0,8))
            {
                return substr($result,8);
            }
            else
            {
                return'';
            }
        }
        else
        {
            return str_replace('=','',base64_encode($result));
        }
    }

}
?>
