<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>css/set/set.css">
<div class="set">
    <div class="settype"><!--流程类型 开始-->
        <div class="settitle">个人资产&nbsp;&nbsp;&nbsp;{&nbsp;<?php echo $uname;?>&nbsp;}</div>
             <div id="setheight" class="settype_main tabfd" style="position: relative; width: 100%;">
                 <form method="post">
                     <?php if ($author):?>
                     <table class="agent_set_table">                
                            <thead>
                                    <tr>
                                            <th>选择成员</th>
                                            <td><a href="javascript:;" onclick="javascript:showPersonDiv();" class="fl" style="margin:2px 0 0 5px;"><label for="" style="cursor:pointer" class="lbl-type"></label></a>
                                <input type="text" readonly="readonly"  id="creater"  name="creater" value="<?php echo $uname;?>"  class="fl" />
                                <a id="cls" style="cursor:pointer; margin-left: 5px;">清除</a>
                                <input type="hidden" id="createrid"  name="createrid" value="<?php echo $uid;?>" /></td>
                                                                           
                                            <td><input type="submit" value="查询"></td>
                                    </tr>
                            </thead>
                    </table>
                    <?php endif;?>
                   
                </form> 
            	
                    
                    <table class="agentTable">                        
                        <thead>
                            <tr>
                                <?php foreach ($tabletitle as $val):?>
                                    <th><p><?php echo $val?></p></th>  
                                <?php endforeach;?>
                            </tr>                                
                            <tbody>
                                <?php foreach($data as $dataVal):?>
                                <tr>
                                    <?php foreach ($tabletitle as $key => $val):?>
                                        <td><?php echo $dataVal[$key];?></td>                                         
                                    <?php endforeach;?>
                                </tr>
                                <?php endforeach;?>
                            </tbody>
                        </thead>
                    </table>
                    <div >
                        <p style="margin-left: 20px;">备注：如对个人资产内容有异议，请拨打10085联系运维部进行确认更新。</p>
                    </div>	
                
            </div><!--流程类型 结束-->
    </div>
    
    
    <div class="aut_adddiv" id="person_div"><!--人力资源 开始-->
        <div class="aut_ddiv_nav aut_people"><!--人力资源上部分 开始-->
            <h4>易班</h4>
            <ul class="set_tree">
                 <?php foreach($deptArr as $deptArrKey =>$deptArrVal):?>
                            <li><span onclick="javascript:get_dept_info('<?php echo $deptArrKey;?>')"><?php echo $deptArrVal?></span></li>
                 <?php endforeach;?>
            </ul>

        </div><!--人力资源上部分 结束-->
        <div class="atu_pbox">
            <div class="atu_pbbox">
                <div class="atu_pbbox_box fl" style="width:420px;"><!--左边选择框 开始-->
                    <ul class="clearfix" id="ul_deptinfo">

                    </ul>
                </div><!--左边选择框 结束-->
            </div>
        </div>
        <div class="aut_add_btn"><a class="aut_close">取消</a></div>
    </div><!--人力资源 结束-->
    
</div>


<script type="text/javascript" src="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>js/set/set.js"></script>
<script type="text/javascript">
//自适应高度
function heightChange(){
	var setHeight = document.getElementById("setheight");
	var bodyHeight = document.documentElement.clientHeight - 9 - 32 - 15;   //9代表的是上外边距，32是标题栏的高度，15是距离浏览器下部分的距离
	setHeight.style.minHeight = bodyHeight + "px";
}
window.onload = heightChange();
window.onresize = heightChange;

var ajaxurl = '<?php echo $this->createUrl('/ajax/apiajax/ajax/');?>';

function showPersonDiv(){    
    $("#person_div").show();
    $("#person_div").css({
            left:($(window).width() - $("#person_div").width())/2,
            top:100+"px"
      });
}

//人力资源弹出层JS START
function get_dept_info(deptid){
    $.ajax({
        type:'post',
        url:ajaxurl,
        data:{type:"getdeptinfo",deptid:deptid},
        dataType:"json",
        async:false,
        success:function(data){
            $('#ul_deptinfo').html(data['info']);
        }
    });
}
//人力资源弹出层JS END


function addemployee(obj){
    if ($('#ul_add_deptinfo #' + $(obj).attr('id')).length > 0) {
        return false;
    }
    $('#creater').val($(obj).html());
    $('#createrid').val($(obj).data('id'));
    close_aut_div();
}

//页面弹层关闭方法
function close_aut_div(){
    $(".aut_adddiv").css('top','50%');
    $(".aut_adddiv").hide();
    //$(".aut_div").hide();
}

$('#cls').click(function(){
    $('#creater').val('');
    $('#createrid').val('');
    close_aut_div();
});
</script>
