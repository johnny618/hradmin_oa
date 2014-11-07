<?php
class MyConst {
    const OA_API_URL = 'http://10.21.5.30';    
    
    // ******************** 菜单编码 START *************************
    const MENU_REPORT = 1;              //工作小结    
    const MENU_YBR = 2;                 //易班积分 
    const MENU_YBR_JIANKONG = 3;        //易班积分监控
    const MENU_YBR_ASSETS = 4;          //固定资产
    const MENU_YBR_DOC = 5;             //文档
    
    public static $meuns_arr = array(
        self::MENU_REPORT => '工作小结',
        self::MENU_YBR => '易班积分',  
        self::MENU_YBR_JIANKONG => '易班积分监控',  
        self::MENU_YBR_ASSETS => '固定资产',  
        self::MENU_YBR_DOC => '文档',  
    );
    // ******************** 菜单编码 END *************************

    /**
     * 考勤系统权限名单 
     * 做在数据库里，数据容易被修改 所以用固定配置保证数据安全性
     */
    public static $attendance_users = array(
        '0' => '10000101',        
        '1' => '10000405',
        '2' => '10000410',
    );
    
    /**
     * 菜单权限名单
     */
    public static $ad_users = array(
        '0' => '10000101',        
        '1' => '10000405',
        '2' => '10000410',
        '3' => '10000001',
        '4' => '10000002',
        '5' => '10000476',
        '6' => '10000214',
    );
    
    /**
     * 节点类型
     */
    public static $nodeType = array(
        '0' => '创建',        
        '1' => '审批',
        '999' => '归档',
    );

    /**
     * 主字段信息
     */
    public static $formType = array(
        '1' => '单行文本框',
        '2' => '多行文本框',
        '3' => 'Check框',
        '4' => '选择框',
        '5' => '附件上传',
        '6' => '特殊字段',
        '201' => '开通网络权限',
        '202' => '开通邮箱'
    );

    /**
     * 明细字段信息
     */
    public static $formTypeDetail = array(
        '1' => '单行文本框',
        '2' => '多行文本框',
        '3' => 'Check框',
        '4' => '选择框'
    );

    /**
     * 字段类型
     */
    public static $formItem = array(
        '1' => array(
            '1' => '文本',
            '103' => '数字',
            '3' => '日期'
        ),
        '5' => array(
            '1' => '上传文件',
            '2' => '上传图片'
        ),
        '6' => array(
            '1' => '自定义链接',
            '2' => '描述性文字'
        )
    );

    /**
     * 出口信息字节 条件所要显示的字段类型
     */
    public static $formItemTerm = array('101'=>'申请人',
        '102'=>'部门',
        '103'=>'数字',
        '104'=>'角色',        
    );

    /**
     * 出口信息字节 条件 类型
     */
    public static $_TermType = array(
        '101'=>array( '='=>'属于', '!='=>'不属于') ,
        '102'=>array( '='=>'属于', '!='=>'不属于') ,
        '103'=>array('>'=>'大于',
                    '>='=>'大于或等于',
                    '<'=>'小于',
                    '<='=>'小于或等于',
                    '='=>'等于',
                    '!='=>'不等于') ,
        '104'=>array( '='=>'属于', '!='=>'不属于') ,
        '4'=>array( '='=>'等于', '!='=>'不等于') ,
    );
    
    /**
     * 是 | 否
     */
    public static $_YesNo = array(1=>"是",0=>"否");

    /**
     * 返回星期中文
     * @var type 
     */
    public static $_WeekArr = array(0=>"星期日",1=>"星期一",2=>"星期二",3=>"星期三",4=>"星期四",5=>"星期五",6=>"星期六",7=>"星期日");
    
    
}
