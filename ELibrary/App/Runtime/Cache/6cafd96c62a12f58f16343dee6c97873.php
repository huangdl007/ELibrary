<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no" />
<link rel="stylesheet" type="text/css" href="__PUBLIC__/css/index.css" />
	<title>E-LIBRARY 书籍信息</title>
</head>

<body style="background: url(__PUBLIC__/image/back.png) repeat">
<div>
	<div class="book1">
		<div class="cover">
			<p><img src="<?php echo ($result['cover']); ?>" /></p>
		</div>
		<div class="info">
			<p class="bookinf">书名：<?php echo ($result['title']); ?></p>
			<p class="bookinf">作者：<?php echo ($result['author']); ?></p>
			<?php if(!empty($result['translator'])): ?><p class="bookinf">译者：<?php echo ($result['translator']); ?></p><?php endif; ?>
		</div>
		<div class="clear"></div>
	</div>

	<div id="bookstates">
		<?php if($result['isEast'] == 0): ?><p>抱歉，此藏书不在东校区图书馆！</p>
		<?php else: ?>
			<?php if(is_array($bookstate)): foreach($bookstate as $key=>$state): ?><div class="states">
					<p class="stateinf">状态：<?php echo ($state["state"]); ?></p>
					<p class="stateinf">归还日期：<?php echo ($state["returndate"]); ?></p>
					<p class="stateinf">校区：<?php echo ($state["library"]); ?></p>
					<p class="stateinf">楼层：<?php echo ($state["where"]); ?></p>
					<p class="stateinf">索书号：<?php echo ($state["bookshelf"]); ?></p>
				</div><?php endforeach; endif; endif; ?>
	</div>
</div>

</body>
</html>