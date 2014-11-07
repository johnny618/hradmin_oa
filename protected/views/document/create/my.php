<style>
	body{ background-color: #fff;}
    ul.yiiPager .first, ul.yiiPager .last{display:inline;}
</style>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>css/pagestyle.css">
<div class="process">
    <h3 class="title">文档列表</h3>
	<div class="pro-content">

            <form method="post">
        <table class="agent_set_table">                
                <thead>
                        <tr>
                            <th>编号</th>
                            <td><input type="text" name="id" value="<?php echo !empty($params['id']) ? $params['id'] : ''?>"></td>
                            <th>姓名</th>
                            <td><input type="text" name="uname" value="<?php echo !empty($params['uname']) ? $params['uname'] : ''?>"></td>
                            <th>主題</th>
                            <td><input type="text" name="title" value="<?php echo !empty($params['title']) ? $params['title'] : ''?>"></td>
                            <th>类型</th>
                            <td>
                                <select name="tid" >
                                    <option value=""></option>
                                    <?php foreach(Bll_Document::$doc_title as $key => $val):?>
                                        <?php if ($key == $tid ):?>
                                            <option selected="selected" value="<?php echo $key;?>"><?php echo $val;?></option>
                                        <?php else: ?>
                                            <option value="<?php echo $key;?>"><?php echo $val;?></option>
                                        <?php endif;?>
                                    <?php endforeach;?>
                                </select>
                            </td>
                            <td><input type="submit" value="搜索"></td>
                        </tr>
                </thead>
        </table>
    </form>

        <table class="search-result">
                <thead>
                        <tr>										
                            <th>
                                    <p>类型</p>
                            </th>
                            <th>
                                    <p>主题</p>
                            </th>

                                <th>
                                    <p>是否置頂</p>
                                </th>
                                <th>
                                    <p>创建人</p>
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
                                    <td><?php echo Bll_Document::$doc_title[$val['tid']];?></td>
                                    <td><?php echo $val['title'];?></td>

                                        <td><?php echo empty($val['top']) ? '否' : '是';?></td>
                                        <td><?php echo $val['uname'];?></td>

                                    <td><?php echo date('Y-m-d H:i:s',$val['created'])?></td>
                                    <td><?php echo $val['updated'];?></td>
                                    <td><a href="<?php echo Yii::app()->createUrl('/document/create/edit/',array('id'=>$val['id']))?>">编辑</a> 
                                        <a href="<?php echo Yii::app()->createUrl('/document/create/look/',array('id'=>$val['id']))?>" target="_blank">查看</a>

                                        <a href="javascript:deleteData(<?php echo $val['id']?>)" >刪除</a>
                                        <a href="javascript:topData(<?php echo $val['id'].','.$val['top'];?>)" >置頂</a>

                                    </td>
                            </tr>
                    <?php }?>
                </tbody>
        </table>
	  
            <?php echo MyTool::page_show('/document/create/list/',$page,$params);?>    
        	
	</div>
</div>


<script type="text/javascript">
    var ajaxurl = "<?php echo $this->createUrl('/document/create/ajax');?>";
    function deleteData(id){
        if (confirm('确认删除该条文档么？')){
            $.ajax({
                type : "post",
                url : ajaxurl,
                data : {type:"delete_data",id:id},
                dataType : "json",
                async : false,
                success : function(data){
                    if (data.code == "success"){
                        location=location;
                    }else{
                        alert(data.mes);
                    }
                }
            });
        }
    }

    function topData(id,status){
        if (confirm('确认置頂该条文档么？')){
            $.ajax({
                type : "post",
                url : ajaxurl,
                data : {type:"top_data",id:id,status:status},
                dataType : "json",
                async : false,
                success : function(data){
                    if (data.code == "success"){
                        location=location;
                    }else{
                        alert(data.mes);
                    }
                }
            });
        }
    }
</script>