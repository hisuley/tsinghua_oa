<!--中间录入部分-->
					<div class="substance">
						<!--左侧录入-->
						<div></div>
						<div class="leftside" >
							<a href="#">
								<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/elements/left_blue.png">
							</a>
							<a class="tittle3" href="#">新建与申请</a>
							<form action="<?php echo $this->createUrl('manhour/edit', array('id'=>$result->id)); ?>" method="POST"> 
					
  								</br>
  								<label>签到时间:</label>
  								<input name="ManhourForm[start_time]" class="inputlist2 datetimepicker" type="text" value="<?php echo date('Y-m-d H:i', $result->start_time); ?>"/>
  								</br>
  								<label>签出时间:</label>
  								<input name="ManhourForm[end_time]" class="inputlist2 datetimepicker" type="text" value="<?php echo date('Y-m-d H:i', $result->end_time); ?>"/>
  								</br>
  								
  								<button class="submit_button" type="submit">提交</button>	
							</form>
						</div>
						<!--右侧选择-->
						<div class="rightside" class="rightside_xinjianyushenqing">
							<h3>工时填报</h3>
							<div class="menu">
								<a href="#">考勤</a>
							</div>
							<div class="menu">
								<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/elements/arrow_left.png">
								<a href="#">外出登记</a>
							</div>
						</div>
						<div style="clear:both;float:none;"></div>
					</div>

					<script type="text/javascript">
						$(document).ready(function(){
							$('input.datetimepicker').datetimepicker();
								
						});
					</script>
					<style>
						div.ui-timepicker-div{
							font-size:1em;
						}
					</style>