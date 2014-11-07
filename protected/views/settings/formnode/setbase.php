
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>css/set/set.css">

	<div class="set">
		<div id="roadheight" class="road"><!--路径设置 开始-->
                    <?php $this->widget('MenuWidget');?>
            <div class="set_right" id="set_right" style="background-color:#fff;">
            	<iframe style="background-color:#fff;" frameborder="0" name="set_iframe" scrolling="no" id="set_iframe" width="100%" src="<?php echo Yii::app()->createUrl('/settings/formnode/default')?>"></iframe>
            </div>
		</div><!--路径设置 结束-->
	</div>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>js/set/set.js"></script>
<script type="text/javascript">
$(function(){
	$(".road_form table tr:odd").find("td").css({"border-bottom-color":"1px solid #f4f6f7","background-color":"#f9f9f9"});
	$(".road_form table tr:last").find("td").css("border","none");	
});
//自适应高度
function heightChange(){
	var roadAct = document.getElementById("road_act");
	var roadToogle = document.getElementById("road_toogle");
        //------
	var setIframe = document.getElementById("set_iframe");
	var bodyHeight = document.documentElement.clientHeight - 9 - 15;   //9代表的是上外边距，32是标题栏的高度，15是距离浏览器下部分的距离
	var setRight = document.getElementById('set_right');
	roadAct.style.height = bodyHeight - 24 + "px";   //24是左侧功能最外层div的上内边距
	var bodyWidth = document.documentElement.clientWidth;
        //------
	setIframe.style.height = 3000 + "px";
	setRight.style.width = document.documentElement.clientWidth - $('#road_act').outerWidth(true) - 12 - 2+ 'px';
	setRight.style.left = $('#road_act').outerWidth(true)+12+ "px";   //12是切换左侧开关按钮的宽度
        //-----
        //setIframe.style.height= setIframe.contentWindow.document.getElementById('roadheight').offsetHeight+'px';
	
}
heightChange();
window.onresize = heightChange;
</script>
