
<style>
	body{ background-color: #fff;}
</style>


<div class="process">
	<!-- 角色设置start -->
	<h3 class="title">角色</h3>
	<div class="pro-content">
	    <form method="post">
    		<table class="role-set">
    			<caption>
    				<a href="<?php echo $this->createUrl('/settings/role/roleedit/0');?>" class="oa-btn">新建</a>
    				<a href="javascript:;" class="oa-btn" name="del_btn">删除</a>
    			</caption>
    			<thead>
    				<tr>
    					<th><p><input id="all_check" type="checkbox"/>角色设置</p></th>
    					<th><p>成员</p></th>
    				</tr>
    			</thead>
    			<tbody>
                                <?php foreach ($roles as $role) {?>
    				<tr>
    					<td><input type="checkbox" name="role_id[]" value="<?php echo $role['id'];?>"/><a href="<?php echo $this->createUrl('/settings/role/roleedit/' . $role['id']);?>"><?php echo $role['name'];?></a></td>
    					<td><?php echo $role['cou'];?></td>
    				</tr>
                                <?php }?>
    			</tbody>
    		</table>
		</form>
	</div>
	<!-- 角色设置end -->
</div>
<script>
$('[name=del_btn]').click(function(){
    $('form').submit();
    return false;
});

$('#all_check').click(function(){    
    if ($(this).prop("checked")) {
        $("input[name='role_id[]']").not(':checked').prop("checked",true);
    }else{
        $("input[name='role_id[]']").filter(':checked').prop("checked",false);
    } 
});

</script>
