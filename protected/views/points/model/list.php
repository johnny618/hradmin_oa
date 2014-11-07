<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>css/set/set.css">
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>css/pagestyle.css">
<div class="set">
	 <div class="settype"><!--流程类型 开始-->
		<div class="settitle">模块信息</div>
		<div id="setheight" class="settype_main">
			<div class="settype_newbtn"><a href="<?php echo $this->createUrl('/points/model/add')?>">新建</a></div>
			<div class="settype_table">
				<table width="100%" cellpadding="0" cellspacing="0">
					<tr>
						<th width="70%"><div class="settype_margin"><p>名称</p></div></th>						
						<th width="30%"><p class="settype_p">操作</p></th>
					</tr>
                                        <?php foreach ($rows as $rowsVal) {?>
                                                <tr>
                                                    <td ><div class="settype_margin">
                                                            <span><?php echo $rowsVal['name'];?></span>
                                                        </div></td>
                                                        <td >
                                                            <a href="<?php echo Yii::app()->createUrl('/points/model/modify',array('id'=>$rowsVal['id']))?>">修改</a>
                                                            <a href="#" onclick="javascript:del_row('<?php echo $rowsVal['id']?>')">刪除</a>
                                                        </td>
                                                </tr>
                                        <?php }?>
				</table>
                            <div class="clearfix"></div>    
                                <?php echo MyTool::page_show('/points/model/index/',$page);?>    
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


    function del_row(id){
        var ajaxurl = "<?php echo $this->createUrl('/points/model/ajax');?>";
        if(confirm('确定删除该条数据吗 ? ')){
            $.ajax({
                type : "post",
                url : ajaxurl,
                data : {type:"delete_data",id:id},
                dataType : "json",
                async : false,
                success : function(data){
                    if (data.code == "success"){
                        location=location;
                    }else{
                        alert(data.mes);
                    }
                }
            });
        }
    }
</script>