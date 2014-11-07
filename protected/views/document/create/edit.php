<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>css/set/set.css">
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>js/ckeditor/ckeditor.js"></script>
<div class="set">    
	<div class="settype">
            <div class="settitle"><?php echo Bll_Document::$doc_title[$data['tid']]?></div>
		<div id="setheight" class="settype_main settype_new_main">
                    <form method="post" id="frm_submit" action="">
			<div class="settype_table">		    
				<div class="settype_new">
                                    <div class="settype_newbox">                                        
                                        <ul class="clearfix">
                                                <li>
                                                    <label class="fl">标&nbsp;&nbsp;&nbsp;题</label>
                                                    <input type="text" style="width: 70%" value="<?php echo $data['title']?>"  name="title" id="title"  />  
                                                    
                                                </li>
                                                
                                                <li>
                                                    <label class="fl">内&nbsp;&nbsp;&nbsp;容</label>                                                    
                                                </li>
                                        </ul>
                                        <textarea name="tip" id="tip" class="txtExplain"><?php echo $data['tip']?></textarea>
                                    </div>
				</div>
				<div class="settype_button">
                                    <a href="javascript:;" onclick="javascript:frmsubmit();">保存</a>                                    
                                    <a href="<?php echo $this->createUrl('/document/create/list')?>">返回</a>
                                </div>	
                            	
			</div>
                    </form>
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


$(document).ready(function () {
    tip = CKEDITOR.replace( 'tip',{
        skin:'kama',
        toolbar:[    ['Font','-','FontSize','-','TextColor','BGColor','-','Bold','Italic','Underline','-','JustifyLeft','JustifyCenter','JustifyRight','-','NumberedList','BulletedList','Table','HorizontalRule','Maximize']],
        resize_minWidth:'510',
        resize_maxWidth:'616',
        width:'90%',
        height:'500',
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
    if ('' == $.trim($('#title').val())){        
        alert('标题为空!');
        ch_bool = false;
        return false
    }
    if ('' == $.trim(tip.document.getBody().getText()) ){
        alert('工作小结不能为空!');
        ch_bool = false;
        return false        
    }    
    
    if (ch_bool){
        $('#frm_submit').submit();
    }

}
</script>