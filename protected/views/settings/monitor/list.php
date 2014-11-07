<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>css/set/set.css">
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>css/pagestyle.css">
<style>
	body{ background-color: #fff;}
</style>
<div class="process">
<!-- 流程代理设置start -->
<h3 class="title">流程监控</h3>
<div class="pro-content">
    <form method="post">
        <table class="agent_set_table">
                <thead>
                        <tr>
                                <th>类型</th>
                                <td><a href="javascript:;" onclick="javascript:showTypeDiv();" class="fl"><label for="" style="cursor:pointer" class="lbl-type"></label></a>
                                    <input type="text" readonly="readonly"  id="typename"  name="typename" value="<?php echo $params['typename'];?>" />
                                    &nbsp;<a id="type_cls" style="cursor:pointer">清除</a>
                                    <input type="hidden" id="typeid"  name="typeid" value="<?php echo $params['typeid'];?>" />
                                </td>
                                <th>节点类型</th>
                                <td>
                                    <select name="nodetype">
                                        <?php if ($params['nodetype'] !== ''):?>
                                            <option value=""></option>
                                            <?php foreach(MyConst::$nodeType as $nodeTypeKey => $nodeTypeVal):?>
                                                <?php if (isset($params['nodetype']) && $nodeTypeKey == $params['nodetype']): ?>
                                                    <option selected="selected" value="<?php echo $nodeTypeKey;?>"><?php echo $nodeTypeVal;?></option>
                                                <?php else:?>\
                                                    <option value="<?php echo $nodeTypeKey;?>"><?php echo $nodeTypeVal;?></option>
                                                <?php endif;?>
                                            <?php endforeach;?>
                                        <?php else: ?>
                                            <option value=""></option>
                                            <?php foreach(MyConst::$nodeType as $nodeTypeKey => $nodeTypeVal):?>
                                                <option value="<?php echo $nodeTypeKey;?>"><?php echo $nodeTypeVal;?></option>
                                            <?php endforeach;?>
                                        <?php endif;?>

                                    </select>
                                </td>
                                <th>请求标题</th>
                                <td><input type="text" name="r_title" value="<?php echo $params['r_title'];?>" /></td>
                        </tr>
                </thead>
                <tbody>
                        <tr>
                                <th>日期</th>
                                <td><input type="text" value="<?php echo $params['startTime'];?>"
                                       onclick="WdatePicker({dateFmt:'yyyy-MM-dd'})" name="startTime" style="width:100px;"
                                       class="Wdate" readonly="readonly" id="startTime"/>
                                    -
                                    <input type="text" value="<?php echo $params['endTime'];?>" onclick="WdatePicker({dateFmt:'yyyy-MM-dd'})"
                                       name="endTime" style="width:100px;" class="Wdate" readonly="readonly" id="endTime" />
                                </td>
                                <th>创建人</th>
                                <td><a href="javascript:;" onclick="javascript:showPersonDiv();" class="fl"><label for="" style="cursor:pointer" class="lbl-type"></label></a>
                                    <input type="text" readonly="readonly"  id="creater"  name="creater" value="<?php echo $params['creater'];?>" />
                                    &nbsp;<a id="cls" style="cursor:pointer">清除</a>
                                    <input type="hidden" id="createrid"  name="createrid" value="<?php echo $params['createrid'];?>" />
                                </td>
                                <th></th>
                                <td><input type="submit" value="搜索"></td>
                        </tr>
                </tbody>
        </table>
    </form>
        <table class="agentTable">
<!--                <caption><strong>其他操作人代理状况</strong></caption>-->
                <thead>
                        <tr>
                                <th><p>请求标题</p></th>
                                <th><p>工作流</p></th>
                                <th><p>创建人</p></th>
                                <th><p>创建时间</p></th>
                                <th><p>当前节点</p></th>
                                <th><p>未操作者</p></th>
                                <th><p>当前状态</p></th>
                        </tr>
                        <tbody>
                            <?php foreach($rows as $value):?>
                                <tr>
                                    <td><a href="<?php echo $this->createUrl('/request/show/' . $value['id']);?>" target="_blank"><?php echo $value['title'];?></a></td>
                                    <td><?php echo $value['workname'];?></td>
                                    <td><?php echo $value['uname'];?></td>
                                    <td><?php echo date('Y-m-d H:i:s',$value['created']);?></td>
                                    <td><?php echo $value['nodename'];?></td>
                                    <td><?php echo $value['operater'];?></td>
                                    <td><?php echo MyConst::$nodeType[$value['status']];?></td>
                                </tr>
                            <?php endforeach;?>
                        </tbody>
                </thead>
        </table>
    <div class="clearfix"></div>    
        <?php echo MyTool::page_show('/settings/monitor/index/',$page,$params);?>    
    <div class="clearfix"></div>
    
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

<div class="aut_adddiv" id="type_div"><!--类型弹出层 开始-->
    <div class="div_note_tab" name="leixing">
        <?php foreach($typedata as $typedataKey => $typedataVal){?>
            <h4><?php echo $typedataVal['name']?></h4>
            <ul class="set_tree">
            <?php if(!empty($typedataVal['child'])){?>
                    <?php foreach($typedataVal['child'] as $childKey => $childVal){?>
                        <li>
                            <span id="<?php echo $childVal['id']?>" ondblclick="javascript:addnodetype(this)" style="cursor:pointer"><?php echo $childVal['name']?></span>
                        </li>
                    <?php }?>
            <?php }?>
            </ul>
        <?php }?>

    </div>
    <div class="aut_add_btn"><a class="aut_close">取消</a></div>
</div><!--类型弹出层 结束 -->
<script>
$("[name=leixing] h4").each(function(index){
    $(this).toggle(function () {
        $(this).addClass("active");
        $(this).siblings(".set_tree").eq(index).show();
      },
      function () {
        $(this).removeClass("active");
        $(this).siblings(".set_tree").eq(index).hide();
      });
});
</script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>js/set/set.js"></script>
<script type="text/javascript">
var ajaxurl = '<?php echo $this->createUrl('/settings/formnode/ajax/');?>';

function showPersonDiv(){    
    $("#person_div").show();
    $("#person_div").css({
            left:($(window).width() - $("#person_div").width())/2,
            top:100+"px"
      });
}

function showTypeDiv(){    
    $("#type_div").show();
    $("#type_div").css({
            left:($(window).width() - $("#type_div").width())/2,
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

function addnodetype(obj){
    $('#typename').val($(obj).html());
    $('#typeid').val($(obj).attr('id'));
    close_aut_div();
}

$('#cls').click(function(){
    $('#creater').val('');
    $('#createrid').val('');
    close_aut_div();
});

$('#type_cls').click(function(){
    $('#typename').val('');
    $('#typeid').val('');
    close_aut_div();
});

//页面弹层关闭方法
function close_aut_div(){
    $(".aut_adddiv").css('top','50%');
    $(".aut_adddiv").hide();
    //$(".aut_div").hide();
}

</script>