<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>css/set/set.css">
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>css/set/set.css">
<div class="set">
	<div class="settype">
		<div class="settitle">修改模块</div>
		<div id="setheight" class="settype_main settype_new_main">
			<div class="settype_table">
                            <form action="" method="post" id="frm_submit">
				<div class="settype_new">
					<div class="settype_newbox">
						<h4>基本信息</h4>
							<ul class="clearfix">								
                                                                <li>
                                                                    <label class="fl">名&nbsp;&nbsp;&nbsp;&nbsp;称</label>                                                                    
                                                                    <input type="text" style="width: 800px;" id="tname" name="tname" value="<?php echo $data['name']?>" class="fl" />                                                                         
                                                                    <span id="sname"></span>                                                                    
								</li>	
							</ul>
					</div>
				</div>
                            </form>
				<div class="settype_button">
                                    <a href="javascript:;" onclick="javascript:fsave();">保存</a>                                    
                                    <a href="<?php echo $this->createUrl('/points/model/index')?>">返回</a>
                                </div>
		   
			</div>
		</div>
	</div>
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


var ajaxurl = '<?php echo Yii::app()->createUrl('/points/model/ajax')?>';
function fsave(){
    var ch_bool = true;

    if ('' == $('#tname').val()){
            ch_bool = false;
            $('#sname').html('请输入名称');
            return false;
    }
    
    $.ajax({
        type:"post",
        url:ajaxurl,
        data:{type:"modify_check_name",name:$('#tname').val(),cid:<?php echo $data['id']?>},
        dataType:"json",
        async:false,
        success:function(data){
            if (data.code == "error"){
                alert('名称已存在!');                
                ch_bool = false;
            }
        }
    });
    if (ch_bool){
        $('#frm_submit').submit();
    }
}
</script>