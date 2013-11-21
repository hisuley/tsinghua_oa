<!--中间录入部分-->
					<div class="substance">
						<!--左侧录入-->
						<div class="leftside" >
							<a href="#">
								<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/elements/left_orange.png">
							</a>
							<a class="tittle3" href="#">审批</a>
							
							<p>单位：天</p>	
							<!--按人统计-->
							<table>
								<thead>
									<tr>
										<th>申请人</th>
										<th>类型</th>
										<th>请假时长</th>
										<th>开始时间</th>
										<th>结束时间</th>
										<th>详情</th>
										<th>操作</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($result as $item){
										echo "<tr>";
										echo "<td>".User::getUserRealname($item->user_id)."</td>";
										echo "<td>".$item->type."</td>";
										echo "<td>".Leave::getTimeLength($item->end_time, $item->start_time)."</td>";
										echo "<td>".date('Y-m-d H:i:s', $item->start_time)."</td>";
										echo "<td>".date('Y-m-d H:i:s', $item->end_time)."</td>";
										echo "<td>".$item->notes."</td>";
										echo "</tr>";
									}?>
								</tbody>
								
							</table>
						
  							<button class="submit_button button_orange" type="submit">提交</button>
  						</div>
						<!--右侧选择-->
						<div class="rightside rightside_shenpi">
							<h3 style="padding-left: 55px;">请假审批</h3>
							<div class="menu">
								<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/elements/arrow_leftshen.png">
								<a href="#">最新请假</a>
							</div>
							<div class="menu">
								<a href="#">全部请假</a>
							</div>
						</div>
						<div style="clear:both;float:none"></div>
					</div>