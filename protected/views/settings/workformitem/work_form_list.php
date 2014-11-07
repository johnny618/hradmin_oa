<div class="mywd"><!--我的文档 开始-->
		<div class="mywd_main">
			<div class="mywd_title"><span>我的文档</span></div>
			<div id="mywd_box" class="mywd_box">
				<div class="mywd_table">
					<div class="mywd_table_box">
						<table id="wywd" width="100%" cellpadding="0" cellspacing="0">
							<tr>
								<th width="28%"><h3>文档</h3></th>
								<th width="13%"><h3>所有者</h3></th>
								<th width="17%"><h3>创建日期</h3></th>
								<th width="18%"><h3>修改日期</h3></th>
								<th width="19%"><h3>操作</h3></th>
							</tr>
							<tr>
								<td><p><span>病假证明</span></p></td>
								<td><p>MAKI</p></td>
								<td><p>2014-05-01</p></td>
								<td><p>2014-05-01</p></td>
								<td><p><a href="#">编辑</a><a class="mywd_a" href="javascript:void(0)">删除</a></p></td>
							</tr>
							<tr>
								<td><p>上戏校招X展架</p></td>
								<td><p>MAKI</p></td>
								<td><p>2014-05-01</p></td>
								<td><p>2014-05-01</p></td>
								<td><p><a href="#">编辑</a><a class="mywd_a" href="javascript:void(0)">删除</a></p></td>
							</tr>
							<tr>
								<td><p>会议通知</p></td>
								<td><p>MAKI</p></td>
								<td><p>2014-05-01</p></td>
								<td><p>2014-05-01</p></td>
								<td><p><a href="#">编辑</a><a class="mywd_a" href="javascript:void(0)">删除</a></p></td>
							</tr>
						</table>
					</div>
				</div>
			</div>
			<div class="page"><!--翻页部分 开始--></div><!--翻页部分 结束-->
		</div>
	</div><!--我的文档 结束-->
<?php if (0) {?>

<ul>
<?php foreach ($WorkForms as $form) {?>
    <li>
    <?php
        echo $form->name;
        if ($form->items) {
            echo '<ul>';
            foreach ($form->items as $item) {
                echo '<li>' . $item->name . CHtml::link('编辑字段', $this->createUrl('settings/workformitem/edit/' . $item->id)) . '</li>';
            }
            echo '</ul>';
        }
    ?>
    </li>
<?php }?>
</ul>
<?php }?>