<!--中间录入部分-->
					<div class="substance">
						<!--左侧录入-->
						<div class="leftside" >
							<div>
								<a href="#">
								<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/elements/left_orange.png">
								</a>
								<a class="tittle3" href="#">审批</a>
							</div>
							
							<!--下拉选择-->
							<table>
								<tr>
									<th>申请人</th>
									<th>调休时长</th>
									<th>开始时间</th>
									<th>结束时间</th>
									<th>操作</th>
									<th>不批准原因</th>
								</tr>
								<tr>
									<td>王丽</td>
									<td>24</td>
									<td>2013/05/12</td>
									<td>2013/05/13</td>
									<td>批准/不批准</td>		
									<td>详细原因</td>
								</tr>

							</table>
  							<button class="submit_button button_orange" type="submit">提交</button>
  						</div>
						<!--右侧选择-->
						<div class="rightside rightside_shenpi" >
							<h3 style="padding-left:50px"
							>调休审批</h3>
							<div class="menu">
								<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/elements/arrow_leftshen.png">
								<a href="#">最新调休申请</a>
							</div>
							<div class="menu">
								<a href="#">全部调休申请</a>
							</div>

						</div>
						<div style="clear:both;float:none"></div>
					</div>