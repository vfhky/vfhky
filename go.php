<?php if(empty($_SERVER['HTTP_REFERER']) || strpos($_SERVER['HTTP_REFERER'],$_SERVER['HTTP_HOST'])===false){header("Location: http://www.huangkeye.cn"); 
exit;} else {require_once('urlsafe.php');?>
<!DOCTYPE html>
<html dir="ltr" lang="zh-CN" style="-webkit-text-size-adjust:none;">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>访问安全提示 | 黄克业的博客</title>
	<link rel="shortcut icon" href="http://www.huangkeye.cn/wp-content/themes/vfhky/images/favicon.ico" />
    <style>
    /* common */
    td,input,button,select,body {font-family:"lucida Grande",Verdana;font-size:12px;}
    h1,h2,h3,h4,h5,h6 {font-size:12px; font-weight:normal; margin:0;}
    ul,li{list-style:none;}
    input,textarea,a {outline:none;}
    form,body,ul,li {margin:0;padding:0;}
    select,body,textarea {background:#fff;font-size:12px;}
    select {font-weight:normal; font-size:12px; font-family:Tahoma;line-height:20px;}
    textarea {width:540px;border:1px solid #718da6;padding:3px;font-family:"lucida Grande",Verdana;}
    img {border:none}
    a {text-decoration:none;cursor:pointer;outline:none;}
    a:hover {text-decoration:underline;}
    a,a:link,a:visited,li.fs a.fdleft:hover,li.fd_mg a.fdleft:hover {color:#1e5494;}
    a.btn_blue{display:inline-block;_overflow:hidden; padding:6px 25px; margin:0; font-size:14px;font-weight:bold;text-align:center; border-radius:3px;}
    a.btn_blue:focus, a.btn_red:focus, a.btn_gray:focus {border-color:#93d4fc; box-shadow:0 0 5px #60caff;}
    a.btn_blue:active, a.btn_red:active, a.btn_gray:active {outline:none;}
    a.btn_blue{border:1px solid #0d659b; color:#fff; color:#fff!important; background-color:#238aca; background:-moz-linear-gradient(top, #238aca, #0074bc); background:-webkit-linear-gradient(top, #238aca, #0074bc); filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='#238aca', endColorstr='#0074bc'); -ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr='#238aca', endColorstr='#0074bc')";}
    a.btn_blue:hover{text-decoration:none; background-color:#238aca; background:-moz-linear-gradient(top, #2a96d8, #0169a9); background:-webkit-linear-gradient(top, #2a96d8, #0169a9); filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='#2a96d8', endColorstr='#0169a9'); -ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr='#2a96d8', endColorstr='#0169a9')";}
    a.btn_blue:active{background-color:#238aca; background:-moz-linear-gradient(top, #0074bc, #238aca); background:-webkit-linear-gradient(top, #0074bc, #238aca); filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='#0074bc', endColorstr='#238aca'); -ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr='#0074bc', endColorstr='#238aca')";}
    .hide {visibility:hidden;}
    /* remind_block 带icon的消息提示块 */
    .remind_block {overflow:hidden;}
    .remind_okicon {float:left;margin-right:10px;display:inline;width:32px;height:32px;background:url(http://www.huangkeye.cn/public/Verified.png) no-repeat;}
    .remind_badicon {float:left;margin-right:10px;display:inline;width:32px;height:32px;background:url(http://www.huangkeye.cn/public/Forbid.png) no-repeat;}
    .remind_quesicon {float:left;margin-right:10px;display:inline;width:32px;height:32px;background:url(http://www.huangkeye.cn/public/Question.png) no-repeat;}
    .remind_block .remind_content {overflow:hidden;*zoom:1;}
    .remind_block .remind_title {margin-bottom:10px;padding-top:3px;_margin-top:4px;font-weight:bold;font-size:20px;font-family:"Microsoft YaHei","lucida Grande",Verdana;}
    .remind_block .remind_detail {line-height:1.5;font-size:14px;color:#535353;}
    .remind_block.notitle .remind_content {padding-top:8px;}

    .error .remind_icon {background-position:-256px top;}
    .remind_questitle {color:#d68300;margin-bottom:10px;padding-top:3px;_margin-top:4px;font-weight:bold;font-size:20px;font-family:"Microsoft YaHei","lucida Grande",Verdana;}
    .remind_oktitle {color:#43CD80;margin-bottom:10px;padding-top:3px;_margin-top:4px;font-weight:bold;font-size:20px;font-family:"Microsoft YaHei","lucida Grande",Verdana;}
    .remind_badtitle {color:#FF0000;margin-bottom:10px;padding-top:3px;_margin-top:4px;font-weight:bold;font-size:20px;font-family:"Microsoft YaHei","lucida Grande",Verdana;}
    .warning .remind_icon {background-position:-64px 0;}
    .warning .remind_title {color:#d68300;}
    /* layout */
    .container {
      width:600px;
      margin:0 auto;
      padding-top:25px;
    }
    .header {
      margin-bottom:5px;
    }
    .footer {
      margin-top:18px;
      text-align:center;
      color:#a0a0a0;
      font-size:10px;
    }
    .content {
      border:1px solid #dfdfdf;
      box-shadow:0 0 3px #d4d4d4;
    }
    .c-container {
      padding:30px;
    }
    .c-footer {
      padding:10px 15px;
      background:#f1f1f1;
      overflow:hidden;
      *zoom:1;
    }
    .c-footer-a1,.c-footer-a2,.c-footer-a3 {float:left;}
    .c-footer-a2 {margin:8px 0 0 15px;}
    /* page */
    .safety-detail {
      font-size:12px;
      margin-top:10px;
    }
    .safety-detail.show .safety-icon-arrow {
	  background-position:right top;
	  -webkit-transform:rotate(180deg);
	  -moz-transform:rotate(180deg);
	  transform:rotate(180deg);
    }
	@media screen and (-webkit-min-device-pixel-ratio:0) {
      .safety-detail.show .safety-icon-arrow {
	    background-position:right -18px;
	  }
	}
	@-moz-document url-prefix() {
      .safety-detail.show .safety-icon-arrow {
	    background-position:right -18px;
	  }
	}
    .safety-detail.show .safety-detail-txt {
      visibility:visible;
    }
    .safety-icon-arrow {
      display:inline-block;
      *display:inline;
      *zoom:1;
      width:12px;
      height:12px;
      margin:0 0 2px 4px;
      *margin:2px 0 0 4px;
      line-height:12px;
      vertical-align:middle;
      background:url(https://res.mail.qq.com/zh_CN/htmledition/images/safety_arrow104474.png) no-repeat right -18px;
	  -webkit-transform:rotate(0deg);
	  -webkit-transition:-webkit-transform .3s ease-in;
	  -moz-transform:rorate(0deg);
	  -moz-transition:-moz-transform .3s ease-in;
	  transform:rotate(0deg);
	  transition:transform .3s ease-in;
    }
    .safety-detail-txt {
      margin-top:6px;
      line-height:20px;
      color:#a0a0a0;
      visibility:hidden;
    }
    .safety-url {
      margin-bottom:15px;
      padding-bottom:15px;
      border-bottom:1px solid #dfdfdf;
      word-wrap:break-word;
      word-break:break-all;
    }

  </style>
<style>@-moz-keyframes nodeInserted{from{opacity:0.99;}to{opacity:1;}}@-webkit-keyframes nodeInserted{from{opacity:0.99;}to{opacity:1;}}@-o-keyframes nodeInserted{from{opacity:0.99;}to{opacity:1;}}@keyframes nodeInserted{from{opacity:0.99;}to{opacity:1;}}embed,object{animation-duration:.001s;-ms-animation-duration:.001s;-moz-animation-duration:.001s;-webkit-animation-duration:.001s;-o-animation-duration:.001s;animation-name:nodeInserted;-ms-animation-name:nodeInserted;-moz-animation-name:nodeInserted;-webkit-animation-name:nodeInserted;-o-animation-name:nodeInserted;}</style><style type="text/css"></style><script></script><script id="hp_same_"></script><script id="hp_done_"></script></head>
<body>
<?php 
  error_reporting(0);
  $url = $_GET["url"]; 
  $url = htmlspecialchars(strip_tags($url));
  //检查URL是IP地址还是域名
  if( preg_match("/(http:\/\/|https:\/\/)(\d{1,3}\.){3}\d{1,3}/", $url, $matches)) {
	// 从 URL 中取得IP地址
	preg_match("/^(http:\/\/|https:\/\/){1}?([^\/]+)/i", $url, $matches); 
	$host = $matches[2]; 
	// 从IP中取得后面四段 
	preg_match("/[^\.\/]+\.[^\.\/]+\.[^\.\/]+\.[^\.\/]+$/", $host, $matches);
  }else{
	// 从 URL 中取得主机名
	preg_match("/^(http:\/\/|https:\/\/){1}?([^\/]+)/i", $url, $matches); 
	$host = $matches[2]; 
	// 从主机名中取得后面两段 
	preg_match("/[^\.\/]+\.[^\.\/]+$/", $host, $matches);
  }
  if ($matches[0]==""){
	$matches[0]="<font color='red'>[未知]</font>";$url="<font color='red'>[获取URL失败]</font>";
  }else{
  $matches[0] = strtolower($matches[0]);
	//设置白名单
	$nice_url = 'http://www.huangkeye.cn/wp-content/themes/vfhky/RkY2QThGNEJCMDdFRkM5MDhCMDA1QUI2NzA0NUM4ODcudHh0';
	$ch_ok = curl_init();
	curl_setopt($ch_ok,CURLOPT_URL,$nice_url);
	curl_setopt($ch_ok,CURLOPT_HEADER,0);
	curl_setopt($ch_ok,CURLOPT_RETURNTRANSFER,true);
	curl_setopt($ch_ok,CURLOPT_TIMEOUT,2);
	$source_ok = curl_exec($ch_ok);
	curl_close($ch_ok);
	$arr_ok = explode(',',$source_ok);
	$arr_ok = str_replace('"','',$arr_ok);//去掉双引号
	$arr_ok = str_replace("\n", "", str_replace(" ", "", $arr_ok));//去掉空格和换行
	$arr_ok = str_replace("\t","",$arr_ok); //去掉制表符号
	$arr_ok = str_replace("\r\n","",$arr_ok); //去掉回车换行符号
	$arr_ok = str_replace("\r","",$arr_ok); //去掉回车
	$arr_ok = str_replace("'","",$arr_ok); //去掉单引号
	$num_ok = count($arr_ok); //推荐网址的数目
  
	//设置黑名单
	$bad_url = 'http://www.huangkeye.cn/wp-content/themes/vfhky/NThCMzg0MDkwODc4MzIxQzQyRUEzODU1MDdBMUUzMUQudHh0';
	$ch_bad = curl_init();
	curl_setopt($ch_bad,CURLOPT_URL,$bad_url);
	curl_setopt($ch_bad,CURLOPT_HEADER,0);
	curl_setopt($ch_bad,CURLOPT_RETURNTRANSFER,true);
	curl_setopt($ch_bad,CURLOPT_TIMEOUT,2);
	$source_bad = curl_exec($ch_bad);
	curl_close($ch_bad);
	$arr_bad = explode(',',$source_bad);
	$arr_bad = str_replace('"','',$arr_bad);
	$arr_bad = str_replace("\n", "", str_replace(" ", "", $arr_bad));//去掉空格和换行
	$arr_bad = str_replace("\t","",$arr_bad); //去掉制表符号
	$arr_bad = str_replace("\r\n","",$arr_bad); //去掉回车换行符号
	$arr_bad = str_replace("\r","",$arr_bad); //去掉回车
	$arr_bad = str_replace("'","",$arr_bad); //去掉单引号
	$num_bad = count($arr_bad);//恶意网址的数目

	//获取推荐和恶意网址中最大的那个数目
	$num=($num_ok>$num_bad?$num_ok:$num_bad);
 
	for($i=0;$i<$num;$i++){ 
		if ($matches[0]==$arr_ok[$i]){$verify="1";break;}//1，表示推荐网址
		else if($matches[0]==$arr_bad[$i] || strlen($url)>= 54){$verify="2";break;}//2，表示恶意网址
		else {$verify=0;}//0，表示暂未确认的网址
	}
  }
?>
<body youdao="bind">
  <div class="container">
    <div class="header"><p>&nbsp;&nbsp;</p><p>&nbsp;&nbsp;</p>
    </div>
    <div class="content">
      <div class="c-container warning">
        <div class="remind_block">
         <?php if ($verify==1){ ?><span class="remind_okicon"></span><div class="remind_content"><div class="remind_oktitle"> 访问安全提示：</div><?php } else if ($verify==0){ ?><span class="remind_quesicon"></span><div class="remind_content"><div class="remind_questitle"> 访问安全提示：</div><?php } else { ?><span class="remind_badicon"></span><div class="remind_content"><div class="remind_badtitle"> 访问安全提示：</div><?php }?>
            您将要访问：            <div class="remind_detail">
              <div class="safety-url"><?php echo $url ; ?></div>
              为了净化博客评论环境，防止无良Spamer的骚扰，保护读者的隐私和信息安全，已开启全站链接的安全审核机制！
              <div id="detail_container" class="safety-detail show">
                <div><a id="detail_toggle" class="safety-detail-action" href="javascript:;">详细信息<span class="safety-icon-arrow"></span></a></div>
                <div class="safety-detail-txt">
                	<?php if ($verify==0){ ?>
                  vfhky 查询到该域名为（<?php echo $matches[0]; ?>）。目前我们未对该站点进行安全认证，它可能是广告商的垃圾站点，也可能是某个诱导链接，当然也可能是个好青年。总之，请慎重访问！<br/>
                  <a href="http://www.huangkeye.cn/contact" title="点击进入 和我联系 页面">[ 申请认证 ]</a>&nbsp;&nbsp;&nbsp;<a href="http://www.huangkeye.cn/siteverify" title="点击进入 网址安全认证 页面">[ 查看已认证的站点 ]</a>
                  <?php }
                  else if($verify==1){ ?>
                  vfhky 已对该站点（<?php echo $matches[0]; ?>）完成质量评估和安全认证！因此，我们郑重向您推荐该站！&nbsp;&nbsp;
                  <a href="http://www.huangkeye.cn/contact" title="点击进入 和我联系 页面">[ 申请认证 ]</a>&nbsp;&nbsp;&nbsp;<a href="http://www.huangkeye.cn/siteverify" title="点击进入 网址安全认证 页面">[ 查看已认证的站点 ]</a>
                  <?php }
                  else { ?>
                  vfhky 判断该站点（<?php echo $matches[0]; ?>）来自广告商、钓鱼链接或者被恶意利用！因此，我们不推荐您访问该链接！
                  <a href="http://www.huangkeye.cn/contact" title="点击进入 和我联系 页面">[ 站长申诉 ]</a>&nbsp;&nbsp;&nbsp;<a href="http://www.huangkeye.cn/siteverify" title="点击进入 网址安全认证 页面">[ 查看已认证的站点 ]</a>
                  <?php }; ?>   
                </div>
              </div>
            </div>
          </div>
        </div>
      </div><br/>
      <div class="c-footer">
      <?php if ($verify==0){ ?>
    <a onclick="goUrl(1);" class="c-footer-a1 btn_blue">继续访问</a><?php } else if ($verify==1){ ?><a onclick="goUrl(1);" class="c-footer-a1 btn_blue">立即访问</a><?php } else { ?><a class="c-footer-a1 btn_blue">请手动复制链接</a><?php } ?><a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" class="c-footer-a2" >返回先前页面</a>
      </div>
    </div>
    <div class="footer">
      Copyright ©&nbsp;2012-<?php echo date("Y");?>&nbsp;黄克业的博客&nbsp;All&nbsp;Rights&nbsp;Reserved
    </div>
  </div>
  <script>
  function myHtmlDecode(_asStr) {
    return _asStr && _asStr.replace ? (_asStr.replace(/&nbsp;/gi," ").replace(/&lt;/gi, "<").replace(/&gt;/gi, ">")
    .replace(/&amp;/gi, "&").replace(/&quot;/gi, "\"").replace(/&#39;/gi, "'")
    ) : _asStr; 
	}
  function report(result) {
    (new Image).src = ('/cgi-bin/report_cgi?check=false&r_type=1002&r_msg=0,http%3A%2F%2Fsae.sina.com.cn%2F%3Fm%3Ddevcenter%26amp%3BcatId%3D289&r_result=' + result);
  }
  function goUrl(type) {
    report(type == 1 ? 0 : 1);
    setTimeout(function(){window.location.replace(myHtmlDecode('<?php echo $url ; ?>')) },50);
  }
  function closeURLWindow() {
    report(2);
    setTimeout( function(){ window.close(); }, 80 );
  }
  function goSafe() {
    report(9);
    setTimeout(function(){window.open('http://');},50);
  }		
  window.onload = function() {
    report(10);
    var detailContainer = document.getElementById("detail_container");
    var detailToggle = document.getElementById("detail_toggle");
    var containerClassName = "safety-detail";
    if(detailToggle) {
      detailToggle.onclick = function() {
        if(detailContainer.className.indexOf("show") > -1) {
          detailContainer.className = containerClassName;
        } else {
          detailContainer.className = containerClassName + " show";
        }
      };
    }
  };
  </script>


<style type="text/css"></style></body><style type="text/css"></style></html>
<?php }; ?>