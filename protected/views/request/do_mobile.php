<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo $request->title;?></title>
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<style>
body,h3,h4,table{ margin: 0;padding: 0;}
body{ font-family: "Microsoft Yahei"; font-size: 14px;}
.sp-title{ background-color: #003368; color: #fff; text-align: center; height: 40px;line-height: 40px;}
.spBox{ padding: 10px;}
.spBox table{ width: 100%; border-collapse: collapse;}
.spBox table td,.spBox table th{ padding: 8px 0; text-align: left; vertical-align: top; border-bottom: 1px solid #e9e9e9;}
.spBox textarea{ width: 98%; display: block; margin:0 auto; margin-top: 8px;resize:none; height: 100px; border-radius: 5px; background-color: #f1f3f5; box-shadow: inset 0 0 5px rgba(0,0,0,0.3),2px 2px 2px rgba(0,0,0,0.1); border-color: #bbb;}
.spBox tr:last-child td{ text-align: center; border: 0;}
.spBox tr:nth-of-type(5) th,.spBox tr:nth-of-type(6) td,.spBox tr:nth-of-type(8) td{ border: 0;}
.spBox h4{ height: 30px; line-height: 30px; background-color: #003368; padding-left: 5px; color: #fff;}
.sp-btn{ display: inline-block; background-color: #f9f9f9; height: 32px;line-height: 32px; padding:0 32px; letter-spacing: 1px; border: 1px solid #6b7c8a; border-radius: 5px; color: #000; text-decoration: none; }
.sp-btn:hover,.sp-btn.active{ border-color: #36546a; background-color: #dde3e7;}
</style>
</head>
<body>
<?php
$cs = Yii::app()->clientScript;
$cs->registerCoreScript('jquery');
?>
	<h3 class="sp-title">请求：<?php echo $request->title;?></h3>
	<div class="spBox">
		<table>
			<tr>
				<th width="100">标题：</th>
				<td><?php echo $request->title;?></td>
			</tr>
			<tr>
				<th>申请人：</th>
				<td><?php echo $request->uname;?></td>
			</tr>
			<?php foreach ($main_items as $main_item) {
			    if (in_array($main_item->id, $nodes['show'])) {
		    ?>
                <tr>
                    <th><?php echo $main_item->field_name?>：</th>
                    <td>
                        <?php
                        if (isset($request->body[$main_item->db_field_name])) {
                            if ($main_item->field_type == 3) {
                                echo $request->body[$main_item->db_field_name] ? '是' : '否';
                            } elseif ($main_item->field_type == 5) {
                                foreach ($request->body[$main_item->db_field_name] as $v) {
                                    echo '<img src="' . $this->createUrl($v) . '" style="margin-right:5px;" width="50" height="50"/>';
                                }
                            } else {
                                echo $request->body[$main_item->db_field_name];
                            }
                        }?>
                    </td>
                </tr>
            <?php }
			}?>
			<?php if (isset($request['body']['detail_datas'])) {
			    foreach ($request['body']['detail_datas'] as $v) {
                    foreach ($v as $k => $detail_line) {
                ?>
                        <tr>
            				<td colspan="2">
            					<h4>序号：<?php echo $k + 1;?></h4>
            				</td>
            			</tr>
        			    <?php foreach ($detail_line as $key => $line) {?>
        			    <tr>
				            <th><?php echo $detail_items[$key]['field_name']?>：</th>
            				<td><?php echo $line;?></td>
            			</tr>
        			    <?php }?>
        			<?php }?>
			    <?php }?>
			<?php }?>
			<tr>
				<th colspan="2">签字意见：<textarea name="" id="tip_text"></textarea></th>
			</tr>
			<tr>
				<td colspan="2">
				<?php if (!$next_node) {?>
                <a href="#" id="submit_request" class="oa-btn">提交</a>
                <?php } else {?>
                <a href="#" id="submit_request" class="sp-btn"><?php echo $next_node['nodeinfo']['name'];?></a>
                <?php if (isset($next_node['nextinfo']['isback']) && $next_node['nextinfo']['isback'] == 1) {?>
                <a href="#" id="submit_back" class="sp-btn">退回</a>
                <?php }?>
                <?php }?>
				</td>
			</tr>
		</table>
	</div>
<script>
$('#submit_back').click(function(){
    $.post('<?php echo $this->createUrl('/ajax/request/back');?>', {id:<?php echo $request->id?>, UE_tip:$('#tip_text').val()}, function(rs){
        alert(rs.msg);
    }, 'json');
    return false;
});
$('#submit_request').click(function(){
    $.post('<?php echo $this->createUrl('/ajax/request/update')?>', { mobile:true, id:<?php echo $request->fid?>,request_id:<?php echo $request->id?>,UE_tip:$("#tip_text").val(),current_form_node_id:<?php echo $current_form_node->id?>}, function(rs){
        if (rs.code == 0) {
            alert(rs.msg);            
        } else {
        	alert(rs.msg);
        }
    }, 'json');
    return false;
});
</script>
</body>
</html>