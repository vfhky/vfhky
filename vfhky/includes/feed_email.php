<h3>关注本站</h3>
<script>
 function toLogin()
 {
   //以下为按钮点击事件的逻辑。注意这里要重新打开窗口
   //否则后面跳转到QQ登录，授权页面时会直接缩小当前浏览器的窗口，而不是打开新窗口
   var A=window.open("http://www.huangkeye.cn/wp-content/themes/vfhky/wpwplogin.php","黄克业的博客 QQ登录","width=450,height=320,menubar=0,scrollbars=1,resizable=1,status=1,titlebar=0,toolbar=0,location=1");
 } 
</script>
<div class="feed-mail">
	<div class="box">
		<ul id="contact-li">
			<li class="qq"><a rel="nofollow" target="_blank" href="http://wpa.qq.com/msgrd?V=1&Menu=yes&Uin=<?php echo stripslashes(get_option('swt_qq')); ?>" title="有急事请Q我">QQ联系</a></li>
			<li class="email"><a rel="nofollow" target="_blank" href="<?php echo stripslashes(get_option('swt_email')); ?>" title="使用QQ邮箱给我发信息">邮件</a></li>
			<li class="qqmblog"><a rel="nofollow" href="#" onclick='toLogin()' title="收听我的腾讯微博">腾讯微博</a></li>
			<li class="sinamblog"><a rel="nofollow" target="_blank" href="<?php echo stripslashes(get_option('swt_sinamblog')); ?>" title="收听我的新浪微博">新浪微博</a></li>
			<li class="rss"><a rel="nofollow" target="_blank" href="<?php echo get_option('swt_rsssub'); ?>" title="通过RSS订阅博客">RSS订阅</a></li>
		</ul>
	</div>
	<div class="clear"></div>
	<div class="gg">
		<p>------======<strong> 最新公告 </strong>======------<br/>
		<?php echo stripslashes(get_option('swt_ggao')); ?></p>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
</div>