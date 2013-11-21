<!--中间录入部分-->
					<div class="substance">
						<!--左侧录入-->
						<div class="leftside" >
							<a href="#">
								<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/elements/left_green.png">
							</a>
							<a class="tittle3" href="#">固定资产</a>
							<!--下拉选择-->
							<div >
								<div class="radio-group anxiangmu check_down1">
	  								<input  id="radio_one" type="radio" name="one" value="全部" />
	  								<label for="radio_one">全部</label>
	  								<input id="radio_two" type="radio" name="one" value="未借出" />
	  								<label for="radio_two">未借出</label>
	  								<input id="radio_two" type="radio" name="one" value="已借出" />
	  								<label for="radio_two">已借出</label>
	  							</div>
								
							</div>
							
							<p>单位：小时</p>	
							<!--按人统计-->
							<table>
								<thead>
									<tr>
							
									<th>编号</th>
									<th>名称</th>
									<th>价格</th>
									<th>状态</th>
									<th>操作</th>
								</tr>
								</thead>
								<tbody>
									<?php if(!empty($result)){
										foreach($result as $asset){
											echo "<tr>";
											echo "<td>".$asset->sn."</td>";
											echo "<td>".$asset->name."</td>";
											echo "<td>".$asset->price."</td>";
											echo "<td>";
											switch($asset->status){
												case 'available':
													echo "可用";
													break;
												case 'unavailable':
													echo "已借出,借出人：";
													echo AssetHistory::getBorrower($asset->id);
													break;

											}
											echo "</td>";
											echo "<td>";
											switch($asset->status){
												case 'available':
													echo "<a href='".$this->createUrl('asset/borrow', array('id'=>$asset->id))."' >借出</a>";
													break;
												case 'unavailable':
													echo "<a href='".$this->createUrl('asset/back', array('id'=>$asset->id))."' >归还</a>";
													break;
											}
											echo "</td></tr>";

										}
									}
									?>
								</tbody>
								
							</table>
						
  							<button class="submit_button button_green" type="submit">提交</button>
  						</div>
						<!--右侧选择-->
						<div class="rightside rightside_zichan">
							<h3 style="padding-left: 40px;">固定资产</h3>
							<div class="menu">
								<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/elements/arrow_leftzichan.png">
								<a href="#">资产购置</a>
							</div>
							<div class="menu">
								<a href="#">借用与归还</a>
							</div>
							<div class="menu">
								<a href="#">借用记录</a>
							</div>
						</div>
						<div style="clear:both;float:none;"></div>
					</div>
					