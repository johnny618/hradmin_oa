<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>css/set/set.css">
<div id="roadheight" class="set">
<div id="road_right" class="road_right"><!--右侧工作流 开始-->
        <div class="node_tab"><!--节点tab菜单 开始-->
                <ul class="clearfix">
                <li><a href="<?php echo Yii::app()->createUrl('/settings/formnode/index/' . $id)?>">节点信息</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('/settings/process/index/' . $id)?>">出口信息</a></li>
                <li class="node_tabborder"><a href="<?php echo Yii::app()->createUrl('/settings/formview/index/' , array('fid'=>$id))?>">图形编辑</a></li>
            </ul>
        </div><!--节点tab菜单 结束-->
        <div class="node_table"><!--节点表格 开始-->
               <?php echo $html;?>
        </div><!--节点表格 结束-->
    </div><!--右侧工作流结束-->
 </div>

