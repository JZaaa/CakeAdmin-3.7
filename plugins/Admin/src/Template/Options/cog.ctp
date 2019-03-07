<div class="bjui-pageContent tablecomm tabnoboder">
    <form action="<?php echo $this->Url->build(['plugin' => $this->request->params['plugin'], 'controller' => 'Options', 'action' => 'cog']);?>" class="pageForm" data-toggle="validate" data-reloadNavtab="true" >
        <fieldset>
            <legend>用户设置</legend>
            <table class="table table-condensed">
                <tbody>
                <tr>
                    <td>
                        <label class="control-label x130">最大抽奖次数：</label>
                        <input type="text" name="lottery_num" class="form-control" data-toggle="spinner" value="<?php echo isset($data['lottery_num']) ? $data['lottery_num']['value'] : ''?>" placeholder="不设置或0则不限制" data-rule="integer(+0)">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="control-label x130">最大中奖次数：</label>
                        <input type="text" name="winning_num" class="form-control" data-toggle="spinner" value="<?php echo isset($data['winning_num']) ? $data['winning_num']['value'] : ''?>" placeholder="不设置或0则不限制" data-rule="integer(+0)">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="control-label x130">每日抽奖次数：</label>
                        <input type="text" name="day_num" class="form-control" data-toggle="spinner" value="<?php echo isset($data['day_num']) ? $data['day_num']['value'] : ''?>" placeholder="不设置或0则不限制" data-rule="integer(+0)">
                    </td>
                </tr>
                </tbody>
            </table>
        </fieldset>
        <fieldset>
            <legend>抽奖设置</legend>
            <table class="table table-condensed">
                <tbody>
                <tr>
                    <td>
                        <label class="control-label x130">活动状态：</label>
                        <input type="radio" name="activity_status" id="activity_status1" data-toggle="icheck" value="1" data-rule="checked" <?php if (isset($data['activity_status']) && $data['activity_status']['value'] == 1) {echo 'checked';}?> data-label="&nbsp;开启">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="activity_status" id="activity_status2" data-toggle="icheck" value="2" <?php if (!isset($data['activity_status']) || $data['activity_status']['value'] == 2) {echo 'checked';}?> data-label="&nbsp;关闭">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="control-label x130" required>答题数量：</label>
                        <input type="text" name="answer_num" class="form-control" data-toggle="spinner" value="<?php echo isset($data['answer_num']) ? $data['answer_num']['value'] : ''?>" data-rule="integer(+);required">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="control-label x130" required>中奖概率（%）：</label>
                        <input type="text" name="probability" class="form-control" data-toggle="spinner" value="<?php echo isset($data['probability']) ? $data['probability']['value'] : ''?>" data-rule="integer(+0);required">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="control-label x130" required>抽奖分数线：</label>
                        <input type="text" name="min_score" class="form-control" data-toggle="spinner" value="<?php echo isset($data['min_score']) ? $data['min_score']['value'] : ''?>" data-rule="integer(+0);required">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="control-label x130">抽奖介绍：</label>
                        <textarea placeholder="抽奖介绍"  class="form-control" name="activity_info" size="50%" rows="3"><?php echo isset($data['activity_info']) ? h($data['activity_info']['value']) : ''?></textarea>
                    </td>
                </tr>
                </tbody>
            </table>
        </fieldset>
    </form>
</div>
<div class="bjui-pageFooter">
    <ul>
        <li><button type="button" class="btn-close btn-no">关闭</button></li>
        <li><button type="submit" class="btn-blue">保存</button></li>
    </ul>
</div>
