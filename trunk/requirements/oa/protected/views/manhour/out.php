<!--中间录入部分-->
					<div class="substance">
						<!--左侧录入-->
						<div></div>
						<div class="leftside" >
							<a href="#">
								<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/elements/left_blue.png">
							</a>
							<a class="tittle3" href="#">新建与申请</a>
							<form> 
								<p>创建日期：<?php echo date('Y/m/d');?></p>
  								</br>
  								<label>外出时间:</label>
  								<input class="inputlist2" type="text"/>
  								</br>
  								<label style="vertical-align: top;">外出事由:</label>
  								<textarea row="2" class="longbox"></textarea>
  								</br> 
								<a href="#" id="plusli">
									<img class="tianjia" src="<?php echo Yii::app()->request->baseUrl; ?>/images/elements/plus.png" /></a>	
  								<button class="submit_button" type="submit">提交</button>	
							</form>
						</div>
						<!--右侧选择-->
						<div class="rightside" class="rightside_xinjianyushenqing">
							<h3>工时填报</h3>
							<div class="menu">
								<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/elements/arrow_left.png">
								<a href="#">考勤</a>
							</div>
							<div class="menu">
								<a href="#">外出登记</a>
							</div>
						</div>
						<div style="clear:both;float:none;"></div>
					</div>