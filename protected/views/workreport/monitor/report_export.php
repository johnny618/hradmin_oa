<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>css/set/set.css">
<div class="set">
    <div class="settype"><!--流程类型 开始-->
             <div class="settitle">信息导出</div>
             <div id="setheight" class="settype_main tabfd" style="position: relative; width: 100%;">
                 <form method="post" id="frm_submit">                    
                    
                    <div class="tabfd_title">
                        <label class="fl" style="width: 20%;font-size: 18px;">日期</label>
                        <input type="text" value=""                                 
                            name="sdate" style="width:100px;" class="Wdate" readonly="readonly" id="sdate" onfocus="WdatePicker({skin:'whyGreen'})" /> 
                        <input type="text" value="<?php echo date('Y-m-d',time());?>"                                 
                            name="edate" style="width:100px;" class="Wdate" readonly="readonly" id="edate" onfocus="WdatePicker({skin:'whyGreen'})" /> 
                        <input type="button" id="fsave" value="查询"/>
                    </div>            	
                </form>
                
            </div><!--流程类型 结束-->
    </div>
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

$('#fsave').click(function(){
    if ('' != $('#sdate').val() && '' != $('#edate').val()){
        $('#frm_submit').submit();
    }else{
        alert('时间不能为空');
    }
});
</script>
