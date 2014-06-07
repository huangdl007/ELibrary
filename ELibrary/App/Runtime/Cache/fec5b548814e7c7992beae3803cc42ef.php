<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no" />
<link rel="stylesheet" type="text/css" href="__PUBLIC__/css/index.css" />
	<title>E-LIBRARY 搜索结果</title>
</head>
<body style="background: url(__PUBLIC__/image/back.png) repeat">
<div>
	<?php if(is_array($booklist)): foreach($booklist as $key=>$book): ?><div class="book">
		<p class="bookpic"><img src="<?php echo ($book["cover"]); ?>" /></p>
		<div class="info">
		<p class="bookinf"><a href="__ROOT__/index.php/Index/search?url=<?php echo ($book["bookurl"]); ?>"><?php echo ($book["title"]); ?></a></p>
		<p class="bookinf">作者：<?php echo ($book["author"]); ?></p>
		<p class="bookinf">索书号：<?php echo ($book["number"]); ?></p>
		<p class="bookinf">出版社：<?php echo ($book["publish"]); ?></p>
		<p class="bookinf">时间：<?php echo ($book["time"]); ?></p>
		</div> 
		<div class="clear"></div>
	    </div><?php endforeach; endif; ?>
</div>
</body>
</html>