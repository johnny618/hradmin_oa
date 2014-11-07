<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>css/set/set.css">
<div class="set">
    <div class="settype"><!--流程类型 开始-->
             <div class="settitle">信息导出</div>
             <div id="setheight" class="settype_main tabfd" style="position: relative; width: 100%;">
                 <form method="post" id="frm_submit">                    
                    
                    <div class="tabfd_title">
                        <label class="fl" style="width: 20%;font-size: 15px;">导出类型</label>
                        <select class="fl" name="s_type" id="s_type">
                            <option value="0"></option>
                            <option value="1">按月积分</option>
                            <option value="2">按年积分</option>
                            <option value="3">累计积分</option>
                        </select>
                        
                        <div class="fl" style="display: none;" id="t_month" >
                        <label style="width: 5%;font-size: 18px;">日期</label>
                        <input type="text" value="<?php echo date('Y-m',time());?>"                                 
                            name="m_date" style="width:100px;" class="Wdate" readonly="readonly" id="m_date" onfocus="WdatePicker({skin:'whyGreen',dateFmt:'yyyy-MM'})" />                             
                       </div>
                        
                        <div class="fl" style="display: none;" id="t_year">
                        <label style="width: 5%;font-size: 18px;">日期</label>
                        <input type="text" value="<?php echo date('Y',time());?>"                                 
                            name="y_date" style="width:100px;" class="Wdate" readonly="readonly" id="y_date" onfocus="WdatePicker({skin:'whyGreen',dateFmt:'yyyy'})" />                             
                       </div>
                            <input type="button" id="fsave" value="导出"/>
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

$('#s_type').change(function(){
    hiddenDiv();
    if ($('#s_type').val() == 1){
        $('#t_month').show();
    }else if($('#s_type').val() == 2){
        $('#t_year').show();
    } 
});

$('#fsave').click(function(){
    if ($('#s_type').val() != 0){
        if ($('#s_type').val() == 1){
            if ('' == $('#m_date').val()){
                alert("日期不能为空");
            }else{
                $('#frm_submit').submit();
            }
        }else if($('#s_type').val() == 2){
            if ('' == $('#y_date').val()){
                alert("日期不能为空");
            }else{
                $('#frm_submit').submit();
            }
            
        }else{
            $('#frm_submit').submit();
        }
        
    }else{
        alert('请选择导出类型');
    }
});

function hiddenDiv(){
    $('#t_month').hide();
    $('#t_year').hide();
}
</script>
