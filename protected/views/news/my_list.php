<table>
    <tr>
        <th>标题</th>
        <th>操作</th>
    </tr>
    <?php foreach ($newsInfos as $info) {?>
    <tr>
        <td><?php echo CHtml::link($info->name, $this->createUrl('/news/view/' . $info->id), array('target' => '_blank'));?></td>
        <td><?php echo CHtml::link('编辑', $this->createUrl('/news/editnew/' . $info->id), array('target' => '_blank'));?>&nbsp;&nbsp;<?php echo CHtml::link('删除', $this->createUrl('/news/delnew/' . $info->id));?></td>
    </tr>
    <?php }?>
</table>