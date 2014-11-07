<style>
	body{ background-color: #fff;}
</style>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>css/pagestyle.css">
<div class="process">
<!-- 流程代理设置start -->
<h3 class="title">已办事宜</h3>
<div class="pro-content">
        <table class="agentTable">
<!--                <caption><strong>其他操作人代理状况</strong></caption>-->
                <thead>
                        <tr>
                            <th><p>创建时间</p></th>
                            <th><p>创建人</p></th>
                            <th><p>请求标题</p></th>
                            <th><p>工作流</p></th>
                        </tr>
                        <tbody>
                            <?php foreach($rows as $value):?>
                                <tr>
                                    <td><?php echo date('Y-m-d H:i:s',$value['created']);?></td>
                                    <td><?php echo $value['uname'];?></td>
                                    <td><a href="<?php echo $this->createUrl('/request/show/' . $value['id']);?>"><?php echo $value['title'];?></a></td>
                                    <td><?php echo $value['workname'];?></td>
                                </tr>
                            <?php endforeach;?>
                        </tbody>
                </thead>
        </table>        
    <?php echo MyTool::page_show('/request/donelist/',$page);?>

</div>
