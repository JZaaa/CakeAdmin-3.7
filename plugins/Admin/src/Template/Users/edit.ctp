<div class="bjui-pageContent tablecomm">
    <form action="<?php echo $this->Url->build(['plugin' => $this->request->params['plugin'], 'controller' => 'Users', 'action' => 'edit', $data->id]);?>" class="pageForm" data-toggle="validate" data-reloadNavtab="ture" >
        <input type="hidden" name="id" value="<?php echo $data->id;?>">
        <table class="table table-condensed">
            <tbody>
            <tr>
                <td>
                    <label class="control-label x85">用&nbsp;&nbsp;户&nbsp;&nbsp;名：</label>
                    <input type="text" name="username" value="<?php echo h($data->username);?>" autocomplete="off" size="35" class="form-control input-nm" data-rule="required">
                    <span style="color:#ff0000;">*</span>
                </td>
            </tr>
            <tr>
                <td >
                    <label class="control-label x85">密&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;码：</label>
                    <input type="text" onfocus="this.type='password'" name="password" value="" autocomplete="off" size="35" class="form-control input-nm">
                </td>
            </tr>
            <tr>
                <td>
                    <label class="control-label x85">昵&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;称：</label>
                    <input type="text" name="nickname" value="<?php echo h($data->nickname);?>" size="35" class="form-control input-nm" >
                </td>
            </tr>
            <tr>
                <td>
                    <label for="name" class="control-label x85">状&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;态：</label>
                    <select name="state" data-toggle="selectpicker" data-width="350">
                        <?php
                        foreach($stateData as $key => $val) {
                            ?>
                            <option value="<?php echo $key;?>" <?php if($data->state == $key){echo "selected";}?>><?php echo $val;?></option>
                            <?php
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="name" class="control-label x85">管理员组：</label>
                    <select name="role_id" data-toggle="selectpicker" data-width="350">
                        <?php
                        foreach($roleData as $item) {
                            ?>
                            <option value="<?php echo $item->id;?>" <?php if($data->role_id == $item->id){echo "selected";}?>><?php echo h($item->name);?></option>
                            <?php
                        }
                        ?>
                    </select>
                </td>
            </tr>
            </tbody>
        </table>
    </form>
</div>
<div class="bjui-pageFooter">
    <ul>
        <li><button type="button" class="btn-close btn-no">关闭</button></li>
        <li><button type="submit" class="btn-blue">保存</button></li>
    </ul>
</div>