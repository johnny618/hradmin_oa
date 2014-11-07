<?php
if ($tips) {
    echo '保存成功';
}
$form = $this->beginWidget('CActiveForm');
?>
<?php echo $form->errorSummary($model);?>
<div class="row">
    <?php echo $form->label($model,'name'); ?>
    <?php echo $form->textField($model,'name') ?>
</div>
<?php
$this->widget('ext.wdueditor.WDueditor',array(
        'model' => $model,
        'attribute' => 'content',
        'toolbars' =>array(
            'fullscreen', 'source', '|', 'undo', 'redo', '|',
            'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch','autotypeset','blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist','selectall', 'cleardoc', '|',
            'rowspacingtop', 'rowspacingbottom','lineheight','|',
            'customstyle', 'paragraph', 'fontfamily', 'fontsize', '|',
            'directionalityltr', 'directionalityrtl', 'indent', '|',
            'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|','touppercase','tolowercase','|',
            'link', 'unlink', 'anchor', '|', 'imagenone', 'imageleft', 'imageright','imagecenter', '|','highlightcode', '|',
            'horizontal','spechars','snapscreen', 'wordimage', '|',
            'inserttable', 'deletetable', 'insertparagraphbeforetable', 'insertrow', 'deleterow', 'insertcol', 'deletecol', 'mergecells', 'mergeright', 'mergedown', 'splittocells', 'splittorows', 'splittocols', '|','searchreplace'
        ),
        'width' =>'100%',
        'height' =>'300px',
));
?>
 <div class="row submit">
    <?php echo CHtml::submitButton('提交'); ?>
</div>

<?php $this->endWidget();?>