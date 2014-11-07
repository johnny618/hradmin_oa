<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl . '/protected/assets/' ?>css/index.css">
<div class="wrap">
		<!-- 首页内容左侧start -->
		<div class="events">
			<div class="ebox">
				<div class="tabmenu" id="tab1">
					<div class="nav">
						<div>
						<ul name="nav_ul">
<!--							<li data-url="<?php echo $this->createUrl('/request/my?type=0');?>">待办事宜</li>-->
							<li data-url="<?php echo $this->createUrl('/request/my?type=1');?>">未完事宜</li>
							<li data-url="<?php echo $this->createUrl('/request/my?type=999');?>">办结事宜</li>
						</ul>
						</div>
						<a href="javascript:;" class="leftBtn"></a>
						<a href="javascript:;" class="rightBtn"></a>
					</div>
					<div class="content">
					<div class="content-div">
<!--						<div>
                            <ul>
                            <?php //foreach ($requests_wait as $wait) { ?>
                                <li><a href="<?php //echo $this->createUrl('/request/show/' . $wait->id); ?>"><?php //echo $wait->title ?><em>new</em></a><cite><?php //echo date('Y-m-d', $wait->created); ?></cite></li>
                                <?php
//                                }
//                                $need_count = 4 - count($requests_wait);
//                                if ($need_count) {
//                                    echo str_repeat('<li></li>', $need_count);
//                                }
                                ?>
                            </ul>
						</div>-->
						<div>
							<ul>
                                <?php foreach ($requests_did as $did) { ?>
                                    <li><a href="<?php echo $this->createUrl('/request/show/' . $did->id); ?>"><?php echo $did->title ?><em>new</em></a><cite><?php echo date('Y-m-d', $did->created); ?></cite></li>
                                <?php
                                    }
                                    $need_count = 4 - count($requests_did);
                                    if ($need_count) {                                        
                                        echo str_repeat('<li></li>', $need_count);
                                    }
                                    ?>
                            </ul>
						</div>
						<div>
							<ul>
                            <?php foreach ($requests_done as $done) { ?>
                                    <li><a href="<?php echo $this->createUrl('/request/show/' . $done->id); ?>"><?php echo $done->title ?><em>new</em></a><cite><?php echo date('Y-m-d', $done->created); ?></cite></li>
                            <?php
                                  }
                                  $need_count = 4 - count($requests_done);
                                  if ($need_count) {
                                        echo str_repeat('<li></li>', $need_count);
                                  }
                            ?>
                            </ul>
						</div>
					</div>
					</div>
                    <a href="#" class="more" name="more_btn">more</a>
                </div>
			</div>
			<div class="ebox" style="padding-bottom: 20px;">
				<div class="lcBox">
					<div>
						<ul>
                            <?php foreach ($request_list as $key => $list) {
                                if ($key > 7) {
                                    break;
                                }
                            ?>                                                                                                  
                                <li><a href="#" onclick="window.open('<?php echo $this->createUrl('/request/new/' . $list['id']);?>', '', 'top=0,left=0, toolbar=no, menubar=no, scrollbars=yes, resizable=no,location=no, status=no');return false;" class="yp"><s></s><?php echo $list['name'];?></a></li>
                            <?php }?>
						</ul>
					</div>
					<a href="javascript:;" class="leftBtn"></a>
					<a href="javascript:;" class="rightBtn"></a>
				</div>
				<ul class="lcUl">
                    <?php if (isset($request_list[8])) {?>
                                    <li><a href="#" onclick="window.open('<?php echo $this->createUrl('/request/new/' . $request_list[8]['id']);?>', '', 'top=0,left=0, toolbar=no, menubar=no, scrollbars=yes, resizable=no,location=no, status=no');return false;"><?php echo $request_list[8]['name']?></a></li>
                    <?php }?>
					<?php if (isset($request_list[9])) {?>
					<li><a href="#" onclick="window.open('<?php echo $this->createUrl('/request/new/' . $request_list[9]['id']);?>', '', 'top=0,left=0, toolbar=no, menubar=no, scrollbars=yes, resizable=no,location=no, status=no');return false;"><?php echo $request_list[9]['name']?></a></li>
                    <?php }?>
				</ul>
				<a href="<?php echo $this->createUrl('/request');?>" class="more" style="right:50px; bottom:15px;">more</a>
			</div>
		</div>
		<!-- 首页内容左侧end -->
		<!-- 首页内容右侧start -->
		<div class="dynamic">
			<div class="dybox">
				<h3 class="bc-title"><span>班车动态</span></h3>
				<div class="bctip">
					<div>
						<h4>班车运行情况（整点国康路出发，半点国顺路出发）</h4>
						<p>每日运行情况可见各楼层班车动态告示牌
	请提早15分钟至各楼层行政助理处登记乘坐
	如遇班车问题，请联系：18621987110</p>
					</div>
				</div>
			</div>
		</div>
		<!-- 首页内容右侧end -->
	</div>
<script src="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>js/index.js"></script>
<script>
	var oTab1 = new switchTab('tab1');
	oTab1.init();
	var oTab2 = new switchTab('tab2');
	oTab2.init();
	var oTab3 = new switchTab('tab3');
	oTab3.init();
	fnSwitchlc();
	fnSwitchDeeds();
    $('[name=more_btn]').click(function(){
        location.href = $('[name=nav_ul] li.active').data('url');
        return false;
    });
</script>
