<?php
	if (empty($_SERVER['HTTP_REFERER']) || strpos($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST']) === false) {
		exit;
	}
	$c572bd935510d7ebf4317e0de91994db71979d35a = trim($_GET['GhpcyBpcy94db71979d35aBhIGV4YW1wbGUd7ebf4317e0de919']);	
	if(!filter_var($c572bd935510d7ebf4317e0de91994db71979d35a, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
		exit;
	}
	$ip=explode('.',$c572bd935510d7ebf4317e0de91994db71979d35a);  
	for($i=0;$i<count($ip);$i++)  
	{  
		if($ip[$i]>255){  
			exit;  
		}
	}	
	$c572bd935510d7ebf4317e0de91994db71979d35a = trim($c572bd935510d7ebf4317e0de91994db71979d35a);
	$url572bd935510d7ebf4317e0de91994db71979d35a = 'http://ip.taobao.com/service/getIpInfo.php?ip='.$c572bd935510d7ebf4317e0de91994db71979d35a; 
	$data = file_get_contents($url572bd935510d7ebf4317e0de91994db71979d35a); //调用淘宝接口获取信息 
	echo $data;
?>
