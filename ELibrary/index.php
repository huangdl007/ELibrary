<?php
     //1.È·¶¨Ó¦ÓÃÃû³Æ APP
	 define('APP_NAME','App');
	 //2.È·¶¨Ó¦ÓÃÂ·¾¶
	 define('APP_PATH','./App/');
	 //3.¿ªÆôµ÷ÊÔÄ£Ê½
	 define('APP_DEBUG',true);
	 /* ÅäÖÃ·þÎñÆ÷»·¾³ */
	define('ENGINE_NAME','sae');	
	
//	define ( "GZIP_ENABLE", function_exists ( 'ob_gzhandler' ) );
//	ob_start ( GZIP_ENABLE ? 'ob_gzhandler' : null );
	 //4.Ó¦ÓÃºËÐÄÎÄ¼þ
	 require './ThinkPHP/ThinkPHP.php';
?>