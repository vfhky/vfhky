</div>
<div class="clear"></div>
<div class="foot1">
    <div class="footer_top">
	<div id="menu">
		<?php 
			$catNav = '';
			if (function_exists('wp_nav_menu')) {
				$catNav = wp_nav_menu( array( 'theme_location' => 'footer-menu',  'echo' => false, 'fallback_cb' => '' ) );};
			if ($catNav == '') { ?>
				<ul id="cat-nav" class="nav">
					<?php wp_list_pages('depth=1&sort_column=menu_order&title_li='); ?>
				</ul>
		<?php } else echo($catNav); ?>
	</div>
	<?php wp_reset_query();if ( is_home()){ ?><h2 class="blogtitle">
	<a href="http://www.huangkeye.cn/links" title="申请友链">友情链接</a></h2><?php } ?>
        <?php wp_reset_query();if ( !is_home()){ ?><h2 class="blogtitle">
	<a href="<?php bloginfo('home'); ?>/" title="<?php bloginfo('name'); ?>">返回首页</a></h2><?php } ?>
    </div>
</div>
<div class="foot">
<?php wp_reset_query();if ( is_home()){ ?>
    <div class="link">
	<?php
		if(function_exists('wp_hto_get_links')){
		wp_hot_get_links();
		}else{
		wp_list_bookmarks('title_li=&categorize=&orderby=rand&limit=32&show_images=');
		}
	?><li><a href="http://www.huangkeye.cn/links">更多...</a></li>
	<div class="clear"></div>
    </div>
<?php }  include(TEMPLATEPATH . '/addelay.php'); ?>	
    <div class="footer_bottom">
	<!--
		作为一个节操程序员，请保留底部huishao和vfhky的版权链接信息（当然也不强求）。等你在https://github.com/vfhky/vfhky
	 -->
	<a href="https://github.com/vfhky/vfhky" target="_blank">GitHub源码</a>&nbsp;|&nbsp;<a href="http://www.huangkeye.cn/sitemap.html" target="_blank">百度Sitemap</a>&nbsp;|&nbsp;<a href="http://www.huangkeye.cn/sitemap.xml" target="_blank">谷歌Sitemap</a>&nbsp;|&nbsp;Powered by <a href="http://cn.wordpress.org/" target="_blank">WordPress</a>&nbsp;|&nbsp;Theme by <a href="http://www.zuifengyun.com/" target="_blank">huishao</a> && <a href="http://www.huangkeye.cn/">vfhky</a>&nbsp;|&nbsp;Online:&nbsp;<span class="online"></span><br/><br/>
	Copyright <?php echo comicpress_copyright(); ?> <a href="http://www.huangkeye.cn">黄克业的博客</a>&nbsp;.&nbsp;All Rights Reserved&nbsp;.&nbsp;苏ICP备13016977号<br/>
    </div>
     <div class="clear"></div>
</div>
</body>
<?php wp_footer(); ?>
</html>