<?php
/**
 * Created by Kimi Tourism.
 * @author Suley<luzhang@jmlvyou.com>
 * @time 13-10-21
 * @version 1.0
 * @copyright 
 **/

?>

<!--中间录入部分-->
<script type="text/javascript">
    $(document).ready(function(){
        $('div.radio-group>label').bind('click', function () {
            var inputId = $(this).prop('for');
            input$ = $('#' + inputId);
            input$.prop('checked', true);
            var timesValue = parseInt(input$.val());
            console.log(timesValue);
            var i = 7;
            var j = 1;
            while (j <= timesValue) {
                var timesValueId = 'payment_times_value_' + j;
                var timesLabelId = 'payment_times_label_' + j;
                $('.' + timesLabelId).css("display", "inline-block");
                $('#' + timesValueId).css("display", "inline-block");
                j++;
            }
            while (i > timesValue) {
                var timesValueId = 'payment_times_value_' + i;
                var timesLabelId = 'payment_times_label_' + i;
                $('.' + timesLabelId).css("display", "none");
                $('#' + timesValueId).css("display", "none");
                i--;
            }
            $(this).parent().find('label.checked').removeClass('checked');
            $(this).toggleClass('checked');

        });
        $('input[name="UserForm[username]"]').change(function(){
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('user/checkusername');?>',
                data: "username="+$(this).val(),
                success:function(e){
                    console.log(e);
                    if(e == 'taken'){
                        $('input[name="UserForm[username]"]').next().css("color", "red");
                        $('input[name="UserForm[username]"]').next().text('已经被使用');
                    }else{
                        $('input[name="UserForm[username]"]').next().css('color', 'green');
                        $('input[name="UserForm[username]"]').next().text('可以使用');
                    }
                    console.log($(this).next());
                }
            })
        });
    });
</script>
<div class="substance">
    <div class="leftside" style="width:1100px">
        <a href="<?php echo $this->createUrl('site/userlist'); ?>">
            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/elements/left_blue.png">
        </a>
        <a class="tittle3" href="<?php echo $this->createUrl('site/userlist'); ?>">账户管理</a>
        <form class="zhanghushezhi" method="POST">
            <div class="tittle2">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/elements/seticon.png">
                <h2 style="color:#02d1b1;display: inline-table;margin-top: -5px;"><?php echo (Yii::app()->controller->action->id == 'user') ? "新建账户" : "修改账户"; ?></h2>
            </div>
            <label class="xuhao" style="margin-left: 100px">用户名：</label>
            <input  class="inputlist2" type="text" name="UserForm[username]" value="<?php echo empty($result) ? '' : $result->username; ?>"/><span style="display:inline;"></span>
            </br>
            <label class="xuhao" style="margin-left: 100px">真实姓名：</label>
            <input  class="inputlist2" type="text" name="UserForm[realname]"  value="<?php echo empty($result) ? '' : $result->realname; ?>"/>
            </br>
            <label class="xuhao" style="margin-left: 100px">密码:</label>
            <input class="inputlist2" type="password" name="UserForm[password]" value=""/>
            </br>
            <label class="xuhao" style="margin-left: 100px">邮箱:</label>
            <input class="inputlist2" type="text" name="UserForm[email]" value="<?php echo empty($result) ? '' : $result->email; ?>"/>
            </br>
            <label class="xuhao" style="margin-left: 100px">角色:</label>
            <div class="radio-group">
                <input type="radio" value="superintendent" id="radio_cityplan"  name="UserForm[role]"  <?php echo (!empty($result) && $result->role == 'superintendent') ? 'checked' : ''; ?>/>
                <label for="radio_cityplan" <?php echo (!empty($result) && $result->role == 'superintendent') ? 'class="checked"' : ''; ?>>所长</label>
                <input type="radio" value="project-manager" name="UserForm[role]"  <?php echo (!empty($result) && $result->role == 'project-manager') ? 'checked' : ''; ?>/>
                <label <?php echo (!empty($result) && $result->role == 'project-manager') ? 'class="checked"' : ''; ?>>项目负责人</label>
                <input type="radio" value="admin" id="radio_cityplan" name="UserForm[role]" <?php echo (!empty($result) && $result->role == 'admin') ? 'checked' : ''; ?>/>
                <label for="radio_cityplan" <?php echo (!empty($result) && $result->role == 'admin') ? 'class="checked"' : ''; ?>>管理员</label>
                <input type="radio" value="staff" name="UserForm[role]"  <?php echo empty($result) ? 'checked' : (($result->role == 'staff') ? 'checked' : ''); ?>/>
                <label   <?php echo empty($result) ? 'class="checked"' : (($result->role == 'staff') ? 'class="checked"' : ''); ?>>普通员工</label>
            </div>
            </br>
            <button class="submit_button" type="submit">提交</button>

        </form>
</div>