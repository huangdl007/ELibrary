<?php

function curl_get($url){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch,CURLOPT_HEADER,0);
  	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
  	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
  	$data=preg_replace('/\n|\r|<!--.*?-->/', "", curl_exec($ch));
  	//$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}