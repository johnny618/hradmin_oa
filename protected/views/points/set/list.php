<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>css/set/set.css">
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>css/pagestyle.css">
<div class="set">
	 <div class="settype"><!--流程类型 开始-->
		<div class="settitle">模块展示</div>
		<div id="setheight" class="settype_main">
                    <div class="settype_newbtn"></div>
			<div class="settype_table">
				<table width="100%" cellpadding="0" cellspacing="0">
					<tr>
						<th width="30%"><div class="settype_margin"><p>模块名称</p></div></th>						
						<th width="70%"><p class="settype_p">评判标准</p></th>
					</tr>
                                        <?php foreach ($rows as $rowsVal) {?>
                                                <tr>
                                                    <td ><div class="settype_margin">
                                                            <span><?php echo $parent[$rowsVal['parent_id']];?></span>
                                                        </div></td>
                                                     <td > <a href="<?php echo Yii::app()->createUrl('/points/set/info',array('id'=>$rowsVal['id']))?>"><?php echo $rowsVal['name'];?></a></td>
                                                </tr>
                                        <?php }?>
				</table>
                            <div class="clearfix"></div>    
                                <?php echo MyTool::page_show('/points/set/index/',$page);?>    
                            <div class="clearfix"></div>
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