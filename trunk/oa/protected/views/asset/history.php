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
	  								<input id="radio_two" type="radio" name="one" value="未归还" />
	  								<label for="radio_two">未归还</label>
	  								<input id="radio_two" type="radio" name="one" value="已归还" />
	  								<label for="radio_two">已归还</label>
	  							</div>
								
							</div>
							
							<p>单位：小时</p>	
							<!--按人统计-->
							<table>
								<th>编号</th>
								<th>名称</th>
								<th>价格</th>
								<th>借用人</th>
								<th>借出时间</th>
								<th>归还时间</th>
								</tr>
								<td>DJFIo38</td>
								<td>物品名称</td>
								<td>450.00</td>
								<td>王磊</td>
								<td>2013/07/10</td>
								<td>2013/07/15</td>
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
						<div style="clear:both;float:None"></div>
					</div>