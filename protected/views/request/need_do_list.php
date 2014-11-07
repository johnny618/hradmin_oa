<style>
	body{ background-color: #fff;}
</style>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>css/pagestyle.css">
<div class="process">
	<!-- 搜索start -->
	<h3 class="title">待办事宜</h3>
	<div class="pro-content">
	<?php if(0) {?>
		<table class="pro-search-table">
			<tbody>
				<tr>
					<th>类型</th>
					<td><label for="" class="lbl-type">哈哈哈</label></td>
					<th>节点类型</th>
					<td>
						<select name="nodetype" id="">
							<option value="">创建</option>
							<option value="">批准</option>
							<option value="">提交</option>
							<option value="">归档</option>
						</select>
					</td>
					<th>请求标题</th>
					<td><input type="text" name="title"></td>
					<th>创建日期</th>
					<td><input type="text"><span>-</span><input type="text"></td>
				</tr>
				<tr>
					<th>创建人</th>
					<td><label for="" class="lbl-type">哈哈哈</label></td>
					<th>创建人编号</th>
					<td><input type="text" name="createId"></td>
					<th>节点类型</th>
					<td>
						<select name="" id="">
							<option value="">近6个月</option>
							<option value="">近12个月</option>
							<option value="">近18个月</option>
							<option value="">全部</option>
						</select>
					</td>
					<th></th>
					<td></td>
				</tr>
				<tr>
					<th colspan="8" align="left"><a href="javascript:;" class="oa-btn">搜索</a></th>
				</tr>
			</tbody>
		</table>
		<?php }?>
		<table class="search-result">
			<thead>
				<tr>
					<th><p>创建日期</p></th>
					<th><p>创建人</p></th>
                                        <th><p>请求标题</p></th>
					<th><p>工作流</p></th>					
				</tr>
			</thead>
			<tbody>
			<?php foreach ($forms as $form) {?>
				<tr>
					<td><?php echo date('Y-m-d H:i:s', $form['created']);?></td>
					<td><?php echo $form['uname'];?></td>					
					<td><a target="_blank" href="#" onclick="window.open('<?php echo $this->createUrl('/request/do/' . $form['id']);?>', '', 'top=0,left=0, toolbar=no, menubar=no, scrollbars=yes, resizable=no,location=no, status=no');return false;"><?php echo $form['title']?></a></td>
                                        <td><?php echo $form['workname'];?></td>
				</tr>
			<?php }?>
			</tbody>
		</table>
            <?php echo MyTool::page_show('/request/needdolist/',$page);?>
	</div>
	<!-- 搜索end -->
</div>