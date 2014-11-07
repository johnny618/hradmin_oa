<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>css/set/set.css">
<div class="set">
	<div class="settype">
		<div class="settitle">新建：模块信息</div>
		<div id="setheight" class="settype_main settype_new_main">
			<div class="settype_table">
                            <form action="" method="post" id="frm_submit">
				<div class="settype_new">
					<div class="settype_newbox">
						<h4>基本信息</h4>
							<ul class="clearfix">
								<li>
                                                                    <label class="fl">添加类型</label>                                                                    
                                                                    <select id="sel_type" name="sel_type" >                                                                            
                                                                            <option value="0">大类</option>
                                                                            <option value="1">子类</option>
                                                                    </select> 
                                                                    <select id="sel_pclass" name="sel_pclass" hidden="hidden" >                                                                            
                                                                            <option value=""></option>
                                                                            <?php foreach($pitem as $pitemVal):?>
                                                                            <option value="<?php echo $pitemVal['id']?>"><?php echo $pitemVal['name']?></option>
                                                                            <?php endforeach;?>
                                                                    </select> 
                                                                    
								</li>	
                                                                <li>
                                                                    <label class="fl">名&nbsp;&nbsp;&nbsp;&nbsp;称</label>                                                                    
                                                                    <input type="text" style="width: 800px;" id="tname" name="tname" class="fl" />     
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

$('#sel_type').change(function(){
    if ($('#sel_type').val() == 1){        
        $('#sel_pclass').show();
    }else{
        $('#sel_pclass').hide();
    }    
});

$('#tname').keydown(function(){
    if ('' == $('#tname').val()){
        $('#sname').html('');
    }
});

var ajaxurl = '<?php echo Yii::app()->createUrl('/points/model/ajax')?>';
function fsave(){
    var ch_bool = true;
    
    if ($('#sel_type').val() == 1){
        if ('' == $('#sel_pclass').val()){
            ch_bool = false;
            alert('请选择大类!');
        }        
    }
    
    if ('' == $('#tname').val()){
            ch_bool = false;
            $('#sname').html('请输入名称');
            return false;
    }
    
    $.ajax({
        type:"post",
        url:ajaxurl,
        data:{type:"check_name",name:$('#tname').val()},
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