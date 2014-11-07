<style>
	body{ background-color: #fff;}
    ul.yiiPager .first, ul.yiiPager .last{display:inline;}
</style>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>css/pagestyle.css">
<div class="process">
    <h3 class="title">文档列表&nbsp;&nbsp;&nbsp;{&nbsp;<?php echo Bll_Document::$doc_title[$params['tid']]?>&nbsp;}</h3>
	<div class="pro-content">

        <table class="search-result">
                <thead>
                        <tr>
                            <th>
                                    <p>主题</p>
                            </th>
                            <th>
                                    <p>创建时间</p>
                            </th>
                            <th>
                                    <p>最后更新时间</p>
                            </th>
                            <th>
                                    <p>操作</p>
                            </th>
                        </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $val) {?>
                            <tr>                                           
                                    <td><?php echo $val['title'];?></td>
                                    <td><?php echo date('Y-m-d H:i:s',$val['created'])?></td>
                                    <td><?php echo $val['updated'];?></td>
                                    <td>
                                        <a href="<?php echo Yii::app()->createUrl('/document/create/look/',array('id'=>$val['id']))?>" target="_blank">查看</a> 
                                    </td>
                            </tr>
                    <?php }?>
                </tbody>
        </table>
	  
            <?php echo MyTool::page_show('/document/list/index/',$page,$params);?>
        	
	</div>
</div>