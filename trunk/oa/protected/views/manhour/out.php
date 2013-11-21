<!--中间录入部分-->
					<div class="substance">
						<!--左侧录入-->
						<div></div>
						<div class="leftside" >
							<a href="#">
								<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/elements/left_blue.png">
							</a>
							<a class="tittle3" href="#">新建与申请</a>
							<form action="<?php echo $this->createUrl('manhour/out'); ?>" method="POST">
                                <?php echo !empty($result) ? "<input type='hidden' name='ManhourForm[id]' value='".$result->id."' />" : '';?>
								<p>创建日期：<?php echo date('Y/m/d');?></p>
  								</br>
  								<label>外出时间(小时):</label>
  								<input name="ManhourForm[end_time]" class="inputlist2" type="text" value="<?php echo !empty($result->end_time) ? ($result->end_time)/3600 : ''; ?>"/>
  								</br>

  								<label style="vertical-align: top;">外出事由:</label>
  								<textarea row="2" name="ManhourForm[notes]" class="longbox"  ><?php echo !empty($result->notes) ? $result->notes : ''; ?></textarea>
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