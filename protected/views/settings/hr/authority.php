<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>css/set/set.css">
<style>
	body{ background-color: #fff;}
	.aut_adddiv{top:0px;}
</style>
<div class="process">
	<h3 class="title">权限</h3>
	<div class="pro-content">
	<form method="post">
	    <input type="hidden" name="leader_id" id="leader_id_input" />
		<table class="renli">
			<tbody>
			<tr>
				<th width="15%">编号</th>
				<td><?php echo $user->uid;?></td>
			</tr>
			<tr>
				<th>姓名</th>
				<td><?php echo $user->uname;?></td>
			</tr>
			<tr>
				<th>部门</th>
				<td><?php echo $user->dept_cn;?></td>
			</tr>
                        
                        <?php foreach (MyConst::$meuns_arr as $meuns_arrKey => $meuns_arrVal):?>
                            <tr>
                                <th><?php echo $meuns_arrVal;?></th>
                                <td>
                                    <?php if(in_array($meuns_arrKey, $menu)): ?>
                                        <input type="checkbox"  checked="checked"  b="<?php echo $meuns_arrKey;?>" name="author" />
                                    <?php else: ?>
                                        <input type="checkbox"  b="<?php echo $meuns_arrKey;?>" name="author" />
                                    <?php endif;?>
                                </td>                                        
                            </tr>
                        <?php endforeach;?>	
			</tbody>
			<tfoot>
				<tr>
					<td colspan="2" align="center">
                        <input type="hidden" name="reffer" value="<?php echo isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $this->createUrl('/settings/hr/search');?>" />
					    <a href="javascript:;" class="oa-btn" id="fsave">保存</a>
                        <a href="<?php echo isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $this->createUrl('/settings/hr/search');?>" class="oa-btn">返回</a>
			        </td>
				</tr>
			</tfoot>
		</table>
	</form>
	</div>
	
</div>

<script type="text/javascript">
    var ajaxurl = '<?php echo $this->createUrl('/settings/hr/ajax/');?>';
    var hrindexurl = '<?php echo $this->createUrl('/settings/hr/Search/');?>';
    $('#fsave').click(function(){
        var menus = new Array();
        $('input[name="author"]:checked').each(function(){
            menus.push($(this).attr('b'));
        });                          
        $.ajax({
            type:'post',
            url:ajaxurl,
            data:{type:"setauthor",uid:<?php echo $user->uid?>,data:menus},
            dataType:"json",
            async:false,
            success:function(data){
                if (data.code == "success"){
                    location.href = hrindexurl;
                }else{
                    alert(data.msg);
                }
            }
        });
    });



</script>