<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>css/set/set.css">
<style>
	body{ background-color: #fff;}
	.aut_adddiv{top:0px;}
</style>
<div class="process">
	<h3 class="title">文档权限管理</h3>
	<div class="pro-content">
	<form method="post">	    
		<table class="renli">
			<tbody>
                            <?php foreach ($tidArr as $val):?>
                                <tr>
                                    <th width="50%"><a href="<?php echo Yii::app()->createUrl('/document/create/add',array('tid'=>$val))?>"><?php echo Bll_Document::$doc_title[$val]?></a></th>				
                                </tr>
                            <?php endforeach;?>
			</tbody>
		</table>
	</form>
	</div>
	<div class="aut_adddiv"><!--人力资源 开始-->    
</div><!--人力资源 结束-->
</div>
