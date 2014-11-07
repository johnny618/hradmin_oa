<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>css/pagestyle.css">
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>css/set/set.css">
<style>
	body{ background-color: #fff;}
</style>
<div class="process">
<!-- 流程代理设置start -->
<h3 class="title">工作小结监控</h3>
<div class="pro-content">
    <form method="post">
        <table class="agent_set_table">
                <thead>
                        <tr>
                                <th>日期</th>
                                <td><input type="text" value="<?php echo $params['startTime']?>"  name="startTime" style="width:100px;" class="Wdate" readonly="readonly" id="startTime"
                                                           onfocus="WdatePicker({skin:'whyGreen',maxDate:'%y-%M-%d'})" />   
                                    -
                                    <input type="text" value="<?php echo $params['endTime']?>" onfocus="WdatePicker({skin:'whyGreen',maxDate:'%y-%M-%d'})"
                                       name="endTime" style="width:100px;" class="Wdate" readonly="readonly" id="endTime" />
                                </td>
                                <th>创建人</th>
                                <td><a href="javascript:;" onclick="javascript:showPersonDiv();" class="fl"><label  style="cursor:pointer" class="lbl-type"></label></a>
                                    <input type="text" readonly="readonly"  id="creater"  name="creater" value="<?php echo $params['creater']?>" />
                                    &nbsp;<a id="cls" style="cursor:pointer">清除</a>
                                    <input type="hidden" id="createrid"  name="createrid" value="<?php echo $params['createrid']?>" />
                                </td>
                                <th>是否迟交</th>
                                <td>
                                    <select name="late" style="width:40px">
                                        <option value=""></option>
                                        <?php foreach(MyConst::$_YesNo as $_key => $_Val):?>
                                            <?php if($params['late'] == $_key){?>
                                        <option selected="selected" value="<?php echo $_key?>"><?php echo $_Val?></option>
                                            <?php }else{?>
                                            <option value="<?php echo $_key?>"><?php echo $_Val?></option>
                                            <?php }?>
                                        <?php endforeach;?>                                        
                                    </select>
                                </td>
                                <td><input type="submit" value="搜索"></td>
                        </tr>
                </thead>                
        </table>
    </form>    
    
    
        <table class="agentTable">
                <thead>
                        <tr>
                                <th><p>小结日期</p></th>                                
                                <th><p>日历</p></th>
                                <th><p>创建人</p></th>
                                <th><p>创建时间</p></th>                                
                                <th><p>最后更新时间</p></th>   
                                <th><p>是否迟交</p></th>                                
                        </tr>
                        <tbody>
                            <?php foreach($rows as $value):?>
                                <tr>
                                    <td>
                                        <a onclick="javascript:showtip('<?php echo addslashes($value['report'])?>','<?php echo date("Y-m-d",$value["reportTime"]);?>')" href="#"><?php echo date('Y-m-d',$value['reportTime']);?></a>
                                    </td>
                                    <td><?php echo MyConst::$_WeekArr[date('w',$value['reportTime'])];?><input type="hidden" value="<?php echo $value['id']?>"></td>
                                    <td><?php echo $value['uname'];?></td>
                                    <td><?php echo date('Y-m-d H:i:s',$value['created']);?></td>
                                    <td><?php echo $value['updated'];?></td>                                   
                                    <td><?php echo empty($value['late']) ? '否' : '是' ;?></td>                                    
                                </tr>
                            <?php endforeach;?>
                        </tbody>
                </thead>
        </table>
        
    <div class="clearfix"></div>    
        <?php echo MyTool::page_show('/workreport/monitor/index/',$page,$params);?>    
    <div class="clearfix"></div>
    <div hidden="hidden" id="report" style="width:98%;margin:10px auto; height:400px; overflow-y: auto; "></div>
</div>
<!-- 流程代理设置end -->

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

<script type="text/javascript" src="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>js/set/set.js"></script>
<script type="text/javascript">
    
    function showtip(report,reporttime){
       $('#report').show();
       $('#report').html(reporttime+"<br/>"+report);
    }
    
    var ajaxurl = '<?php echo $this->createUrl('/ajax/apiajax/ajax/');?>';

function showPersonDiv(){
    $("#person_div").show();
    $("#person_div").css({
            left:($(window).width() - $("#person_div").width())/2,
            top:100+"px"
      });
}

$('.aut_close').click(function(){
    close_aut_div();
});

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

$('#cls').click(function(){
    $('#creater').val('');
    $('#createrid').val('');
    close_aut_div();
});

//页面弹层关闭方法
function close_aut_div(){
    $(".aut_adddiv").css('top','50%');
    $(".aut_adddiv").hide();
    //$(".aut_div").hide();
}
</script>    