<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl . '/protected/assets/' ?>css/impact.css">    
<script src="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>js/impact.js"></script>
    
<body>
<!--
/*****************************************
  易班oa嵌入模块部分开发  2014-08-18
  作者：经常掉线（1696292264@qq.com）
  说明：
    嵌入代码中的 外链文件，包括样式和js。样式表如果跟其他样式有冲突，就加在其他样式表后面。
    页面代码直接加在模板里即可
*****************************************/
-->

<noscript>
    <style>.container{display:none}</style>
    <center><h1>请开启javascript支持，否则不给你看：）</h1></center>
</noscript>

<div class='container clearfix'>

<!-- 嵌入代码开始 -->
<div class='left-module'>
        <div class='process block'>
                <div class='title'>
                        <span class='process-ico block-ico'></span>
                        <span class='text'>常用流程</span>
                </div>
                <div class='process-item'>
                    <?php foreach($ids as $idsKey => $idsVal):?>
                        <a href="#" onclick="window.open('<?php echo $this->createUrl('/request/new/' . $idsKey);?>', '', 'top=0,left=0, toolbar=no, menubar=no, scrollbars=yes, resizable=no,location=no, status=no');return false;" class='item'>
                                <div class='<?php echo $idsVal['c']?> item-ico'></div>
                                <div class='text'><?php echo $idsVal['n']?></div>
                        </a>
                    <?php endforeach;?>   
                        <a class='item'><a>
                        <div class='clear-fix'></div>
                </div>
                <a href="<?php echo $this->createUrl('/request');?>" class='more'></a>
        </div>


    <div class='rule block'>
        <div class='title'>
            <span class='rule-ico block-ico'></span>
            <span class='text'>中心公告</span>
        </div>
        <!-- 中心制度的独立切换条。。。 -->

        <div class='selection-bar clearfix'>
            <div class='selection'>中心制度</div>
            <div class='selection'>值班表</div>
            <!--<div class='clear-fix'></div>-->
        </div>



        <div class='q-item'>
            <!-- href 属性关联more的href属性 -->
            <ul class='item-list gray' href="<?php echo Yii::app()->createUrl('/document/list/index/',array('tid'=>2)) ?>">
                <?php foreach($doc_zhongxin as $val):?>
                    <li>
                        <a href="<?php echo Yii::app()->createUrl('/document/create/look/',array('id'=>$val['id']))?>">
                            <div class='msg-text'><?php echo $val['title']?></div>
                            <!--<div class='msg-new'></div>-->
                            <div class='msg-date'><?php echo date('Y-m-d',$val['created'])?></div>
                        </a>
                    </li>
                <?php endforeach;
                $need_count = 4 - count($doc_zhongxin);
                if ($need_count) {
                    echo str_repeat('<li></li>', $need_count);
                }

                ?>
                <div class='no-line'></div>
            </ul>
            <ul class='item-list gray' href='<?php echo Yii::app()->createUrl('/document/list/index/',array('tid'=>3)) ?>'>
                <?php foreach($doc_zhiban as $val):?>
                    <li>
                        <a href="<?php echo Yii::app()->createUrl('/document/create/look/',array('id'=>$val['id']))?>">
                            <div class='msg-text'><?php echo $val['title']?></div>
                            <!--<div class='msg-new'></div>-->
                            <div class='msg-date'><?php echo date('Y-m-d',$val['created'])?></div>
                        </a>
                    </li>
                <?php endforeach;
                $need_count = 4 - count($doc_zhongxin);
                if ($need_count) {
                    echo str_repeat('<li></li>', $need_count);
                }

                ?>
                <div class='no-line'></div>
            </ul>
        </div>
        <a href="#" class='more'></a>
    </div>


    <?php if (Yii::app()->user->showRequestMenu) : ?>
        <div class='todo notitle-block'>
                <div class='title'>
                        <div class='f'>
                                <span class='red-ico nblock-ico'></span>
                                <span class='text'>待办事宜</span>
                        </div>
                </div>
                <div class='n-item'>
                        <ul class='item-list red'>
                            <?php foreach ($requests_to_do as $to_do) : ?>
                                <li>
                                    <a target="_blank" href="<?php echo $this->createUrl('/request/do/' . $to_do['id']); ?>" >
                                        <?php echo $to_do['title'] ?>
                                        <!--&nbsp;&nbsp;&nbsp;<div class='msg-new'></div>-->
                                        <div class='msg-date'><?php echo date('Y-m-d', $to_do['created']); ?></div>
                                    </a>
                                </li>
                            <?php endforeach;?>                                
                                <!-- no-line 是因为最后行是没有下划线的，如果不需要这个限制直接去掉即可 -->
                                <div class='no-line'></div>
                        </ul>
                </div>
                <a href="<?php echo $this->createUrl('/request/needdolist');?>" class='more'></a>
        </div>
    <?php endif;?>
    
        <div class='todo notitle-block'>
                <div class='title'>
                        <div class='f'>
                                <span class='red-ico nblock-ico'></span>
                                <span class='text'>未完事宜</span>
                        </div>
                </div>
                <div class='n-item'>
                        <ul class='item-list red'>
                            <?php foreach ($requests_did as $did) : ?>
                                <li>
                                    <?php if ($did->status == 1):?>
                                        <a target="_blank" href="<?php echo $this->createUrl('/request/show/' . $did->id); ?>" >
                                            <?php echo $did->title ?>
                                            <!--&nbsp;&nbsp;&nbsp;<div class='msg-new'></div>-->
                                            <div class='msg-date'><?php echo date('Y-m-d', $did->created); ?></div>
                                        </a>
                                    <?php else:?>
                                        <a target="_blank" href="<?php echo $this->createUrl('/request/edit/' . $did->id); ?>" >
                                            <?php echo $did->title ?>
                                            <!--&nbsp;&nbsp;&nbsp;<div class='msg-new'></div>-->
                                            <div class='msg-date'><?php echo date('Y-m-d', $did->created); ?></div>
                                        </a>
                                    <?php endif;?>
                                </li>
                            <?php endforeach;?>                                
                                <!-- no-line 是因为最后行是没有下划线的，如果不需要这个限制直接去掉即可 -->
                                <div class='no-line'></div>
                        </ul>
                </div>
                <a href="<?php echo $this->createUrl('/request/my?type=1');?>" class='more'></a>
        </div>
        <div class='sum notitle-block'>

                <div class='title'>
                        <div class='f'>
                                <span class='blue-ico nblock-ico'></span>
                                <span class='text'>我的办结</span>
                        </div>
                </div>
                <div class='n-item'>
                        <!-- 十分想吐槽点的颜色，太奇葩了，同一个板式居然还有不同颜色的。。 -->
                        <!-- 点的颜色用 下面的class来指定 ，blue显示默认点颜色，red显示红色，即上面的样子 -->
                        <ul class='item-list blue'>
                            <?php foreach ($requests_done as $done) : ?>
                                <li>
                                    <a target="_blank" href="<?php echo $this->createUrl('/request/show/' . $done->id); ?>" >
                                        <?php echo $done->title ?>
                                        <!--&nbsp;&nbsp;&nbsp;<div class='msg-new'></div>-->
                                        <div class='msg-date'><?php echo date('Y-m-d', $done->created); ?></div>
                                    </a>
                                </li>
                            <?php endforeach;?> 
                            <div class='no-line'></div>
                        </ul>
                </div>
                <a href="<?php echo $this->createUrl('/request/my?type=999');?>" class='more'></a>

        </div>
    
    <div class='clear-fix'></div>
    


</div>
<div class="right-module">
        <div class="tongzhi r-block">
                <div class="title">
                        <span class="tongzhi-ico block-ico"></span>
                        <span class="text">最新通知</span>
                </div>
                <div class="item tongzhi">
                        <div class="tongzhi-container">
                            <?php foreach ($doc_tongzhi as $val) : ?>
                                <div class="tongzhi-item">
                                    <a href="<?php echo Yii::app()->createUrl('/document/create/look/',array('id'=>$val['id']))?>" class='tongzhi-title'><?php echo $val['title']?></a>
                                    <a href="<?php echo Yii::app()->createUrl('/document/create/look/',array('id'=>$val['id']))?>" class='tongzhi-body'>                                             
                                        <?php echo Bll_Document::filter_html_str(strip_tags(htmlspecialchars_decode($val['tip'])));?>
                                    </a>
                                </div>
                            <?php endforeach;?>
                            
                            
                        </div>
                </div>
                <div class='selection-container'>
                        <span class='selection-page page1'></span>
                        <span class='selection-page page2'></span>
                        <span class='selection-page page3'></span>
                </div>
                <a href="<?php echo Yii::app()->createUrl('/document/list/index/',array('tid'=>1)) ?>"  class='more'></a>
        </div>

        <iframe frameborder=0 class='tianqi r-block' src='http://i.tianqi.com/index.php?c=code&id=55'></iframe>


    <div class='ybnews block clearfix'>
        <div class='title'>
            <span class='ybnews-ico block-ico'></span>
            <span class='text'>易班大事记</span>
        </div>
        <div class='n-item'>
            <ul class='item-list gray'>
                <?php foreach($doc_yiban as $key => $val):?>
                    <li>
                        <a href="<?php echo Yii::app()->createUrl('/document/create/look/',array('id'=>$val['id']))?>" target="_blank">
                            <?php echo $val['title'];?>
                            <!--                        <div class='msg-date'>2013-11-12</div>-->
                        </a>
                    </li>
                <?php endforeach;
                    $yiban_count = 4 - count($doc_yiban);
                    if ($yiban_count) {
                        echo str_repeat('<li></li>', $yiban_count);
                    }
                ?>

                <!-- no-line 是因为最后行是没有下划线的，如果不需要这个限制直接去掉即可 -->
                <div class='no-line'></div>
            </ul>
        </div>
        <a href="<?php echo Yii::app()->createUrl('/document/list/index/',array('tid'=>4)) ?>" class='more'></a>
    </div>


        <div class='banche r-block clearfix'>
                <div class='title red'>
                        <span class='banche-ico block-ico'></span>
                        <span class='text'>班车动态</span>
                </div>
                <div class='text'>
                班车运行情况（整点国康路出发，半点国顺路出发）<br><br>
                每日运行情况可见各楼层班车动态告示牌<br>
                请提早15分钟至各楼层行政助理处登记乘坐<br>
                如遇班车问题，请联系：18621987110
                </div>
        </div>
</div>
<!-- 嵌入代码结束 -->

</div>

</body>