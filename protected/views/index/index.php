<?php
    echo CHtml::linkButton('新建流程大类', array('url' => 'settings/workflow/AddWorkType'));
    echo CHtml::linkButton('新建表单', array('url' => 'settings/workform/AddForm'));
    echo CHtml::linkButton('管理表单', array('url' => 'settings/workformitem'));
    echo CHtml::linkButton('新建流程', array('url' => 'settings/workformrequest'));
?>