<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>css/set/set.css">
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>css/pagestyle.css">
<style>
	body{ background-color: #fff;}
</style>
<div class="process">
<!-- 流程代理设置start -->
<h3 class="title">我的工作小结</h3>
<div class="pro-content">
        <table class="agentTable">
                <thead>
                        <tr>
                                <th><p>小结日期</p></th>                                
                                <th><p>创建人</p></th>
                                <th><p>创建时间</p></th>                                
                                <th><p>最后更新时间</p></th>   
                                <th><p>是否迟交</p></th>
                                <th><p>操作</p></th>
                        </tr>
                        <tbody>
                            <?php foreach($rows as $value):?>
                                <tr>
                                    <td>
                                        <a onclick="javascript:showtip('<?php echo addslashes($value['report'])?>')" href="#"><?php echo date('Y-m-d',$value['reportTime']);?></a>
                                    </td>                                    
                                    <td><?php echo $value['uname'];?></td>
                                    <td><?php echo date('Y-m-d H:i:s',$value['created']);?></td>
                                    <td><?php echo $value['updated'];?></td>                                   
                                    <td><?php echo empty($value['late']) ? '否' : '是' ;?></td>
                                    <td><a href="<?php echo Yii::app()->createUrl('/workreport/workentry/edit/',array('id'=>$value['id']))?>">编辑</a></td>
                                </tr>
                            <?php endforeach;?>
                        </tbody>
                </thead>
        </table>
        
    <div class="clearfix"></div>    
        <?php echo MyTool::page_show('/workreport/mywork/list/',$page);?>    
    <div class="clearfix"></div>
    
    <div hidden="hidden" id="report" style="width:98%;margin:10px auto; height:400px; overflow-y: auto; "></div>
</div>

<!-- 流程代理设置end -->
<script type="text/javascript">
    function showtip(report){
       $('#report').show();
       $('#report').html(report);
    }
</script>    