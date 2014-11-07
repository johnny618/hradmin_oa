<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>css/set/set.css">

<div class="set">    
	<div class="settype">
            <div class="settitle"><?php echo Bll_Document::$doc_title[$data['tid']]?></div>
		<div id="setheight" class="settype_main settype_new_main">
                    <div class="settype_table">	
			
                            <h1 align="center"><?php echo $data['title']?></h1>
                            <br/>
                            <div><?php echo htmlspecialchars_decode($data['tip'])?></div>
                            
				
                    </div> 	
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


</script>