<!--中间录入部分-->
					<div class="substance">
						<!--左侧录入-->
						<div class="leftside" >
							<a href="#">
								<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/elements/left_lightgreen.png">
							</a>
							<a class="tittle3" href="#">统计</a>
							<!--下拉选择-->
							<div >
								<div class="check_down check_down1 check_down4">
								<a href="#" onclick="">2013/03 第二周<img id="down" src="<?php echo Yii::app()->request->baseUrl; ?>/images/elements/down.png"></a>
								</div>
							</div>
							<!--搜索框-->
							<div class="searchbox">
								<input type="text" class="text" id="key">
								<input type="submit" value="搜索" >
							</div>
							<p>单位：小时</p>	
							<table>
								<th>填报人</th>
								<th>填报时间</th>
								<th>锻炼时长</th>
								<th>锻炼内容</th>
								</tr>
								<td>某某</td>
								<td>2013/06/25</td>
								<td>2.5</td>
								<td>详细内容填写</td>
								</tr>
								<td>总计</td>
								<td>————</td>
								<td>30.5</td>
								<td>————</td>
							</table>
							<p>
								<a href="#"><上一周</a>
								<a href="#">下一周></a>
							</p>
  							
  						</div>
  					
						<!--右侧选择-->
						<div class="rightside rightside_tongji">
							<h3 style="text-align:center">锻炼时间统计</h3>
							<div class="menu">
								<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/elements/arrow_leftton.png">
								<a href="#">按周查看</a>
							</div>
						</div>
						<div style="clear:both;float:none"></div>
					</div>