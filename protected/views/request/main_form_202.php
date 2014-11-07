    <tr>
        <td><span class="qjia_span"><?php echo $item->field_name;?></span></td>
        <td class="qjia_bgcolor">
            <div class="qjia_td clearfix">
                <?php if ($can_edit) {?>
                    <lable class="fl">工號:</lable>
                    <input class="qjia_input2 fl" type="text" name="input_uid" value="" id="input_uid"/>
                    <lable class="fl">中文名:</lable>
                    <input class="qjia_input2 fl" type="text" name="input_uname" value="" id="input_uname"/>
                    <lable class="fl">郵箱地址:</lable>
                    <input class="qjia_input2 fl" type="text" name="input_mail" value="" id="input_mail"/>

                    <?php $mailgroup = API_OA::get_mail_list(); ?>
                    <lable class="fl">郵箱組:</lable>
                    <select id="select_mail_group" class="fl">
                        <?php foreach($mailgroup as $mailgroupVal):?>
                            <option value="<?php echo $mailgroupVal;?>" ><?php echo $mailgroupVal;?></option>
                        <?php endforeach;?>
                    </select>
                    <a href="#" id="c_mail" class="oa-btn">开通邮箱</a>
                <?php } else {?>
                    <lable class="fl">運維保密</lable>
                <?php }?>

            </div>

            <script type="text/javascript">

                $('#c_mail').click(function(){
                    if ('' == $('#input_uid').val()){
                        alert("工號不能爲空!");
                        r_mail = false;
                    }
                    if ('' == $('#input_uname').val()){
                        alert("中文名不能爲空!");
                        r_mail = false;
                    }
                    if ('' == $('#input_mail').val()){
                        alert("郵箱地址不能爲空!");
                        r_mail = false;
                    }

                    if (r_mail){
                        $.ajax({
                            type:'post',
                            url:ajaxurl,
                            data:{type:'openmail',uid:$('#input_uid').val(),uname:$('#input_uname').val(),email:$('#input_mail').val(),dept:$('#select_mail_group').val()},
                            dataType:"json",
                            async:false,
                            success:function(data){
                                if (data.code == 'success'){
                                    alert('郵箱開通成功');
                                }else{
                                    alert(data.info);
                                }
                            }
                        });
                    }

                });
            </script>
        </td>
    </tr>
