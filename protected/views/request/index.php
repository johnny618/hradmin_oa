<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>css/liucheng/liucheng.css" />
<div class="pb20">
	<div id="liuch">
    	<div class="liuch_title">新建流程</div>
        <div class="lcIndex clearfix"><!--流程主界面 开始-->
    <?php foreach ($top_menus as $key => $top_menu) {?>
           	<ul class="clearfix lcIndex_box<?php echo $key + 1;?>">
           	<?php foreach ($top_menu as $menu) {?>
               	<li>
               	    <h4><?php echo $menu['value']?></h4>
               	    <?php if (isset($sub_menu[$menu['id']])) foreach ($sub_menu[$menu['id']] as $key => $_menu) { ?>
                    <p class="lcIndex_sub"><a target="_blank" href="<?php echo $this->createUrl('/request/new/' . $key);?>"><?php echo $_menu;?></a></p>
                    <?php }?>
               </li>
           <?php }?>
            </ul>
        <?php }?>
        </div><!--流程主界面 结束-->
    </div>
</div>
<script type="text/javascript">
//自适应高度
function liuCheng(){
	var liuCh = document.getElementById("liuch");
	var bodyHeight = document.documentElement.clientHeight;
	liuCh.style.minHeight = bodyHeight + "px";
}
window.onload = liuCheng;
window.onresize = liuCheng;
</script>