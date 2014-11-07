<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>css/set/set.css">
<style>
	body{ background-color: #fff;}
</style>
<div class="process">
<!-- 流程代理设置start -->
<h3 class="title">固定资产监控</h3>
<div class="pro-content">
    <form method="post">
        <table class="agent_set_table">
            <!--公司编号 电大编号 设备类型 设备品牌 设备型号 入库日期 配置 城市 地址 楼层 区域 保管人 状态 资产类型 工号-->
                <thead>
                        <tr>
                                <th>中心资产编号</th>
                                <td>
                                    <input type="text" name="cid" value="<?php echo !empty($params['cid']) ? $params['cid'] : ''?>" />
                                </td>
                                <th>电大编号</th>
                                <td>
                                    <input type="text" name="tuid" value="<?php echo !empty($params['tuid']) ? $params['tuid'] : ''?>" />
                                </td>
                                <th>设备类型</th>
                                <td><input type="text" name="type" value="<?php echo !empty($params['type']) ? $params['type'] : ''?>" /></td>
                                <th>设备品牌</th>
                                <td><input type="text" name="brand" value="<?php echo !empty($params['brand']) ? $params['brand'] : ''?>" /></td>
                                <th>设备型号</th>
                                <td><input type="text" name="model" value="<?php echo !empty($params['model']) ? $params['model'] : ''?>" /></td>
                        </tr>
                        <tr>
                                <th>入库日期</th>
                                <td>
                                    <input type="text" value="<?php echo !empty($params['storage_date']) ? $params['storage_date'] : ''?>"
                                       onclick="WdatePicker({dateFmt:'yyyy-MM-dd'})" name="storage_date" style="width:100px;"
                                       class="Wdate" readonly="readonly"/>                                    
                                </td>
                                <th>配置</th>
                                <td>
                                    <input type="text" name="config" value="<?php echo !empty($params['config']) ? $params['config'] : ''?>"  />
                                </td>
                                <th>城市</th>
                                <td><input type="text" name="city" value="<?php echo !empty($params['city']) ? $params['city'] : ''?>" /></td>
                                <th>地址</th>
                                <td><input type="text" name="address" value="<?php echo !empty($params['address']) ? $params['address'] : ''?>" /></td>
                                <th>楼层</th>
                                <td><input type="text" name="floor" value="<?php echo !empty($params['floor']) ? $params['floor'] : ''?>" /></td>
                        </tr>
                        <tr>
                                <th>区域</th>
                                <td>
                                    <input type="text" name="area" value="<?php echo !empty($params['area']) ? $params['area'] : ''?>" />
                                </td>
                                <th>保管人</th>
                                <td>
                                    <input type="text" name="owner" value="<?php echo !empty($params['owner']) ? $params['owner'] : ''?>" />
                                </td>
                                <th>状态</th>
                                <td><input type="text" name="status" value="<?php echo !empty($params['status']) ? $params['status'] : ''?>" /></td>
                                <th>资产类型</th>
                                <td><input type="text" name="asset_type" value="<?php echo !empty($params['asset_type']) ? $params['asset_type'] : ''?>" /></td>
                            <?php if($author):?>
                                <th>部門</th>
                                <td>
                                    <input type="text" name="dept" value="<?php echo !empty($params['dept']) ? $params['dept'] : ''?>" />
                                </td>
                            <?php endif;?>
                        </tr>

                        <tr>
                            <th></th>
                            <td>
                                <input type="submit" value="查 询">
                            </td>
                        </tr>
                </thead>
        </table>
    </form>
        <table class="agentTable">
                <!--<caption><strong>其他操作人代理状况</strong></caption>-->
                <thead>
                        <tr>
                                <th><p>中心资产编号</p></th>
                                <th><p>电大编号</p></th>
                                <th><p>设备类型</p></th>
                                <th><p>设备品牌</p></th>
                                <th><p>设备型号</p></th>
                                <th><p>入库日期</p></th>
                                <th><p>配置</p></th>
                                <th><p>城市</p></th>
                                <th><p>地址</p></th>
                                <th><p>楼层</p></th>
                                <th><p>区域</p></th>
                                <th><p>保管人</p></th>
                                <th><p>员工工号</p></th>
                                <th><p>部門</p></th>
                                <th><p>状态</p></th>
                                <th><p>资产类型</p></th>
        
                        </tr>
                        <tbody>
                            <?php foreach($dataAll as $value):?>
                                <tr>
                                    <td><?php echo $value['cid'];?></td>
                                    <td><?php echo $value['tuid'];?></td>
                                    <td><?php echo $value['type'];?></td>
                                    <td><?php echo $value['brand'];?></td>
                                    <td><?php echo $value['model'];?></td>
                                    <td><?php echo $value['storage_date'];?></td>
                                    <td><?php echo $value['config'];?></td>
                                    <td><?php echo $value['city'];?></td>
                                    <td><?php echo $value['address'];?></td>
                                    <td><?php echo $value['floor'];?></td>
                                    <td><?php echo $value['area'];?></td>
                                    <td><?php echo $value['owner'];?></td>
                                    <td><?php echo $value['eid'];?></td>
                                    <td><?php echo $value['dept'];?></td>
                                    <td><?php echo $value['status'];?></td>
                                    <td><?php echo $value['asset_type'];?></td>
                                </tr>
                            <?php endforeach;?>
                        </tbody>
                </thead>
        </table>
    
    
</div>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>js/My97DatePicker/WdatePicker.js"></script>