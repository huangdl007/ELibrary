<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no" />
<link rel="stylesheet" type="text/css" href="__PUBLIC__/css/index.css" />
	<title>E-LIBRARY 首页</title>
</head>

<body style="background: url(__PUBLIC__/image/back.png) repeat">
<div id="main">
	<div>
	<div id="pic"><img src="__PUBLIC__/image/Elibrary.png"></div>
	<form action="__ROOT__/index.php/Index/search" method="get">
		<div id="bookInput">
			<input name="bookname" type="text" required="required" placeholder="请输入书名"/>
			<input name="" type="submit" value="搜索" />
		</div>
	</form>
	</div>
	<div><button class="help">到处看看</button></div>
	<div><button class="help">图书馆平面图</button></div>
</div>

</body>
</html>