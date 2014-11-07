<style>
	body{ background-color: #fff;}
</style>
<div class="process">
<?php $titles = array('0' => '未完事宜', '1' => '未完事宜', '999' => '我的办结')?>
    <?php if (isset($titles[$_GET['type']])) {?><h3 class="title"><?php echo $titles[$_GET['type']];?></h3><?php }?>
	<!-- 搜索start -->	
	<div class="pro-content">
	<?php if (0) {?>
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
                    <?php if($type == 999){?>     <!-- 已办类型给予撤销功能 -->     
                        <thead>
				<tr>
					<th><p>创建日期</p></th>
					<th><p>创建人</p></th>
					<th><p>工作流</p></th>
					<th><p>请求标题</p></th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($requests as $request) {?>
				<tr>
					<td><?php echo date('Y-m-d H:i:s', $request->created);?></td>
					<td><?php echo $request->uname;?></td>
					<td><?php echo $request->WorkForm ? $request->WorkForm->name : '';?></td>
					<td><a target="_blank" href="<?php echo $this->createUrl('/request/' . ($type == 0 ? 'edit' : 'show') . '/' . $request->id);?>"><?php echo $request->title?></a></td>
				</tr>
			<?php }?>
			</tbody>
                        
                    <?php }else{?>
                        <thead>
				<tr>
					<th><p>创建日期</p></th>
					<th><p>创建人</p></th>
					<th><p>工作流</p></th>
					<th><p>请求标题</p></th>
                                        <th><p>操作</p></th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($requests as $request) {?>
				<tr>
					<td><?php echo date('Y-m-d H:i:s', $request->created);?></td>
					<td><?php echo $request->uname;?></td>
					<td><?php echo $request->WorkForm ? $request->WorkForm->name : '';?></td>
					<td>
                                            <?php if ($request->status == 1):?>
                                            <a target="_blank" href="<?php echo $this->createUrl('/request/show/' . $request->id);?>"><?php echo $request->title?></a>
                                            <?php else:?>
                                            <a target="_blank" href="<?php echo $this->createUrl('/request/edit/' . $request->id);?>"><?php echo $request->title?></a>
                                            <?php endif;?>
                                            
                                        </td>
                                        <td>
                                            <?php if ($request->status == 1):?>
                                                <a href="#" onclick="javascript:undo('<?php echo $request->id?>')">撤销</a>
                                            <?php endif;?>
                                        </td>
				</tr>
			<?php }?>
			</tbody>
                        
                    <?php }?>
		</table>
		<?php
            $this->widget('CLinkPager', array(
                'pages'=>$pager,
                'header'=>false,
                'selectedPageCssClass' => 'active',
                'maxButtonCount'=>5,
            ));
        ?>
	</div>
	<!-- 搜索end -->
</div>

<script type="text/javascript">
    function undo(id){
        if (confirm('确定撤销该流程吗 ?')){
            $.post('<?php echo $this->createUrl('/ajax/request/undo');?>', {id:id}, function(rs){    
                if (rs.code == 0){
                    window.location.reload(); 
                }else{
                    alert(rs.msg);                      
                }                
            }, 'json');
            return false;
        }
        
    }
</script>    