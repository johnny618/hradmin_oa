<style>
	body{ background-color: #fff;}
    ul.yiiPager .first, ul.yiiPager .last{display:inline;}
</style>
<div class="process">
	<h3 class="title">搜索：人力资源</h3>
	<div class="pro-content">
	    <form id="hr_form">
	        <div class="zhaomin">
				<div><a href="javascript:;" class="oa-btn" name="Searchbtn">搜索</a></div>
				<span>人力搜索</span>
			</div>
    		<table class="rl-search-table">
    			<tr>
    				<th>编号</th>
    				<td><input type="text" name="id"></td>
    				<th>姓名</th>
    				<td><input type="text" name="uname"></td>
                                <th>部门</th>
    				<td><input type="text" name="dept"></td>
    			</tr>
    		</table>
    		<script>
    	    $('[name=Searchbtn]').click(function(){$('#hr_form').submit();});
    		</script>
		</form>
		<table class="search-result">
			<thead>
				<tr>
					<th>
						<p>编号</p>
					</th>
					<th>
						<p>姓名</p>
					</th>
					<th>
						<p>部门</p>
					</th>
					<th>
						<p>上级</p>
					</th>
                                        <th>
						<p>操作</p>
					</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($result as $user) {?>
				<tr>
					<td><?php echo $user->uid;?></td>
					<td><a href="<?php echo $this->createUrl('/settings/hr/edit/' . $user->id);?>"><?php echo $user->uname;?></a></td>
					<td><?php echo $user->dept_cn;?></td>
					<td><?php echo $user->leader ? $user->leader->uname : '';?></td>
                                        <td><a href="<?php echo Yii::app()->createUrl('/settings/hr/authority/'. $user->id)?>">权限设置</a>&nbsp;
                                        <a href="<?php echo Yii::app()->createUrl('/settings/entry/edit/', array('uid'=>$user->uid))?>">编辑</a>
                                        <a href="#" onclick="javascript:del_row(<?php echo $user->uid;?>)">删除</a>
                                        </td>
				</tr>
			<?php }?>
			</tbody>
		</table>
		<?php
        $this->widget('CLinkPager', array(
            'header'=>'',
            'firstPageLabel' => '首页',
            'lastPageLabel' => '末页',
            'prevPageLabel' => '上一页',
            'nextPageLabel' => '下一页',
            'pages' => $pager,
            'maxButtonCount'=>10
        ));
        ?>
	</div>
</div>

<script type="text/javascript">
    function del_row(uid){
        if (confirm("确定要删除么 ? ")){
            $.ajax({
                type:"post",
                url:'<?php echo $this->createUrl('/settings/hr/ajax/');?>',
                data:{type:"delete_data",uid:uid},
                dataType:"json",
                async:false,
                success:function(data){
                    if (data.code == "success"){
                        location.href = location.href;
                    }else{
                        alert(data.msg);
                    }
                }
            });
        }
    }
</script>