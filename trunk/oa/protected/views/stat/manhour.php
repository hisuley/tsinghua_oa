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
								<form class="filters-form" action="<?php echo $this->createUrl('stat/manhour'); ?>" method="GET">
									<input type="hidden" name="r" value="stat/manhour">
									<div class="input-inline input-select">
										<label>项目：</label>
										<select name="filters[project]">
											<option value="">全部</option>
											<?php 
											$projectList = Project::getProjectList(Yii::app()->user->role, Yii::app()->user->id);
											foreach($projectList as $project){
												echo "<option value='".$project->id."'";
												echo !empty($filters['project']) ? (($project->id == $filters['project']) ? ' selected = "selected"' : '') : '';
												echo ">".$project->name."</option>";
											}
											?>
										</select>
									</div>
									<div class="input-inline input-text">
										<label>起始时间</label>
										<input type="text" class="datepicker inputlist3" name="filters[start_time]" value="<?php echo empty($filters['start_time']) ?  '' : $filters['start_time']; ?>">
										<input type="text" class="datepicker inputlist3" name="filters[end_time]" value="<?php echo empty($filters['end_time']) ?  '' : $filters['end_time']; ?>">
									</div>
									<input type="submit" class="button" value="搜索">
		  						</form>
								
							</div>
							
							<p>单位：小时</p>	
							<!--按人统计-->
							<table class="pretty" cellspacing="0">
								<tbody>
									<tr>
										<th>项目名称</th>
										<th>填报时间</th>
										<th>姓名</th>
										<th>工时</th>
										<th>加班</th>
									</tr>
									<?php foreach($result as $item){ 
										$manhour = Manhour::calculateManhour($item);
										echo "<tr>";
										echo "<td>".Project::getProjectOfUserString($item->user_id)."</td>";
										echo "<td>".date('Y-m-d H:i:s', $item->create_time)."</td>";
										echo "<td>";
										echo User::getUserRealname($item->user_id);
										echo "</td><td>";
										echo Manhour::translateManhour($manhour['manhour']);
										echo "</td>";
										echo "<td>".Manhour::translateManhour($manhour['overtime'])."</td>";
										echo "</tr>";
									 } ?>
				
								</tbody>
							</table>
							<!--付款方式-->
						
    						</div>
						<!--右侧选择-->
						<div class="rightside rightside_tongji">
							<h3 style="text-align:center">工时 加班 请假 
							</br>调休统计</h3>
							<div class="menu">
								<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/elements/arrow_leftton.png">
								<a href="#">工时、加班统计</a>
							</div>
							<div class="menu">
								<a href="#">请假统计</a>
							</div>
							<div class="menu">
								<a href="#">调休统计</a>
							</div>
							<div class="menu">
								<a href="#">工时、加班、请假、调休统计</a>
							</div>
						</div>
						<div style="clear:both;float:none"></div>
					</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('input.datepicker').datepicker();
	});
</script>