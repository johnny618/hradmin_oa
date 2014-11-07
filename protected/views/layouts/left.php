<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>OA管理平台</title>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>/css/home.css">
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>/js/oa.js"<?php echo time();?>></script>
<script type="text/javascript">
$(document).ready(function (){
  $('#actNav li .act_nav_a').click(function(){
              if($(this).parents("li").hasClass("cur")){
                $(this).parents("li").removeClass("cur");
                if ($(this).attr('href') != '#') {
		  $('#Main', parent.document).attr('src', $(this).attr('href'));
		  return false;
                    }
              }
              else{
                $(this).parents("li").addClass("cur").siblings().removeClass("cur");
                if ($(this).attr('href') != '#') {
		  $('#Main', parent.document).attr('src', $(this).attr('href'));
		  return false;
                    }
              }
          });
   $(".act_sub a").click(function(){
       if ($(this).attr('href') != '#') {
		  $('#Main', parent.document).attr('src', $(this).attr('href'));
		  return false;
                    }
   })
});
</script>
</head>
<body class="body_left" style="background:#002C59;">
	<div class="act"><!--左侧功能 开始-->
<!--		<div class="user">用户信息 开始
			<img src="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>images/oa_user.jpg">
			<h3><?php echo Yii::app()->user->name;?></h3>
			<h4><?php echo Yii::app()->user->dept_cn;?></h4>
 			<div class="user_btn"><a class="user_btn1" href="javascript:void(0)"></a><a class="user_btn2" href="javascript:void(0)"></a></div>
		</div>用户信息 结束-->
		<div class="act_nav"><!--功能菜单 开始-->
			<ul id="actNav" class="clearfix">
				<li>
					<div class="act_nav_title"><a class="act_nav1 act_nav_a" href="<?php echo $this->createUrl('/index/show');?>">门 户</a></div>
				</li>
                            
                                <li>
					<div class="act_nav_title"><a class="act_nav7 act_nav_a" href="javascript:;">个 人</a></div>
					<div class="act_nav_border"></div>
					<div class="act_sub"><!--功能下拉菜单 开始-->
					   <p><a href="<?php echo $this->createUrl('/me/index')?>">修改密码</a></p>
					</div><!--功能下拉菜单 结束-->
				</li>
                           
				<li>
					<div class="act_nav_title"><a class="act_nav2 act_nav_a" href="javascript:;">流 程</a></div>
					<div class="act_nav_border"></div>
					<div class="act_sub"><!--功能下拉菜单 开始-->
					   <p><a href="<?php echo $this->createUrl('/request')?>">新建流程</a></p>
<!--					   <p><a href="<?php echo $this->createUrl('/request/my?type=0')?>">我的待办</a></p>
                                            <p><a href="<?php echo $this->createUrl('/request/my?type=1')?>">我的已办</a></p>-->
                                           <p><a href="<?php echo $this->createUrl('/request/my?type=1')?>">未完事宜</a></p>
                                            <p><a href="<?php echo $this->createUrl('/request/my?type=999')?>">我的办结</a></p>
					</div><!--功能下拉菜单 结束-->
				</li>

				<li>
					<div class="act_nav_title act_nav_title2 act_nav_titleHover"><a class="act_nav3 act_nav_a" href="javascript:;">文 档</a></div>
					<div class="act_nav_border act_nav_border2"></div>
					<div class="act_sub act_sub2"><!--功能下拉菜单 开始-->	
                       <?php if (Bll_Author::check_ybr_document_author()):?>
                            <p><a href="<?php echo $this->createUrl('/document/model/index')?>" >模块权限</a></p>
                       <?php endif;?>
                       <?php if (Bll_Author::check_ybr_create_doc_author()):?>
                            <p><a href="<?php echo $this->createUrl('/document/create/index')?>">新建文档</a></p>
                       <?php endif;?>

                        <?php if (Bll_Author::check_ybr_document_author() || Bll_Author::check_ybr_create_doc_author()):?>
                            <p><a href="<?php echo $this->createUrl('/document/create/list')?>">我的文档</a></p>
                        <?php endif;?>

                        <?php foreach(Bll_Document::$doc_title as $key => $val):?>
                            <p><a href="<?php echo $this->createUrl('/document/list/index',array('tid'=> $key))?>"><?php echo $val;?></a></p>
                        <?php endforeach;?>
                    </div><!--功能下拉菜单 结束-->
				</li>

                            
				<?php if (Yii::app()->user->showRequestMenu) {?>
                                <li>
                                    <div class="act_nav_title"><a class="act_nav6 act_nav_a" href="javascript:;">事 宜</a></div>
                                    <div class="act_nav_border"></div>
                                    <div class="act_sub"><!--功能下拉菜单 开始-->
                                       <p><a href="<?php echo $this->createUrl('/request/needdolist')?>">待办事宜</a></p>
                                       <p><a href="<?php echo $this->createUrl('/request/donelist')?>">已办事宜</a></p>
                                    </div><!--功能下拉菜单 结束-->
				</li>
				<?php }?> 
                            

                    <li>
                            <div class="act_nav_title"><a class="act_nav10 act_nav_a" href="javascript:;">易班人</a></div>
                            <div class="act_nav_border"></div>
                            <div class="act_sub"><!--功能下拉菜单 开始-->
                                <?php if (Bll_Author::check_ybr_author()):?>
                                    <p><a href="<?php echo $this->createUrl('/points/model/index')?>" target="main">模块信息</a></p>
                                    <p><a href="<?php echo $this->createUrl('/points/set/index')?>" target="main">模块列表</a></p>
                                    <p><a href="<?php echo $this->createUrl('/points/export/index')?>" target="main">信息导出</a></p>
                                <?php endif;?>
                                <p><a href="<?php echo $this->createUrl('/points/my/index')?>" target="main">个人信息</a></p>
                            </div><!--功能下拉菜单 结束--><strong></strong>
                    </li>

                            
                <li>
                    <div class="act_nav_title"><a class="act_nav8 act_nav_a" href="javascript:;">小结</a></div>
                    <div class="act_nav_border"></div>
                    <div class="act_sub"><!--功能下拉菜单 开始-->
                    <p><a href="<?php echo $this->createUrl('/workreport/workentry/index')?>">创建小结</a></p>
                    <p><a href="<?php echo $this->createUrl('/workreport/mywork/list')?>">历史小结</a></p>
                    <?php if (Bll_Author::check_report_author()):?>
                        <p><a href="<?php echo $this->createUrl('/workreport/monitor/index')?>">审阅小结</a></p>
                        <p><a href="<?php echo $this->createUrl('/workreport/monitor/export')?>">导出小结</a></p>
                    <?php endif;?>

                    </div><!--功能下拉菜单 结束-->
				</li>
                           
				<?php if (in_array(Yii::app()->user->id, MyConst::$ad_users)) {?>
				<li>
					<div class="act_nav_title"><a class="act_nav5 act_nav_a" href="javascript:;">设 置</a></div>
					<div class="act_nav_border"></div>
                    <div class="act_sub"><!--功能下拉菜单 开始-->
                                            <p><a href="<?php echo $this->createUrl('/settings/workflow/listtype')?>" target="main">类型设置</a></p>
                                            <p><a href="<?php echo $this->createUrl('/settings/workform/');?>">表单设置</a></p>
                                            <p><a href="<?php echo $this->createUrl('/settings/formnode/base')?>">路径设置</a></p>
                                            <p><a href="<?php echo $this->createUrl('/settings/monitor/index')?>">流程监控</a></p>
                                            <p><a href="<?php echo $this->createUrl('/settings/role/index')?>">角色设置</a></p>
                                            <p><a href="<?php echo $this->createUrl('/settings/hr/search')?>">查询人员</a></p>
                                            <p><a href="<?php echo $this->createUrl('/settings/entry/index')?>">员工录入</a></p>
					</div><!--功能下拉菜单 结束--><strong></strong>
				</li>
				<?php }?>
                            
                            <li>
                                    <div class="act_nav_title"><a class="act_nav11 act_nav_a" href="javascript:;">资 产</a></div>
                                    <div class="act_nav_border"></div>
                <div class="act_sub"><!--功能下拉菜单 开始-->
                                       <p><a href="<?php echo $this->createUrl('/assets/my')?>" target="main">个人资产</a></p>
                                    <?php if (Bll_Author::check_ybr_assets_author() || Bll_Author::check_is_director()):?>
                                       <p><a href="<?php echo $this->createUrl('/assets/monitor')?>" target="main">资产监控</a></p>
                                    <?php endif;?>
                                    </div><!--功能下拉菜单 结束--><strong></strong>
                            </li>
                           
                            <?php if (0) {?>
                                <?php if (in_array(Yii::app()->user->id, MyConst::$attendance_users)) {?>
                                    <li>
                                            <div class="act_nav_title"><a class="act_nav9 act_nav_a" href="javascript:;">考 勤</a></div>
                                            <div class="act_nav_border"></div>
                        <div class="act_sub"><!--功能下拉菜单 开始-->
                                               <p><a href="<?php echo $this->createUrl('/attend/index')?>" target="main">数据统计</a></p>				
                                            </div><!--功能下拉菜单 结束--><strong></strong>
                                    </li>
                                <?php }?>
                            <?php }?>
			</ul>
		</div><!--功能菜单 结束-->
	</div><!--左侧功能结束-->
	<div class="clear"></div>
</body>
</html>