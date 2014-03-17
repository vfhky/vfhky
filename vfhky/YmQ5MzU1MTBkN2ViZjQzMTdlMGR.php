<?php
	if (empty($_SERVER['HTTP_REFERER']) || strpos($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST']) === false) {
		exit;
	}
	$request_urls = trim($_GET['GhpcyBpcy94db71979d35aBhIGV4YW1wbGUd7ebf4317e0de919']);	
	if(!filter_var($request_urls, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
		exit;
	}
	$ip=explode('.',$request_urls);  
	for($i=0;$i<count($ip);$i++)  
	{
		if($ip[$i]>255){  
			exit;
		}
	}	
	$request_urls = trim($request_urls);
	$post_urls = 'http://ip.taobao.com/service/getIpInfo.php?ip='.$request_urls;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $post_urls);
	curl_setopt($ch, CURLOPT_HEADER, FALSE);
	curl_setopt($ch, CURLOPT_POST,FALSE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_TIMEOUT, 15);
	$strRes = curl_exec($ch);
	curl_close($ch);
	echo $strRes ;
?>
