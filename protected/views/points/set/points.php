<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>css/set/set.css">
<div class="set">    
	<div class="settype">
		<div class="settitle">积分分配</div>
		<div id="setheight" class="settype_main settype_new_main">
                    <form method="post" id="frm_submit" action="">
			<div class="settype_table">		    
				<div class="settype_new">
                                    <div class="settype_newbox">                                        
                                        <ul class="clearfix">
                                                <li>
                                                    <label class="fl">评判标准</label>
                                                    <label class="fl"><?php echo $row['name']?></label>                                                
                                                </li>
                                                <li>
                                                    <label class="fl">评选日期</label>
                                                    <input type="text" value="<?php echo !empty($date) ? $date : date('Y-m-d',time());?>"  
                                                           name="date" style="width:100px;" class="Wdate" readonly="readonly" id="date" onfocus="WdatePicker({skin:'whyGreen'})" /> 
                                                </li>
                                                <li>
                                                    <label class="fl">评选积分</label>    
                                                    <input type="text" id="score" value ="<?php echo $score;?>" /> 
                                                </li>
                                                <li>
                                                    <label class="fl">评选周期</label>    
                                                    <select name="s_type" id="s_type">
                                                        <?php foreach ($cycleArr as $cycleArrKey => $cycleArrVal):?>
                                                            <?php if($cycleArrKey == $cycle):?>
                                                                <option selected="selected" value="<?php echo $cycleArrKey?>"><?php echo $cycleArrVal?></option>
                                                            <?php else :?>
                                                                <option value="<?php echo $cycleArrKey?>"><?php echo $cycleArrVal?></option>
                                                            <?php endif;?>                                                            
                                                        <?php endforeach;?>                                                                                                             
                                                    </select>
                                                </li>
                                                <li style="height:auto;">
                                                    <label class="fl">评选成员</label>
                                                    <a class="people_open" style="background: url(<?php echo Yii::app()->baseUrl?>/protected/assets/images/set_ico7.png) no-repeat scroll 0 0 rgba(0, 0, 0, 0); cursor: pointer; display: inline;float: left; height: 20px;margin: 8px 10px 3px 0;width: 21px;" href="javascript:;" onclick="javascript:showPersonDiv();"></a>
                                                    <div class="fl" style="width:700px;">
                                                        <label id ="personinfo" name="personinfo">
                                                            <?php if (!empty($data)):
                                                                foreach($data as  $dataVal):
                                                                ?>
                                                                    <label id="<?php echo $dataVal['uid'];?>"><?php echo $dataVal['uname'];?> </label>
                                                            <?php endforeach;
                                                            endif;?>
                                                        </label>
                                                    </div>                                                    
                                                </li>                                                
                                        </ul>                                        
                                    </div>
				</div>
				<div class="settype_button">
                    <a href="javascript:;" id="fsave">保存</a>
                    <a href="<?php echo $this->createUrl('/points/set/info',array('id'=>$pid))?>">返回</a>
                </div>
			</div>
                    </form>
		</div>
	</div>
    
    
                <div id="div_person" class="aut_adddiv"><!--人力资源 开始-->
                	<div class="aut_ddiv_nav aut_people"><!--人力资源上部分 开始-->
                    	<h4>易班</h4>
                        <ul class="set_tree">
                             <?php foreach($deptArr as $deptArrKey =>$deptArrVal):?>
                                        <li><span onclick="javascript:get_dept_info('<?php echo $deptArrKey;?>')"><?php echo $deptArrVal?></span></li>
                             <?php endforeach;?>
                        </ul>

                    </div><!--人力资源上部分 结束-->
                    <div class="atu_pbox">
                    	<div class="atu_pboxtit">已选择 <span id="choose_number">0</span> 人</div>
                        <div class="atu_pbbox">
                        	<div class="atu_pbbox_box fl"><!--左边选择框 开始-->
                            	<ul class="clearfix" id="ul_deptinfo">

                                </ul>
                            </div><!--左边选择框 结束-->
                            <div class="atu_pbbox_box fr"><!--右边选择框 结束-->
                            	<ul id="ul_add_deptinfo">

                                </ul>
                            </div><!--右边选择框 结束-->
                        </div>
                    </div>
                    <div class="aut_add_btn"><a id="btn_deptinfo">确定</a><a id="deptinfo_cls">清除</a><a class="aut_close">取消</a></div>
                </div><!--人力资源 结束-->
</div>



<script type="text/javascript" src="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>js/set/set.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript">
    var ajaxurl = '<?php echo $this->createUrl('/points/set/ajax');?>';
    var ajaxgetpurl = '<?php echo $this->createUrl('/ajax/apiajax/ajax/');?>';
    
//自适应高度
function heightChange(){
	var setHeight = document.getElementById("setheight");
	var bodyHeight = document.documentElement.clientHeight - 9 - 32 - 15;   //9代表的是上外边距，32是标题栏的高度，15是距离浏览器下部分的距离
	setHeight.style.height = bodyHeight + "px";
}
window.onload = heightChange();

var reg = /[^/0-9.]/g;  //只能输入字母正则
$("#score").keyup(function(){
    $(this).val($(this).val().replace(reg,''));
}).bind("paste",function(){  //CTR+V事件处理
    $(this).val($(this).val().replace(reg,''));
});


//人力资源弹出层JS START
function showPersonDiv(){
    $("#div_person").show();
    $("#div_person").css({
            left:($(window).width() - $(".aut_adddiv").width())/2,
            top:100+"px"
      });   
}

function get_dept_info(deptid){
    $.ajax({
        type:'post',
        url:ajaxgetpurl,
        data:{type:"getdeptinfo",deptid:deptid},
        dataType:"json",
        async:false,
        success:function(data){
            $('#ul_deptinfo').html(data['info']);
        }
    });
}

function addemployee(obj){
    if ($('#ul_add_deptinfo #' + $(obj).attr('id')).length > 0) {
        return false;
    }
    var html = $(obj).parent().clone();
    $(html).attr('ondblclick', 'removeemployee(this)');
    $('#choose_number').text(parseInt($('#choose_number').text())+1);
    $('#ul_add_deptinfo').append(html);
}

function removeemployee(obj){
    $(obj).remove();
    if (parseInt($('#choose_number').text()) > 0){
        $('#choose_number').text(parseInt($('#choose_number').text())-1);
    }
}

$('#deptinfo_cls').click(function(){
    $('#choose_number').text(0);
    $('#ul_add_deptinfo').html('');
});

$('#btn_deptinfo').click(function(){
    var deptinfostr = '';
   $("#ul_add_deptinfo li").each(function(){
       deptinfostr += '<label id="'+$(this).find('span').data('id')+'">'+ $(this).text() + '</label>&nbsp;&nbsp;&nbsp;';
   });
   
   $('#personinfo').html(deptinfostr);   
   $('#div_person').hide();   
});
//人力资源弹出层JS END


$('#fsave').click(function(){
    var ch_bool = true;
    if ('' == $('#date').val()){
        alert('日期不能为空');
        ch_bool = false;
    }
    
    var ids = new Array();       
    var test = new Array(); 
    $('#personinfo label').each(function(){
        ids.push([ $(this).attr('id'),
            $(this).html() ]);
    });
    
    if (ids.length == 0 ){
        alert('评选成员不能为空');
        ch_bool = false;
        return false;
    }
    
    if ('' == $('#score').val()){
        alert('评选积分不能为空');
        ch_bool = false;
    }
    
    if (ch_bool && ids.length > 0 ){
        $.ajax({
           type : "post",
           url : ajaxurl,
           data:{type:"add_data",date:$('#date').val(),pid:<?php echo $row['id']?>,cycle:$('#s_type').val(),ids:ids,score:$('#score').val()},
           dataType:"json",
           async:false,
           success:function(data){
               if (data.code == "success"){
                   location.href = '<?php echo Yii::app()->createUrl('/points/set/info',array('id'=>$pid))?>';
               }else{
                   alert(data.mes);
               }
           }
        });
    }

    
});

</script>