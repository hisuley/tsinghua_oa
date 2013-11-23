<script type="text/javascript">
    $(document).ready(function () {
        $('#projectName').bind('click', function () {
            if ($('#projectName').val() == '请输入标题') {
                $('#projectName').val("");
            }

        });
        $('.inputName').blur(function () {
            var otherInput = $('.inputName').not($(this));
            otherInput.val($(this).val());
        });
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
        $(".input-datepicker").datepicker();
        $('div#user').delegate('div.user-item a.putaway','click', function(){
           $(this).parent().children('div.user-content').toggle();
            return false;
        });
        $('div#user').delegate('div.user-item a.delete', 'click', function(){
           $(this).parent().remove();
            return false;
        });
        $('div.user-add a').bind('click', function(){
           $(".input-datepicker").datepicker('destroy');
           var oldSize = $('div.user-item').size();
           $newUserItem = $('div.user-item').first().clone();
           $newUserItem.find('input').val(" ");
           $newUserItem.find('input').each(function(){
               var tempInputName = $(this).attr('name');
               tempInputName = tempInputName.replace(/ProjectUserForm\[\d+\]/, 'ProjectUserForm['+oldSize+']');
               $(this).attr('name', tempInputName);
               if($(this).hasClass('input-datepicker')){
                   $(this).attr('id', " ");
                   $(".input-datepicker").datepicker();
               }
           });

           $('div.user-item').last().after($newUserItem);
           return false;
        });
    });
</script>
<div class="substance">
<div class="leftside">
    <a href="#">
        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/elements/left_blue.png">
    </a>
    <a class="tittle3" href="#">新建与申请</a>

    <form action="#" method="POST">
        <div id="info" class="tab-content">
            <p>创建日期：<?php
                if (empty($result)) {
                    echo date('Y/m/d');

                } else {
                    echo date('Y-m-d', $result->create_time);
                } ?></p>
            </br>

            <input class="inputlist inputName" id="projectName" type="text" value="<?php
            if (isset($result)) {
                echo $result->name;
            } else {
                echo "请输入标题";
            }
            ?>">
            <label class="xuhao">序号：</label>
            <input class="inputlist2" type="text" value="<?php
            if (isset($result)) {
                echo $result->id;
            }
            ?>" disabled="disabled"/>
            </br>
            <label class="xuhao">项目类别:</label>

            <div class="radio-group">
                <input type="radio" name="ProjectForm[cat]" value="城市规划" id="radio_cityplan" <?php
                if (empty($result) || $result->cat == "城市规划") {
                    echo 'checked="checked"';
                }
                ?>/>
                <label for="radio_cityplan" class="<?php
                if (empty($result) || $result->cat == "城市规划") {
                    echo 'checked';
                }
                ?>">城市规划</label>
                <input type="radio" name="ProjectForm[cat]" value="详规" <?php
                if (!empty($result) && $result->cat == "详规") {
                    echo 'checked="checked"';
                }
                ?>/>
                <label class="<?php
                if (!empty($result) && $result->cat == "详规") {
                    echo 'checked"';
                }
                ?>">详规</label>

            </div>

            </br>
            <label class="xuhao">项目编号:</label>
            <input name="ProjectForm[sn]" class="inputlist2" type="text" value="<?php
            if (isset($result)) {
                echo $result->sn;
            }
            ?>"/>
            </br>
            <label class="xuhao">项目名称:</label>
            <input name="ProjectForm[name]" class="inputlist2 inputName" type="text" value="<?php
            if (isset($result)) {
                echo $result->name;
            }
            ?>"/>
            </br>
            <label class="xuhao">签订日期:</label>
            <input name="ProjectForm[sign_date]" class="inputlist2 input-datepicker" type="text" value="<?php
            if (isset($result)) {
                echo date('Y-m-d', $result->sign_date);
            }
            ?>"/>
            </br>
            <label class="xuhao">项目地点:</label>
            <input name="ProjectForm[location]" class="inputlist2" type="text" value="<?php
            if (isset($result)) {
                echo $result->location;
            }
            ?>"/>
            </br>
            <label class="xuhao">总额（万）:</label>
            <input name="ProjectForm[total_price]" class="inputlist2" type="text" value="<?php
            if (isset($result)) {
                echo $result->total_price;
            }
            ?>"/>
            </br>
            <label class="xuhao">合作我方实际合同额:</label>
            <input name="ProjectForm[real_contract_price]" class="inputlist2" type="text" value="<?php
            if (isset($result)) {
                echo $result->real_contract_price;
            }
            ?>"/>
            </br>
            <label class="xuhao">付款方式:</label>

            <div class="radio-group">
                <?php
                $i = 1;
                while ($i < 7) {
                    if (isset($result) && $result->payment_times == $i) {
                        $payment_times = "checked";
                    } else {
                        $payment_times = "";
                    }
                    echo '<input id="radio_' . $i . '" type="radio" name="ProjectForm[payment_times]" value="' . $i . '" checked="' . $payment_times . '" />';
                    echo '<label for="radio_' . $i . '" class="' . $payment_times . ' payment_times">' . $i . '次</label>';
                    $i++;
                }
                ?>
            </div>
            </br>
            <?php
            $i = 1;
            if (isset($result)) {
                $totalPaymentTimes = $result->payment_times;
            } else {
                $totalPaymentTimes = 7;
            }
            while ($i <= $totalPaymentTimes) {
                echo '<label class="xuhao payment_times_label_' . $i . '">' . $i . '次:</label>';
                switch ($i) {
                    case 1:
                        $dayString = 'first';
                        break;
                    case 2:
                        $dayString = 'second';
                        break;
                    case 3:
                        $dayString = 'third';
                        break;
                    case 4:
                        $dayString = 'fourth';
                        break;
                    case 5:
                        $dayString = 'fifth';
                        break;
                    case 6:
                        $dayString = 'sixth';
                        break;
                };
                $payString = $dayString . "_pay";
                $payValue = empty($result) ? '' : $result->$payString;
                echo '<input name="ProjectForm[' . $dayString . '_pay]" class="inputlist2 payment_times_value" id="payment_times_value_' . $i . '" type="text" value="' . $payValue . '"/></br>';
                $i++;
            }
            while ($i < 7) {
                echo '<label class="xuhao payment_times_label_' . $i . '" style="display:none;">' . $i . '次:</label>';
                switch ($i) {
                    case 1:
                        $dayString = 'first';
                        break;
                    case 2:
                        $dayString = 'second';
                        break;
                    case 3:
                        $dayString = 'third';
                        break;
                    case 4:
                        $dayString = 'fourth';
                        break;
                    case 5:
                        $dayString = 'fifth';
                        break;
                    case 6:
                        $dayString = 'sixth';
                        break;
                };
                echo '<input name="ProjectForm[' . $dayString . '_pay]" class="inputlist2 payment_times_value" style="display:none;" id="payment_times_value_' . $i . '" type="text" /></br>';
                $i++;
            }
            ?>
        </div>
        <div id="user" class="tab-content" style="display:none;">
            <h3 class="inputlist">人员分配</h3>
            <?php
            if(!empty($result->users)){
              $userCounter = 0;
              foreach($result->users as $user){
                  ?>
                  <div class="user-item">
                      <a class="putaway" href="#"><img src="./images/elements/jianhao_02.png">XXX分工此处填好后姓名同步</a>
                      <a href="#" class="delete">删除</a>
                      <div class="user-content">
                          <label class="xuhao">人员姓名:</label>
                          <select name="ProjectUserForm[<?php echo $user->id; ?>][user_id]">
                              <?php
                              $allUsers = User::model()->findAll();

                              foreach($allUsers as $singleUser){

                                  echo "<option value='".$singleUser->id."'";
                                  echo ($user->id == $singleUser->id) ? 'selected':'';
                                  echo ">$singleUser->username</option>";
                              }
                              ?>
                          </select>
                          <br />
                          <label class="xuhao">项目分工:</label>
                          <input class="inputlist2 inputlist3" name="ProjectUserForm[<?php echo $userCounter; ?>][role]" type="text" value="<?php echo $user->role; ?>">
                          <br />
                          <label class="xuhao">开始时间:</label>
                          <input class="inputlist2 inputlist3 input-datepicker" name="ProjectUserForm[<?php echo $userCounter; ?>][start_time]" type="text" value="<?php echo date('Y-m-d', $user->start_time); ?>">
                          <br />
                          <label class="xuhao">结束时间:</label>
                          <input class="inputlist2 inputlist3 input-datepicker" name="ProjectUserForm[<?php echo $userCounter; ?>][end_time]" type="text" value="<?php echo date('Y-m-d', $user->end_time); ?>">
                          <br />
                          <label class="xuhao">重要节点:</label>
                          <input class="inputlist2 inputlist3 input-datepicker" name="ProjectUserForm[<?php echo $userCounter; ?>][important]" type="text" value="<?php echo date('Y-m-d', $user->important); ?>">
                          <br />
                          <label class="xuhao">内容提醒:</label>
                          <input class="inputlist2 inputlist3" type="text" name="ProjectUserForm[<?php echo $userCounter; ?>][notice]" value="<?php echo $user->notice; ?>">
                          <br />
                          <label class="xuhao">备注:</label>
                          <input class="inputlist2 inputlist3" type="text" name="ProjectUserForm[<?php echo $userCounter; ?>][note]" value="<?php echo $user->note; ?>">
                          <br />
                      </div>
                  </div>
            <?
              $userCounter++;
              }
            }else{
            ?>
            <div class="user-item">
                <a class="putaway" href="#"><img src="./images/elements/jianhao_02.png">XXX分工此处填好后姓名同步</a>
                <a href="#" class="delete">删除</a>
                <div class="user-content">
                    <label class="xuhao">人员姓名:</label>
                    <select name="ProjectUserForm[0][user_id]">
                        <?php
                            $allUsers = User::model()->findAll();

                                foreach($allUsers as $user){
                                    echo "<option value='".$user->id."'>$user->username</option>";
                                }
                        ?>
                    </select>
                    <br />
                    <label class="xuhao">项目分工:</label>
                    <input class="inputlist2 inputlist3" name="ProjectUserForm[0][role]" type="text">
                    <br />
                    <label class="xuhao">开始时间:</label>
                    <input class="inputlist2 inputlist3 input-datepicker" name="ProjectUserForm[0][start_time]" type="text">
                    <br />
                    <label class="xuhao">结束时间:</label>
                    <input class="inputlist2 inputlist3 input-datepicker" name="ProjectUserForm[0][end_time]" type="text">
                    <br />
                    <label class="xuhao">重要节点:</label>
                    <input class="inputlist2 inputlist3 input-datepicker" name="ProjectUserForm[0][important]" type="text">
                    <br />
                    <label class="xuhao">内容提醒:</label>
                    <input class="inputlist2 inputlist3" type="text" name="ProjectUserForm[0][notice]">
                    <br />
                    <label class="xuhao">备注:</label>
                    <input class="inputlist2 inputlist3" type="text" name="ProjectUserForm[0][note]">
                    <br />
                </div>
            </div><?php }?>

            <div class="user-add">
                <a class="putaway" href="#"><img src="./images/elements/jiahao_02.png">添加</a>
            </div>
        </div>
        <button class="submit_button" type="submit">提交</button>
    </form>
</div>
<!--右侧选择-->
<div class="rightside" class="rightside_xinjianyushenqing" style="height:1295px;">
    <h3>新建项目</h3>

    <div class="menu">
        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/elements/arrow_left.png">
        <a href="#info" class="tab-switch">项目信息</a>
    </div>
    <div class="menu">
        <a href="#user" class="tab-switch">
            人员分配
        </a>
    </div>
    <img id="tanhao" src="<?php echo Yii::app()->request->baseUrl; ?>/images/elements/tanhao.png">

    <p>请先提交再创建新项目!</p>
</div>
<div style="clear:both;float:none;"></div>
</div>