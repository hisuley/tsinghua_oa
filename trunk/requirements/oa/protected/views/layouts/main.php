<?php /* @var $this Controller */ ?>
<!DOCTYPE html  PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="zh_CN" lang="zh_CN">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="zh-CN" />
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css" />
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-1.10.2.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){

		});
		function openMenu(){
			$('#systemMenu').toggle();
						//$('#systemMenu').css('backgroundImage':'ddd.png');
			}
	</script>
</head>
<body>
	<div class="header_bg">
		<div class="header_tiaotiao"></div>
	</div><!--头部背景结束-->
	<div class="wrapper">
		<div class="header">
			<div id="notice">
				<a href="">
					<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/elements/news.png" align ="left" >您有新通知啦
				</a>
			</div>
			<div id="title">
				<h1>清华设计院OA系统</h1>
			</div>
			<div id="menu">
				<a href="#" onclick="openMenu();">系统菜单
					<img id="down" src="<?php echo Yii::app()->request->baseUrl; ?>/images/elements/down.png"></a>
					<div>
						<ul id="systemMenu">
							<li>新建与申请
								<ul>
									<li class="time"><a href="#">工时申报</a></li>
									<li class="money"><a href="#">报销申请</a></li>
									<li class="home"><a href="#">请假申请</a></li>
									<li class="lay"><a href="#">调休申请</a></li>
								</ul>
							</li>
							<li >审批
								<ul>
									<li class="stime"><a href="#">工时审批</a></li>
									<li class="ssports"><a href="#">请假审批</a></li>
									<li class="swork"><a href="#">调休审批</a></li>
									<li class="snews"><a href="#">报销审批</a></li>
								</ul>
							</li>
							<li>固定资产
								<ul>
									<li class="zmoney"><a href="#">资产购置</a></li>
									<li class="zborrow"><a href="#">借用记录</a></li>
									<li class="zretron"><a href="#">借用与归还</a></li>
								</ul>
								<li >个人事务
									<ul>
										<li class="mytime"><a href="#">我的工时</a></li>
										<li class="mysports"><a href="#">我的锻炼时间</a></li>
										<li class="mywork"><a href="#">我参与的项目</a></li>
										<li class="mynews"><a href="#">我的通知</a></li>
									</ul>
								</li>
							</li>
						</ul> 
					</div>
				</div>
				<div class="setup">
					<div class="left">用户名<br />职位名称</div>
					<div class="right">
						<a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/elements/user.png" ></a>
						<a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/elements/setup.png"></a>
					</div>	
				</div>
			</div><!--头部结束-->
			<!--- 内容页面 -->
			<div id="content_wrapper">
				<div id="content">
					<?php echo $content; ?>
					<div style="clear:both;float:none;height:30px;"></div>
				</div>
			</div>

			<!--个人工时显示-->
			<div class="mytimes" style="<?php 
				if(Yii::app()->controller->action->id != 'index' || Yii::app()->controller->id != 'site'){
					echo 'display:none;';
				}
				?>
			">
				<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/elements/pmytime.png" >
				<p>我的工时/小时：总计 120，工时80，请假5，调休5，加班30</p>
			</div>
			<div class="footer">
				<div class="copyright">
					<p>&copy2013 Qinghua designing institute</p>
				</div>
			</div>
		</div>
		<div class="mytimes_bg"></div>
		<div class="footer_bg"></div>
	</body>
</html>