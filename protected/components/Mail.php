<?php
class Mail {

    public $Mailer;

    public function __construct() {
        // 获取PHPExcel引用路径
        $phpExcelPath = Yii::getPathOfAlias('application.components');
        // 关闭YII的自动加载功能，改用手动加载，否则会出错，PHPExcel有自己的自动加载功能
        // YII框架对于组件的自动加载，要求类名与文件名一致；
        // 而PHPExcel类对应的文件名包含了上级目录名称，如：IOFactory类对应的文件名为PHPExcel_IOFactory.php
        spl_autoload_unregister(array(
            'YiiBase',
            'autoload'
        ));
        include ($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPMailer_5.2.4/class.phpmailer.php');
        include ($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPMailer_5.2.4/class.smtp.php');
        //恢复Yii自动加载功能
        spl_autoload_register(array(
            'YiiBase',
            'autoload'
        ));
        $this->Mailer = new PHPMailer();
    }

    public function mail($to, $title, $body ,$sender = '易班OA') {
        $this->Mailer = new PHPMailer();
        //采用SMTP发送邮件
        $this->Mailer->IsSMTP();
        //邮件服务器
        $this->Mailer->Host = "smtp.yiban.cn";
        $this->Mailer->SMTPDebug = 0;
        //使用SMPT验证
        $this->Mailer->SMTPAuth = true;
        //SMTP验证的用户名称
        $this->Mailer->Username = "oa_master@yiban.cn";
        //SMTP验证的秘密
        $this->Mailer->Password = "&Noa*CeU!";
        //设置编码格式
        $this->Mailer->CharSet = "utf-8";
        //设置主题
        $this->Mailer->Subject = $title;
        //设置发送者
        $this->Mailer->SetFrom('oa_master@yiban.cn', $sender);
        //采用html格式发送邮件
        $this->Mailer->MsgHTML($body);
        //接受者邮件名称
        $this->Mailer->AddAddress($to); //发送邮件
        if (!$this->Mailer->Send()) {
            echo "Mailer Error: " . $this->Mailer->ErrorInfo;
        } else {
            echo "Message sent!";
        }
    }
}

