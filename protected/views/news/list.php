<ul>
<?php foreach($topCategories as $category) { ?>
    <li><?php echo $category->name;?>&nbsp;&nbsp;<?php echo CHtml::link('添加子分类', $this->createUrl('/news/addsub/' . $category->id));?>&nbsp;&nbsp;<?php echo CHtml::link('删除分类', $this->createUrl('/news/del/' . $category->id))?></li>
    <?php if ($category->subCategories) {?>
        <ul>
        <?php foreach ($category->subCategories as $subCategory) {?>
            <li><?php echo $subCategory->name;?>&nbsp;&nbsp;<?php echo CHtml::link('添加新闻', $this->createUrl('/news/addnew/' . $subCategory->id));?>&nbsp;&nbsp;<?php echo CHtml::link('删除分类', $this->createUrl('/news/del/' . $subCategory->id));?></li>
        <?php }?>
        </ul>
    <?php }?>
<?php }?>
</ul>