<script type="text/javascript">
    $(document).ready(function(){
      $('div.radio-group>label').bind('click', function(){
        var inputId = $(this).prop('for');
        input$ = $('#'+inputId);
        input$.prop('checked', true);
        $(this).parent().find('label.checked').removeClass('checked');
        $(this).toggleClass('checked');

      });
      $('input.datepicker').datepicker();
    });
  </script>
<!--中间录入部分-->
					<div class="substance">
						<!--左侧录入-->
						<div></div>
						<div class="leftside" >
							<a href="#">
								<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/elements/left_blue.png">
							</a>
							<a class="tittle3" href="#">新建与申请</a>
							<form action="<?php echo $this->createUrl('leave/new'); ?>" method="POST"> 
								<p>创建日期：<?php echo date('Y-m-d'); ?></p>
  								</br>
  								<label>申请人:</label>
  								<input class="inputlist2" type="text"  value="<?php echo User::getUserRealname(Yii::app()->user->id); ?>" />
                                <input class="inputlist2" type="hidden" name="LeaveForm[user_id]" value="<?php echo Yii::app()->user->id; ?>" />
  								</br>
  								<label>类型:</label>
  								<div class="radio-group">

                                    <?php
                                        $subtypes = Leave::$subTypeIntl;
                                        foreach($subtypes as $key=>$value){
                                            echo '<input  id="radio_'.$key.'" type="radio" name="LeaveForm[sub_type]" value="'.$key.'" ';
                                            echo (!empty($result->sub_type) && $result->sub_type == $key) ? 'checked': '';
                                            echo '/>';
	  								        echo '<label for="radio_one"';
                                            echo (!empty($result->sub_type) && $result->sub_type == $key) ? 'class="checked"': '';
                                            echo '>'.$value.'</label>';
                                        }
                                    ?>

	  							</div>
  								</br>
  								<label>请假时间:</label>
  								<input id="start_time" class="projectName datepicker" name="LeaveForm[start_time]" placeholder="起" type="text"/>
  								<input id="end_time" class="projectName datepicker" name="LeaveForm[end_time]" style="margin-left:100px"  placeholder="止" type="text"/>
  								</br>
  								<label>请假时长:</label>
  								<input style="width:525px" type="text" name="LeaveForm[time]"/>
  								<label id="sky">天</label>
  								</br>
  								<label style="vertical-align: top;">详情:</label>
  								<textarea row="2" class="longbox" name="LeaveForm[notes]"></textarea>
  								</br>
  								<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/elements/heart.png">
  								<a href="#">温馨提示：请假1天以上需要提前两天以上填报申请</a>
  								<button class="submit_button" type="submit">提交</button>	
							</form>
						</div>
						<!--右侧选择-->
						<div class="rightside" class="rightside_xinjianyushenqing">
							<h3>请假申请</h3>
							<div class="menu">
								<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/elements/arrow_left.png">
								<a href="#">填写请假单</a>
							</div>
							<div class="menu">
								<a href="#">请假规定</a>
							</div>
						</div>
						<div style="clear:both;float:none"></div>
					</div>