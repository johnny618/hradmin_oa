<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>css/set/set.css">
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>js/ckeditor/ckeditor.js"></script>
<div class="set">    
	<div class="settype">
		<div class="settitle">每日工作小结</div>
		<div id="setheight" class="settype_main settype_new_main">
                    <form method="post" id="frm_submit" action="">
			<div class="settype_table">		    
				<div class="settype_new">
                                    <div class="settype_newbox">                                        
                                        <ul class="clearfix">
                                                <li>
                                                    <label class="fl">日&nbsp;&nbsp;&nbsp;期</label>
                                                    <input type="text" value="<?php echo date('Y-m-d',  $row['reportTime']);?>"  name="workdate" style="width:100px;" class="Wdate" readonly="readonly" id="workdate"
                                                           onfocus="WdatePicker({skin:'whyGreen',maxDate:'%y-%M-%d'})" />  
                                                                                          
                                                </li>
                                                <li>
                                                    <label class="fl">部&nbsp;&nbsp;&nbsp;门</label>
                                                    <label class="fl"><?php echo Yii::app()->user->dept_cn?></label>
                                                </li>
                                                <li>
                                                    <label class="fl">姓&nbsp;&nbsp;&nbsp;名</label>
                                                    <label class="fl"><?php echo Yii::app()->user->name?></label>
                                                </li>
                                                <li>
                                                    <label class="fl">小&nbsp;&nbsp;&nbsp;结</label>                                                    
                                                </li>
                                        </ul>
                                        <textarea name="tip" id="tip" class="txtExplain"><?php echo $row['report']?></textarea>
                                    </div>
				</div>
				<div class="settype_button">
                                    <a href="javascript:;" onclick="javascript:frmsubmit();">保存</a>                                    
                                    <a href="<?php echo $this->createUrl('/workreport/mywork/list/')?>">返回</a>
                                </div>		    
			</div>
                    </form>
		</div>
	</div>
    
</div>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>js/set/set.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript">
    var ajaxurl = '<?php echo $this->createUrl('/workreport/workentry/ajax/');?>';
    
//自适应高度
function heightChange(){
	var setHeight = document.getElementById("setheight");
	var bodyHeight = document.documentElement.clientHeight - 9 - 32 - 15;   //9代表的是上外边距，32是标题栏的高度，15是距离浏览器下部分的距离
	setHeight.style.height = bodyHeight + "px";
}
window.onload = heightChange();


$(document).ready(function () {
    tip = CKEDITOR.replace( 'tip',{
        skin:'kama',
        toolbar:[    ['Font','-','FontSize','-','TextColor','BGColor','-','Bold','Italic','Underline','-','JustifyLeft','JustifyCenter','JustifyRight','-','NumberedList','BulletedList','Table','HorizontalRule','Maximize']],
        resize_minWidth:'510',
        resize_maxWidth:'616',
        width:'90%',
        margin:'10px auto 0',
        //colorButton_colors:'333333,008000,000080,800080,C90000,FFFF00,EBEBEB',
        colorButton_enableMore:false,
        fontSize_sizes:'12/12px;14/14px;16/16px;18/18px;24/24px',
        font_names:'宋体/宋体,Arial, Helvetica, sans-serif;黑体/黑体,Arial, Helvetica, sans-serif;楷体/楷体, 楷体_GB2312,Arial, Helvetica, sans-serif;',
        pasteFromWordRemoveFontStyles:true,
        pasteFromWordRemoveStyles:true
    });
        
});
    
function frmsubmit(){
    var ch_bool = true;    
    if ('' == $.trim(tip.document.getBody().getText()) ){
        alert('工作小结不能为空!');
        ch_bool = false;    
    }    
    if ('' == $.trim($('#workdate').val())){        
        alert('日期不能为空!');
        ch_bool = false;
    }
   
    $.ajax({
        type:'post',
        url:ajaxurl,
        data:{type:"checkdate",id:<?php echo $row['id']?>,date:$('#workdate').val()},
        dataType:"json",
        async:false,
        success:function(data){
            if (data.code == 'error'){
                alert('小结日期已存在!');
                ch_bool = false;
            }
        }
       
    });

    if (ch_bool){
        $('#frm_submit').submit();
    }

}
</script>