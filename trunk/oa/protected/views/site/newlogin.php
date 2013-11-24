<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="zh-CN" />
	<title>登陆</title>
	<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css" type="text/css">
</head>
<body id="bgimg">
	<div style="width:334px;height: 330px;background-color:#ffffff;position: absolute;top: 25%;left: 38%;border-radius: 5px;box-shadow: 0px 0px 5px #d2d2d2;">
		<div style="background-color:#3397d3;height:62px">
			<p style="font-size:18px;color:#ffffff;padding-top: 20px;width:205px">清华同衡·住区中心</p>
			<p style="font-size:12px;color:#ffffff;width:105px;margin-top: 28px">OA管理系统</p>
		</div>
		<div style="clear:both;float:none;"></div>
		<div style="padding-top:30px;padding-left:15px">
			<p style="font-size:26px;color:#ff3397d3;padding-bottom:20px ">用户登录</p>
			<p style="font-size:14px;color:#ff3397d3;margin-top: 14px ">Login</p>
			<div style="clear:both;float:none;"></div>
            <?php foreach(Yii::app()->user->flashes as $key=>$message){
                echo "<p class='message message-".$key."'>".$message."</p>";
            }
            ?>
			<form id="loginform" action="<?php echo $this->createUrl('site/login'); ?>" method="POST">
  				<input type="text" name="LoginForm[username]" onblur="if(this.value == ''){this.value='请输入您的用户名'}" onclick="if(this.value == '请输入您的用户名'){this.value = ''}" value="请输入您的用户名"/>
  				</br>
  				<input type="password" name="LoginForm[password]" value="">
  				<div style="margin-top:20px">
  					<button class="submit_loginbutton" type="submit">提交</button>
  					<a href="#">忘记密码？</a>
  				</div>
			</form>

		</div>
	</div>
<style type="text/css">
body#bgimg{
	background-image: url("<?php echo Yii::app()->request->baseUrl; ?>/images/elements/bg.png");
	filter:"progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod='scale')";
	-moz-background-size:100% 100%;
	background-size:100% 100%;
	letter-spacing: 1px;
}
body#bgimg>div>div>p{
	padding-left: 10px;
	float: left;
}
body#bgimg>div>div>form{
	padding-left: 10px;
}
body#bgimg>div>div>form>div>a{
	display: block;
	text-decoration: none;
	padding-left: 130px;
	margin-top: -20px;
	color:#c9c9c9;
	font-size: 14px;
}
body#bgimg>div>div>form>div>a:hover{
	color:#3397d3;
}
#loginform input{
	border-radius: 3px;
	display:block;
	margin-bottom:0px;
}
.submit_loginbutton{
	background-color:#c9c9c9 ;
	width: 116px;
	height: 32px;
	border-radius: 3px;
	border: 1px solid #c9c9c9;
	letter-spacing: 3px;
	font-size: 18px;
	color: #01212c;
	box-shadow: 0px 0px 1px #d2d2d2;
	display:block;
	margin-left: 5px
}
.submit_loginbutton:hover{
	background-color:#3397d3;
	color:#ffffff;
}
div.leftside>div.guiding{
	width:610px;
	height:318px;
	margin-top:40px;
	margin-left: 140px;
}
div.leftside>div.guiding>div{
	height:30px;
	padding-bottom: 20px;
	line-height: 24px;
}
div.leftside>div.guiding>div>p{
	text-align: left;
	margin-top: -20px;
	margin-left: 40px;
	font-size: 14px;
}
p.message{
    text-align: center;
    font-size:12px;
    margin-bottom:10px;
    width:100%;
    padding:0px;
}
p.message-failure{
    color:#fd0404;
}
p.message-success{
    color:#85c727;
}
</style>
</body>
</html>