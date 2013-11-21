				<!---工时填写栏-->
					<div class="quick_point ">
						<h3>快速点到</h3>
						<div class="quick_image">
							<div class="nav_text">
								<span>9:00 </span>
								<span>AM </span>
								<span>12:00 </span>
								<span>PM </span>
								<span>17:00 </span>
								<span>加班</span>
								<span>21:00 </span>
							</div>
							<div >
								<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/elements//timeline.png" alt="时间条条" >
								<a  class="time_button" href="#">马上点到</a>
							</div>
							<div class="time_text">
								<span>已工作时间：4小时30分</span>
								<span>加班时间：0小时</span>
							</div>
							<div style="clear:both;float:none;"></div>
						</div>
					</div>
					<div>
						<a href="<?php echo $this->createUrl('site/index', array('section'=>2)); ?>" style="display:block;width:37px;height:39px;float:right;"><img class="rightgo" src="<?php echo Yii::app()->request->baseUrl; ?>/images/elements/right.png"></a>
						<a href="<?php echo $this->createUrl('site/index', array('section'=>1)); ?>" style="display:block;width:37px;height:39px;float:left;"><img class="leftgo" src="<?php echo Yii::app()->request->baseUrl; ?>/images/elements/left.png"></a>
						<div style="clear:both;float:none;"></div>
					</div>
					<div class="index-button-box" style="<?php if($section == 2){
						echo 'display:none;';
						} ?>
						">
						
						<h3>新建与申请</h3>
						<a href="#" class="index-common-button index-button-short index-button-skyblue	"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/bigicons//bignewwork.png" alt=""><span>新建项目</span></a>
						<a href="#" class="index-common-button index-button-short index-button-skyblue	"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/bigicons//bigmoneypen.png" alt=""><span>报销申请</span></a>
						<a href="#" class="index-common-button index-button-long index-button-skyblue"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/bigicons//bigtimepen.png" alt=""><span>工时填报</span></a>
						<a href="#" class="index-common-button index-button-short index-button-skyblue	"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/bigicons//biginews.png" alt=""><span>请假申请</span></a>
						<a href="#" class="index-common-button index-button-short index-button-skyblue	"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/bigicons//bigcup.png" alt=""><span>调休申请</span></a>
					</div>
					<div class="index-button-box">
						<h3>审批</h3>
						<a href="#" class="index-common-button index-button-long index-button-orange	"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/bigicons//bigtimehand.png" alt=""><span>工时与加班审批</span></a>
						<a href="#" class="index-common-button index-button-short index-button-orange	"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/bigicons//bigmews.png" alt=""><span>请假审批</span></a>
						<a href="#" class="index-common-button index-button-short index-button-orange"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/bigicons//bigcuphand.png" alt=""><span>调休审批</span></a>
						<a href="#" class="index-common-button index-button-long index-button-orange	"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/bigicons//bigmoneyhand.png" alt=""><span>报销审批</span></a>
					</div>

					<div class="index-button-box">
						<h3>统计</h3>
						<a href="#" class="index-common-button index-button-long index-button-lightgreen	"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/bigicons//bigclock.png" alt=""><span>工时、加班、请假、调休统计</span></a>
						<a href="#" class="index-common-button index-button-long index-button-lightgreen	"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/bigicons//bigworklist.png" alt=""><span>项目统计</span></a>
						<a href="#" class="index-common-button index-button-short index-button-lightgreen"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/bigicons//bigmoney.png" alt=""><span>报销统计</span></a>
						<a href="#" class="index-common-button index-button-short index-button-lightgreen	"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/bigicons//bigsporttime.png" alt=""><span>锻炼时间统计</span></a>
					</div>

					<div class="index-button-box" style="<?php if($section == 1){
						echo 'margin-right:0px;';
						} ?>">
						<h3>固定资产</h3>
						<a href="#" class="index-common-button index-button-short index-button-green	"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/bigicons//bigbuy.png" alt=""><span>资产购置</span></a>
						<a href="#" class="index-common-button index-button-short index-button-green	"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/bigicons//biglist.png" alt=""><span>借用记录</span></a>
						<a href="#" class="index-common-button index-button-long index-button-green"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/bigicons//bighandborrow.png" alt=""><span>借用与归还</span></a>
					</div>
					<div class="index-button-box" style="margin-right:0px;<?php if($section == 1){
						echo 'display:none;';
						} ?>">
						<h3>个人事务</h3>
						<a href="#" class="index-common-button index-button-short index-button-red	"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/bigicons//bigtime.png" alt=""><span>我的工时</span></a>
						<a href="#" class="index-common-button index-button-short index-button-red	"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/bigicons//bigsporttime.png" alt=""><span>锻炼时间</span></a>
						<a href="#" class="index-common-button index-button-long index-button-red"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/bigicons//bigwork.png" alt=""><span>我参与的项目</span></a>
						<a href="#" class="index-common-button index-button-long index-button-red"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/bigicons//bignews.png"><span>我的通知</span></a>
					</div>