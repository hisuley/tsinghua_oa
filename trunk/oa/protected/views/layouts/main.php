<?php /* @var $this Controller */ ?>
<!DOCTYPE html  PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="zh_CN" lang="zh_CN">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="zh-CN" />
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css" />

	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-1.8.0.min.js"></script>
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-ui-timepicker-addon.js"></script>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
    <link rel='stylesheet' type='text/css' href='<?php echo Yii::app()->request->baseUrl; ?>/fullcalendar/fullcalendar.css' />
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/main.js"></script>
    <script type='text/javascript' src='<?php echo Yii::app()->request->baseUrl; ?>/fullcalendar/fullcalendar.js'></script>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/calendar-eightysix-v1.1-default.css" />
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
				<a href="<?php echo $this->createUrl('user/notify'); ?>">
					<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/elements/news.png" align ="left" ><?php
                    $unreadCount = Notify::getUnreadCount(Yii::app()->user->id);
                     if( $unreadCount > 0){
                         echo "您有".$unreadCount."条新通知";
                     }else{
                         echo "暂无新通知";
                     } ?>
                    </a>
			</div>
			<div id="title">
				<h1><a href="<?php echo Yii::app()->request->baseUrl; ?>" style="font-size: 36px;color: #02d1b1;letter-spacing: 3;text-decoration:none;h">清华同衡·住区中心</a></h1>
			</div>
			<div id="menu">
				<a href="#" onclick="openMenu();">系统菜单
					<img id="down" src="<?php echo Yii::app()->request->baseUrl; ?>/images/elements/down.png"></a>
					<div>
						<ul id="systemMenu">
							<li>工时与休假
								<ul>									
									<li class="time"><a href="<?php echo $this->createUrl('manhour/out'); ?>">外出记录</a></li>
									<li class="home"><a href="<?php echo $this->createUrl('leave/new'); ?>">请假申请</a></li>
									<li class="lay"><a href="<?php echo $this->createUrl('leave/change'); ?>">调休申请</a></li>
									<li class="time"><a href="<?php echo $this->createUrl('leave/list', array('type'=>Leave::TYPE_NORMAL, 'action'=>'history')); ?>">请假记录</a></li>
									<li class="time"><a href="<?php echo $this->createUrl('leave/list', array('type'=>Leave::TYPE_CHANGE, 'action'=>'history')); ?>">调休记录</a></li>
								</ul>
							</li>
							<li>项目与财务
								<ul>
									<li class="zborrow"><a href="<?php echo $this->createUrl('project/new'); ?>">新建项目</a></li>
									<li class="lay"><a href="<?php echo $this->createUrl('project/list'); ?>">项目列表</a></li>
									<li class="money"><a href="<?php echo $this->createUrl('finance/reimbursement'); ?>">报销申请</a></li>
									<li class="money"><a href="<?php echo $this->createUrl('finance/reimbursementhistory'); ?>">报销记录</a></li>
								</ul>
							</li>
							<li>审批
								<ul>
									<li class="stime"><a href="<?php echo $this->createUrl('manhour/list', array('type'=>'all', 'action'=>'review')); ?>">工时审批</a></li>
									<li class="ssports"><a href="<?php echo $this->createUrl('leave/list', array('type'=>Leave::TYPE_NORMAL, 'action'=>'review')); ?>">请假审批</a></li>
									<li class="swork"><a href="<?php echo $this->createUrl('leave/list', array('type'=>Leave::TYPE_CHANGE, 'action'=>'review')); ?>">调休审批</a></li>
									<li class="snews"><a href="<?php echo $this->createUrl('finace/reimbursementlist'); ?>">报销审批</a></li>
								</ul>
							</li>
							<li>固定资产
								<ul>
									<li class="zmoney"><a href="<?php echo $this->createUrl('asset/new'); ?>">新增资产</a></li>
									<li class="zborrow"><a href="<?php echo $this->createUrl('asset/history'); ?>">借用记录</a></li>
									<li class="zretron"><a href="<?php echo $this->createUrl('asset/list'); ?>">借用与归还</a></li>
								</ul>
							<li >个人事务
									<ul>
										<li class="mytime"><a href="<?php echo $this->createUrl('user/mymanhour'); ?>">我的工时</a></li>
										<li class="mysports"><a href="<?php echo $this->createUrl('user/exercise'); ?>">我的锻炼时间</a></li>
										<li class="mywork"><a href="<?php echo $this->createUrl('user/project'); ?>">我参与的项目</a></li>
										<li class="mynews"><a href="<?php echo $this->createUrl('user/notify'); ?>">我的通知</a></li>
									</ul>
								</li>
							</li>
						</ul> 
					</div>
				</div>
				<div class="setup">
					<div class="left">
						<a href="#" ><?php echo isset(Yii::app()->user->realname)? Yii::app()->user->realname : Yii::app()->user->name; ?></a>
						<br />

						<?php 
						
						if(!(Yii::app()->user->isGuest)){
							$role = Yii::app()->user->role;
							echo User::translateRole($role);
						}
						
						?>

					</div>
					<div class="right">
						<a href="<?php echo $this->createUrl('site/logout');?>"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/elements/logout.png" ></a>
                        <a href="<?php echo $this->createUrl('site/userlist');?>"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/elements/user.png" ></a>
					</div>	
				</div>
			</div><!--头部结束-->
			<!--- 内容页面 -->
			<div id="content_wrapper">
				<div id="content">
					<!-- 用户消息 -->
					<?php if(Yii::app()->user->hasFlash('success')){ ?>
						<div class="flash-message success-message">
						 <p><?php echo Yii::app()->user->getFlash('success'); ?></p>
						</div>
					<?php } ?>
					<?php if(Yii::app()->user->hasFlash('failure')){ ?>
						<div class="flash-message failure-message">
						  <p><?php echo Yii::app()->user->getFlash('failure'); ?></p>
						</div>
					<?php } ?>
					<?php echo $content; ?>
					<div style="clear:both;float:none;height:30px;"></div>
				</div>
			</div>

			<!--个人工时显示-->
			
		</div>
		<div class="mytimes_bg">
			<p><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/elements/pmytime.png" >我的工时/小时：总计 120，工时80，请假5，调休5，加班30</p>
		</div>
		<div class="footer_bg">
			<div class="copyright">
					<p>&copy2013 Tsinghua TongHeng institute</p>
				</div>
		</div>
	</body>
</html>