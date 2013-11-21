<!--中间录入部分-->
					<div class="substance">
						<!--左侧录入-->
						<div class="leftside" >
							<a href="#">
								<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/elements/left_lightgreen.png">
							</a>
							<a class="tittle3" href="#">统计</a>
							<!--下拉选择-->

							<table>
								<tr>
									<th>编号</th>
									<th>负责人</th>
									<th>金额</th>
									<th>报销类型</th>
									<th>报销内容</th>
									<th>提交时间</th>
									<th>通过时间</th>
									<th>状态</th>
									<th>操作</th>
								</tr>
								<?php foreach($result as $item){
									echo "<tr>";
									echo "<td>".$item->id."</td>";
									echo "<td>".$item->username."</td>";
									echo "<td>".$item->price."</td>";
									echo "<td>".$item->type."</td>";
									echo "<td>".$item->item."</td>";
									echo "<td>".date('Y-m-d', $item->create_time)."</td>";
									echo "<td>".date('Y-m-d', $item->approve_time)."</td>";
									echo "<td>";
									switch($item->status){
										case 'cancelled':
											echo "取消";
											break;
										case 'approved':
											echo "通过";
											break;
										case 'reject':
											echo "拒绝";
											break;
										case "pending":
											echo "待审核";
											break;

									};
									echo "</td><td>";
									switch(Yii::app()->user->role){
										case 'admin':
											echo "<a href='".$this->createUrl('finance/reimbursementedit', array('id'=>$item->id))."'>编辑</a>";
											echo ($item->status == 'pending') ? "<a href='".$this->createUrl('finance/reimbursementreview', array('id'=>$item->id))."'>通过</a>" : '';
											break;
										case 'staff':
											echo "<a href='".$this->createUrl('finance/reimbursementedit', array('id'=>$item->id))."'>编辑</a>";
											break;
										case 'project-manager':
											echo ($item->status == 'pending') ? "<a href='".$this->createUrl('finance/reimbursementreview', array('id'=>$item->id))."'>通过</a>" : '';
											break;
										case 'manager':
											echo ($item->status == 'pending') ? "<a href='".$this->createUrl('finance/reimbursementreview', array('id'=>$item->id))."'>通过</a>" : '';
											break;
										case 'superintendent':
											echo ($item->status == 'pending') ? "<a href='".$this->createUrl('finance/reimbursementreview', array('id'=>$item->id))."'>通过</a>" : '';
											break;

									};
									echo "</td></tr>";

								}?>
								
							</table>
  							
  						</div>
  					

						<!--右侧选择-->
						<div class="rightside rightside_tongji">
							<h3 style="padding-left:50px"
							>报销申请统计</h3>
							<div class="menu">
								<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/elements/arrow_leftton.png">
								<a href="#">所有项目</a>
							</div>
							<div class="menu">
								<a href="#">我管理的项目</a>
							</div>
							<div class="menu">
								<a href="#">我参与的项目</a>
							</div>
							<img class="imgcheck" src="<?php echo Yii::app()->request->baseUrl; ?>/images/elements/checkedwhite_check.png">
							<span>已完成的项目</span>

						</div>
						<div style="clear:both;float:none"></div>

					</div>