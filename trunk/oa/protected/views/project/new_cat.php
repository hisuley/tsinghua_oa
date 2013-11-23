<div class="substance">
	<div class="leftside">
		<a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/elements/left_blue.png" alt=""></a>
		<a class="title3">新建项目分类</a>
		<form action="#">
			<input type="hidden" name="AttributeForm[attr_name]" value="<?php echo Attribute::ATTR_PROJECT_CAT; ?>">
			<label for="attr_value" class="xuhao">分类名称</label>
			<input type="text" name="AttributeForm[attr_value]" class="inputlist2">
			<button class="submit_button" type="submit">提交</button>
		</form>
		
	</div>
	<!--右侧选择-->
	<div class="rightside" class="rightside_xinjianyushenqing" style="height:1295px;">
		<h3>新建项目</h3>

		<div class="menu">
			<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/elements/arrow_left.png">
			<a href="#info" class="tab-switch">添加分类</a>
		</div>
		<div class="menu">
			<a href="#user" class="tab-switch">
				分类列表
			</a>
		</div>
	</div>
	<div style="clear:both;float:none;"></div>
</div>
