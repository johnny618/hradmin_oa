<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>css/set/set.css">
	<div id="roadheight" class="set">
	<div id="road_right" class="road_right"><!--右侧工作流 开始-->
            	<div class="node_tab"><!--节点tab菜单 开始-->
                	<ul class="clearfix">
                    	<li class="node_tabborder"><a href="<?php echo Yii::app()->createUrl('/settings/formnode/index/' . $id)?>">节点信息</a></li>
                        <li><a href="<?php echo Yii::app()->createUrl('/settings/process/index/' . $id)?>">出口信息</a></li>
                        <li><a href="<?php echo Yii::app()->createUrl('/settings/formview/index/' , array('fid'=>$id))?>">图形编辑</a></li>
                    </ul>
                </div><!--节点tab菜单 结束-->
                <div class="node_table"><!--节点表格 开始-->
                	<div class="node_btn"><a href="<?php echo $this->createUrl('/settings/formnode/nodeSetup/' . $id);?>">编辑</a>节点信息</div>
                    <table width="96%" cellpadding="0" cellspacing="0">
                    	<tr>
                            <th width="37%"><h4 class="node_margin">节点名称</h4></th>
                            <th width="21%"><h4>节点类型</h4></th>
                            <th width="26%"><h4>节点表单字段</h4></th>
                            <th width="16%"><h4>操作者</h4></th>
                        </tr>
                        <?php foreach ($list as $item) {?>
                            <tr>
                                 <td><label><?php echo $item->name;?></label></td>
                                 <td><?php echo MyConst::$nodeType[$item->type];?></td>
                                 <td><a href="<?php echo $this->createUrl('/settings/formnode/fieldEdit/' . $item->id);?>">设置</a></td>
                                 <td><a href="<?php echo $this->createUrl('/settings/formnode/operate/' . $item->id);?>"><?php echo $item->name;?></a></td>
                            </tr>
			<?php }?>
                    </table>
                </div><!--节点表格 结束-->
            </div><!--右侧工作流结束-->
         </div>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>js/set/set.js"></script>
 <script type="text/javascript">
 //自适应高度
function heightChange(){
	var roadRight = document.getElementById("road_right");
	var bodyHeight = document.documentElement.clientHeight - 9 - 15;   //9代表的是上外边距，32是标题栏的高度，15是距离浏览器下部分的距离
	roadRight.style.height = bodyHeight + "px";
	roadRight.style.backgroundColor = "#fff";
}
heightChange();
window.onreset = heightChange;
//表单设置
$(function(){
	$(".node_table tr:odd").find("td").css({"background-color":"#f9f9f9","border-bottom-color":"#eef1f2"});
	});
</script>
