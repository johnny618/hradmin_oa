
    <tr>
        <td><span class="qjia_span"><?php echo $item->field_name;?></span></td>
        <td class="qjia_bgcolor">
    <?php if ($can_edit) {?>
            <div class="qjia_td clearfix">
                <lable class="fl">工號:</lable>
                <input class="qjia_input2 fl" type="text" name="input_uid" value="" id="g_input_uid"/>
                <a href="#" id="get_power" class="oa-btn">查看網絡權限</a>
                <lable class="fl" id="powerhtml"></lable>
            </div>

            <div class="qjia_td clearfix">
                    <lable class="fl">工號:</lable>
                    <input class="qjia_input2 fl" type="text" name="input_uid" value="" id="input_uid"/>

                    <?php $mailgroup = API_OA::get_power_list(); ?>
                    <lable class="fl">網絡權限:</lable>
                    <select id="select_power_group" class="fl">
                        <?php foreach($mailgroup as $mailgroupVal):?>
                            <option value="<?php echo $mailgroupVal;?>" ><?php echo $mailgroupVal;?></option>
                        <?php endforeach;?>
                    </select>
                    <a href="#" id="c_power" class="oa-btn">开通網絡權限</a>

            </div>
            <div class="qjia_td clearfix">
                <lable class="fl">工號:</lable>
                <input class="qjia_input2 fl" type="text" name="input_uid" value="" id="d_input_uid"/>

                <lable class="fl">網絡權限:</lable>
                <select id="d_select_power_group" class="fl">
                    <?php foreach($mailgroup as $mailgroupVal):?>
                        <option value="<?php echo $mailgroupVal;?>" ><?php echo $mailgroupVal;?></option>
                    <?php endforeach;?>
                </select>
                <a href="#" id="d_power" class="oa-btn">刪除網絡權限</a>
            </div>
    <?php } else {?>
            <div class="qjia_td clearfix">
                <lable class="fl">運維保密</lable>
            </div>
    <?php }?>



            <script type="text/javascript">
                $('#get_power').click(function(){
                    if ('' != $('#g_input_uid').val()){
                        $.ajax({
                            type:'post',
                            url:ajaxurl,
                            data:{type:'getpower',uid:$('#g_input_uid').val()},
                            dataType:"json",
                            async:false,
                            success:function(data){
                                if (data.code == 'success'){
                                    $('#powerhtml').html(data.info.join(","));
                                }else{
                                    alert(data.info);
                                }
                            }
                        });
                    }
                });

                $('#c_power').click(function(){
                    if ('' == $('#input_uid').val()){
                        alert("工號不能爲空!");
                        r_power = false;
                    }

                    if (r_power){
                        $.ajax({
                            type:'post',
                            url:ajaxurl,
                            data:{type:'openpower',uid:$('#input_uid').val(),power:$('#select_power_group').val()},
                            dataType:"json",
                            async:false,
                            success:function(data){
                                if (data.code == 'success'){
                                    alert('網絡權限開通成功');
                                }else{
                                    alert(data.info);
                                }
                            }
                        });
                    }

                });

                $('#d_power').click(function(){
                    if ('' == $('#d_input_uid').val()){
                        alert("工號不能爲空!");
                        return false;
                    }

                    $.ajax({
                        type:'post',
                        url:ajaxurl,
                        data:{type:'deletepower',uid:$('#d_input_uid').val(),power:$('#d_select_power_group').val()},
                        dataType:"json",
                        async:false,
                        success:function(data){
                            if (data.code == 'success'){
                                alert('網絡權限刪除成功');
                            }else{
                                alert(data.info);
                            }
                        }
                    });

                });
            </script>
        </td>
    </tr>
