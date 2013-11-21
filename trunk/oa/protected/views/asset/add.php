<!--中间录入部分-->
<div class="substance">
	<!--左侧录入-->
	<div></div>
	<div class="leftside" >
		<a href="#">
			<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/elements/left_green.png">
		</a>
		<a class="tittle3" href="#">系统首页</a>
		<form action="<?php echo $this->createUrl('asset/new');?>" method="POST"> 
			<p>创建日期：<?php echo date('Y-m-d'); ?></p>
		</br>
		<label>申请人:</label>
		<select name="AssetForm[user_id]">
			<?php
			$users = User::getUserList();
			foreach($users as $user){
				echo "<option value='".$user->id."'>".$user->realname."</option>";
			}
			?>
		</select>
	</br>
	<label>物品名称:</label>
	<input class="inputlist2" type="text" name="AssetForm[name]"/>
</br>
<label>内部编号:</label>
<input class="inputlist2" type="text" name="AssetForm[sn]"/>
</br>
<label>购物数量:</label>
<input class="inputlist2" type="text" name="AssetForm[amount]"/>
</br>
<label>预计价格:</label>
<input class="inputlist2" type="text" name="AssetForm[price]"/>
<button class="submit_button button_green" type="submit">提交</button>	
</form>
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
<div style="clear:both;float:none"></div>
</div>