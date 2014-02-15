<!DOCTYPE html>
<html dir="ltr" lang="zh-CN" style="-webkit-text-size-adjust:none;">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<?php 
  require_once("vfhky.QC.class.php");
	$qqauth = new vfhky_QC_class();
	
	
	/**1
	* get_user_info
	* 获得QQ空间资料
	* http://wiki.open.qq.com/wiki/website/get_user_info
	*/	
  /*	$get_user_info = $qqauth->get_user_info();
	// show result
	if($get_user_info->ret == 0){
		echo "<img src=". $get_user_info->figureurl_qq_1 . "> 昵称：" . $get_user_info->nickname ." 性别：".  $get_user_info->gender ." 黄钻等级：". $get_user_info->level ."<p><br/></p>";
  }
  else {
   	echo "1、失败<p><br/></p>";
  }
  
  /**2
	* get_info
	* 获得QQ微博资料
	* http://wiki.open.qq.com/wiki/website/get_info
	*/
  /*	$get_info = $qqauth->get_info();
	// show result
	if($get_info->ret == 0){
		$tag =  $get_info->data->tag ;		//个性标签
		$tweetinfo = $get_info->data->tweetinfo ;
		echo  "[生日：]". $get_info->data->birth_year . $get_info->data->birth_month . $get_info->data->birth_day . " [个人主页：]". $get_info->data->homepage  . " [所在地：]". $get_info->data->location  . " [标签：]". $tag[0]->name."、".$tag[1]->name  . " [微博来源：]". $tweetinfo[0]->from  . " [微博源内容：]". $tweetinfo[0]->origtext . " [微博内容]：". $tweetinfo[0]->text  . " [认证信息]：". $get_info->data->verifyinfo  . " [等级：]". $get_info->data->level  . " [微博名]：". $get_info->data->name  . " [微博昵称：]". $get_info->data->nick  . " [粉丝数：]". $get_info->data->fansnum  . " [收藏博文：]". $get_info->data->favnum."<p><br/></p>" ;
  }
  else {
   	echo "2、失败<p><br/></p>";
  }
  
  
	/**3
	* add_t
	* 发布QQ微博
	* http://wiki.open.qq.com/wiki/website/add_t
	*/
	/*	$random_num = rand(0,100);
  $add_t = $qqauth->add_t("#黄克业的博客# 腾讯API内测$random_num" , "112.82.178.93");
	// show result
	if($add_t->ret == 0){
		$id =  $add_t->data->id ;				//微博ID
		$time = $add_t->data->time ;		//微博时间
		echo "微博发送成功！该微博的ID是【" . $id . "】，发布时间：【" . $time . "】" ;	
	}
  else {
   	echo "3、失败<p><br/></p>";
  }  
  
  
	/**4
	* add_idol
	* 收听某人
	* http://wiki.open.qq.com/wiki/website/add_idol
	*/
	/*
	$add_idol = $qqauth->add_idol("bloghky");
	// show result
	if($add_idol->ret == 0){
		$msg =  $add_idol->data->msg ;					//提示信息
		$errcode = $add_idol->data->errcode ;		//二级错误码
		echo "尊敬的用户，您已成功关注《黄克业的博客》的作者:[<a href='http://t.qq.com/bloghky'>vfhky</a>]。" ;	
	}
  else {
   	echo "4、失败<p><br/></p>";
  }
  
  
	/**5
	* add_share
	* 分享到QQ空间
	* http://wiki.open.qq.com/wiki/website/add_share
	*/
	$random_num = rand(0,100);
	$title = "$random_num #黄克业的博客# 腾讯API内测中……";
	$url = "http://www.huangkeye.cn";
	$site = "黄克业的博客";
	$fromurl = "http://www.huangkeye.cn";
	$summary = "$random_num 黄克业的博客，一个专注于IT互联网技术的博客。目前正在进行#腾讯开放平台的API内部测试#";
	$comment = "$random_num 分享：黄克业的博客，一个专注于IT互联网技术的博客。";
	//$images = "http://www.huangkeye.cn/wp-content/uploads/2013/08/QQAPI_Oauth.png";
	
	$add_share = $qqauth->add_share($title, $url, $site, $fromurl, $comment, $summary, $images, $type=4, $playurl, $nswb=0);
	// show result
	$msg =  $add_share->data->msg ;					//提示信息
	$errcode = $add_share->data->ret ;		//返回码	
	if($add_share->data->ret == 0){

		echo "分享到QQ空间成功！" ;	
	}
  else {
   	echo $add_share->data->ret . $add_share->data->msg;
  }
  
?>
</body>
</html> 