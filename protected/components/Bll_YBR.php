<?php

class Bll_YBR{
    
    //获取星级
    static public function get_star_lv($score){
        if ($score >= 100 && $score < 300){
            return '一星易班人';
        }else if ($score >= 300 && $score < 600){
            return '二星易班人';
        }else if ($score >= 600 && $score < 1000){
            return '三星易班人';
        }else if ($score >= 1000 && $score < 2000){
            return '四星易班人';
        }else if ($score >= 2000){
            return '五星易班人';
        }else{
            return '';            
        }
    }

    static public function cycle_arr(){
        return array(0=>'不定期',1=>'月度',2=>'季度',3=>'年度');
    }

    static public function get_cn_cycle_by_cyclekey($key){
        if (isset($key)){
            return '';
        }
        $cycleArr = self::cycle_arr();
        return $cycleArr[$key];
    }

    /*
     * 根據時間類型返回日期類型
     */
    static public function init_date_by_cycle($date,$type='0'){
        if (empty($date)){
            return '';
        }
        $result = '';
        switch ((int)$type){
            case 1:
            case 2:
                $result = date('Y-m',strtotime($date));
                break;
            case 3:
                $result = date('Y',strtotime($date));
                break;
            case 0:
            default:
                $result = $date;
                break;
        }
        return $result;
    }

    static public function get_status_of_score($score,$oldscore){
        if ($score > $oldscore){
            return '上升';
        }else if($score < $oldscore){
            return '下降';
        }else if ($score == $oldscore){
            return '不变';
        }
    }
}
