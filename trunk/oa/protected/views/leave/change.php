					<!--中间录入部分-->
					<div class="substance">
						<!--左侧录入-->
						<div></div>
						<div class="leftside" >
							<a href="#">
								<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/elements/left_blue.png">
							</a>
							<a class="tittle3" href="#">新建与申请</a>
							<form action="#" method="POST"> 
								<p>创建日期：<?php echo date('Y-m-d'); ?></p>
								<span >可调休时长：<?php echo intval(Leave::getAvailHour(Yii::app()->user->id)/3600); ?>小时</span>
  								</br>
  								<input type="hidden" name="LeaveForm[type]" value="change"/>
  								<label>调休时长:</label>
  								<input class="inputlist2" type="text" name="LeaveForm[total]"/>
  								</br>
  								<label>调休日期:</label>
  								<input id="start_time" class="projectName datepicker" name="LeaveForm[start_time]" type="text" placeholder="起"/>
  								<input id="end_time" class="projectName datepicker" name="LeaveForm[end_time]" style="margin-left:100px" placeholder="止" type="text"/>
  								</br>
  								<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/elements/heart.png">
  								<a href="#">温馨提示：加班超过4小时可调休半天</a>
  								<button class="submit_button" type="submit">提交</button>	
							</form>
						</div>
						<!--右侧选择-->
						<div class="rightside" class="rightside_xinjianyushenqing">
							<h3>调休申请</h3>
							<div class="menu">
								<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/elements/arrow_left.png">
								<a href="#">调休申请</a>
							</div>
						</div>
						<div style="clear:both;float:none"></div>
					</div>
                    <script type="text/javascript">
                        $(document).ready(function(){
                           $('input.datepicker').datepicker();
                        });
                    </script>