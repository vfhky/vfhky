<?php
	if (empty($_SERVER['HTTP_REFERER']) || strpos($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST']) === false) {
    header("Location: http://www.huangkeye.cn");
    exit;
	}
	$online_log = "dmZoa3lpcGRpc3BsYXk";
	$timeout = 120; 
	$user_arr = @file_get_contents($online_log);
	$user_arr = explode("#",rtrim($user_arr,"#"));
	$temp = array();
	foreach($user_arr as $value){
		$user = explode(",", trim($value));
		if (($user[0] != getenv("REMOTE_ADDR")) && ($user[1] > time())){
			array_push($temp, $user[0].",".$user[1]);
			$user_arr = implode("#",$temp);
		}
	}
	array_push($temp,getenv("REMOTE_ADDR").",".(time()+$timeout)."#");
	$user_arr = implode("#",$temp);
	$fp = fopen($online_log,"w");//更新文件
	flock($fp, LOCK_EX);  //锁定文件句柄
	@fputs($fp,$user_arr);
	flock($fp, LOCK_UN);//释放锁定
	@fclose();
	echo count($temp);
?>