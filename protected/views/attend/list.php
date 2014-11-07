<style>
	body{ background-color: #fff;}
</style>
<div class="process">
    <h3 class="title">考&nbsp;&nbsp;勤</h3>
    <div class="pro-content">
        <form method="post">
            <table class="agent_set_table">
                    <tbody>
                            <tr>
                                    <th>日期</th>
                                    <td><input type="text" value=""
                                           onclick="WdatePicker({dateFmt:'yyyy-MM-dd'})" name="startTime" style="width:100px;"
                                           class="Wdate" readonly="readonly" id="startTime"/>
                                        -
                                        <input type="text" value="" onclick="WdatePicker({dateFmt:'yyyy-MM-dd'})"
                                           name="endTime" style="width:100px;" class="Wdate" readonly="readonly" id="endTime" />
                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="button" id="btn_e" onclick="javascript:exportExcel();" value="导 出">
                                    </td>

                            </tr>
                    </tbody>
            </table>
        </form>        
    </div>
</div>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>js/My97DatePicker/WdatePicker.js" ></script>
<script type="text/javascript">
    var ajaxurl = '<?php echo $this->createUrl('/attend/ajax/');?>';
    function exportExcel(){        
        if ('' != $('#startTime').val() && '' != $('#endTime').val()){
            //$('#btn_e').attr('disabled','disabled');
            $.ajax({
                type:'post',
                url:ajaxRoleUrl,
                data:{type:"export",sdate:$('#startTime').val(),edate:$('#endTime').val()},
                dataType:"json",
                async:false,
                success:function(data){           
                    
                }
            });
        }else{
            alert('请选择详细时间'); return false;
        }
        
    }
</script>