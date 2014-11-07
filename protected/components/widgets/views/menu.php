<div id="road_act" class="road_left"><!--路径左边功能 开始-->
<?php foreach ($top_menus as $key => $top_menu) {?>
	<h4><a href="#"><?php echo $top_menu;?></a></h4>
	<div class="road_sub">
	<?php foreach ($sub_menus[$key] as $id => $sub_menu) {?>
		<div class="road_sub_box">
        	<a class="road_sub_boxtitle" href="<?php echo Yii::app()->createUrl('/settings/formnode/index/' . $id)?>"  target="set_iframe"><?php echo $sub_menu;?></a>
        	<?php if (0) {?>
            <ul class="clearfix">
                <li><a href="<?php echo Yii::app()->createUrl('/settings/formnode/index/' . $id)?>">节点信息</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('/settings/process/index/' . $id)?>" target="set_iframe">出口信息</a></li>
            </ul>
            <?php }?>
        </div>
    <?php }?>
	</div>
<?php }?>
    <div id="road_toogle_height" class="road_toogle"><a id="road_toogle" href="javascript:void(0)"></a></div>
</div><!--路径左边功能 结束-->
