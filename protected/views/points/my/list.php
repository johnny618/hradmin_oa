<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>css/set/set.css">
<div class="set">
    <div class="settype"><!--流程类型 开始-->
             <div class="settitle">个人展示</div>
             <div id="setheight" class="settype_main tabfd" style="position: relative; width: 100%;">
                 <form method="post">
                    <div class="" style="position: absolute;top:0px; left: 20px;">
                        <div class="fl">
                            <label>选择日期 </label> 
                            <input type="text" value="<?php echo !empty($date) ? $date : date('Y-m',time());?>"                                 
                            name="date" style="width:100px;" class="Wdate" readonly="readonly" id="date" onfocus="WdatePicker({skin:'whyGreen',dateFmt:'yyyy-MM'})" /> 
                        </div>
                        

                            <div class="fl" style="margin-left: 10px;">
                                <?php if ($author):?>
                                <label class="fl">选择成员</label> 
                                <a href="javascript:;" onclick="javascript:showPersonDiv();" class="fl" style="margin:2px 0 0 5px;"><label for="" style="cursor:pointer" class="lbl-type"></label></a>
                                <input type="text" readonly="readonly"  id="creater"  name="creater" value="<?php echo $uname;?>"  class="fl" />
                                <a id="cls" style="cursor:pointer; margin-left: 5px;">清除</a>
                                <input type="hidden" id="createrid"  name="createrid" value="<?php echo $uid;?>" />
                                <?php endif;?>
                                <input type="submit" value="查询"/>
                            </div>

                    </div>
                    <div style="text-align: center; margin-top: 20px; font-size: 14px; font-weight: bold;">现有分值</div>
                    <div class="tabfd_title">
                        <label class="fl" style="color:black;width: 20%;font-size: 18px;font-weight: bold;"><?php echo $uname?></label>
                        <label class="fl" style="color: red;width: 10%;font-size: 18px;font-weight: bold;"><?php echo $sumscore?>&nbsp;分</label>
                        <label class="fl" style="color: #86caff;width: 10%;font-size: 18px;font-weight: bold;"><?php echo Bll_YBR::get_star_lv($sumscore)?></label>
                    </div>
            	<table class="agentTable">
                        <caption><strong style="text-align: center; margin-top: 20px; font-size: 14px; font-weight: bold;">积分变化趋势</strong></caption>
                        <thead>
                            <tr>
                                <th><p>上月获得分值</p></th>
                                <th><p>原有星级</p></th>
                                <th><p>当月获得分值</p></th>
                                <th><p>现有星级</p></th>   
                                <th><p>由上月至当月变化趋势</p></th>
                                <th><p>变化幅度</p></th>
                            </tr>                                
                            <tbody>
                                <tr>
                                    <td><?php echo $oldscore?>&nbsp;分</td>
                                    <td><?php echo Bll_YBR::get_star_lv($sumscore-$oldscore)?></td>
                                    <td><?php echo $score?>&nbsp;分</td>
                                    <td><?php echo Bll_YBR::get_star_lv($sumscore)?></td>
                                    <td><?php echo Bll_YBR::get_status_of_score($score,$oldscore)?></td>
                                    <td><?php echo $score-$oldscore?>&nbsp;分</td>
                                </tr>
                            </tbody>
                        </thead>
                </table>
                    
                    <table class="agentTable">
                        <caption><strong style="text-align: center; margin-top: 20px; font-size: 14px; font-weight: bold;">加分明细</strong></caption>
                        <thead>
                            <tr>
                                <th><p>加分项目</p></th>                                
                                <th><p>加分日期</p></th>
                                <th><p>加分值</p></th>
                            </tr>                                
                            <tbody>
                                <?php foreach($data as $dataVal):?>
                                <tr>
                                    <td><?php echo $items[$dataVal['pid']];?></td>
                                    <td><?php echo Bll_YBR::init_date_by_cycle($dataVal['date'],$dataVal['cycle']);?></td>
                                    <td><?php echo $dataVal['score'];?>&nbsp;分</td>
                                </tr>
                                <?php endforeach;?>
                            </tbody>
                        </thead>
                </table>
                </form>
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
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>js/My97DatePicker/WdatePicker.js"></script>
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
