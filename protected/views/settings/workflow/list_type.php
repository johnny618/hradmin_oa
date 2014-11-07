<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>css/set/set.css">
<div class="set">
	 <div class="settype"><!--流程类型 开始-->
		<div class="settitle">列表：流程类型</div>
		<div id="setheight" class="settype_main">
			<div class="settype_newbtn"><a href="<?php echo $this->createUrl('/settings/workflow/add')?>">新建</a></div>
			<div class="settype_table">
				<table width="100%" cellpadding="0" cellspacing="0">
					<tr>
						<th width="38%"><div class="settype_margin"><p>名称</p></div></th>
						<th width="38%"><p>描述</p></th>
						<th width="24%"><p class="settype_p">显示顺序</p></th>
					</tr>
				<?php foreach ($lists as $item) {?>
					<tr>
						<td width="38%"><div class="settype_margin"><a href="<?php echo $this->createUrl('/settings/workflow/edit/' . $item->id);?>"><span><?php echo $item->name;?></span></a></div></td>
						<td width="38%"><?php echo $item->desc;?></td>
						<td width="24%"><?php echo $item->dsporder;?></td>
					</tr>
				<?php }?>
				</table>
			</div>
		</div>
	</div><!--流程类型 结束-->
</div>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>js/set/set.js"></script>
<script type="text/javascript">
//自适应高度
function heightChange(){
	var setHeight = document.getElementById("setheight");
	var bodyHeight = document.documentElement.clientHeight - 9 - 32 - 15;   //9代表的是上外边距，32是标题栏的高度，15是距离浏览器下部分的距离
	setHeight.style.height = bodyHeight + "px";
}
window.onload = heightChange();
</script>