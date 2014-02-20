<?php include('header_img_s.php'); ?>
<?php include('includes/addclass.php'); ?>
<div id="content">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div id="map">
			<div class="browse">当前位置：<a title="返回首页" href="<?php echo get_settings('Home'); ?>/">首页</a> &gt; <?php echo get_the_term_list($post->ID,  'gallery', '', ', ', ''); ?> &gt; 图片欣赏</div>
		</div>
		<div class="entry_box_s">
			<div class="imgcat"></div>
			<div class="img_title_box">
				<div class="entry_title">
					<?php 
						the_title();
						$random = intval(mt_rand(1,9));
						$random_1 = "http://storage.live.com/items/4054252DDEB2E987!268?a.mp3";
						$random_2 = "http://storage.live.com/items/4054252DDEB2E987!266?a.mp3";
						$random_3 = "http://storage.live.com/items/4054252DDEB2E987!265?a.mp3";
						$random_4 = "http://storage.live.com/items/4054252DDEB2E987!267?a.mp3";
						$random_5 = "http://storage.live.com/items/4054252DDEB2E987!275?a.mp3";
						$random_6 = "http://storage.live.com/items/4054252DDEB2E987!276?a.mp3";
						$random_7 = "http://storage.live.com/items/4054252DDEB2E987!278?a.mp3";
						$random_8 = "http://storage.live.com/items/4054252DDEB2E987!277?a.mp3";
						$random_9 = "http://storage.live.com/items/4054252DDEB2E987!281?a.mp3";
						if ($random == 1){//3,1,2,4,5,9,6,8,7
							$content = "$random_3|$random_1|$random_2|$random_4|$random_5|$random_9|$random_6|$random_8|$random_7";
						}else if($random == 2){//1,4,3,2,6,5,7,9,8
							$content = "$random_1|$random_4|$random_3|$random_2|$random_6|$random_5|$random_7|$random_9|$random_8";
						}else if($random == 3){//2,3,4,1,8,9,6,7,5
							$content = "$random_2|$random_3|$random_4|$random_1|$random_8|$random_9|$random_6|$random_7|$random_5";
						}else if($random == 4){//4,3,2,1,5,9,7,6,8
							$content = "$random_4|$random_3|$random_2|$random_1|$random_5|$random_9|$random_7|$random_6|$random_8";
						}else if($random == 5){//5,3,4,1,6,2,8,7,9
							$content = "$random_5|$random_3|$random_4|$random_1|$random_6|$random_2|$random_8|$random_7|$random_9";
						}else if($random == 6){//6,3,4,1,5,8,9,7,2
							$content = "$random_6|$random_3|$random_4|$random_1|$random_5|$random_8|$random_9|$random_7|$random_2";
						}else if($random == 7){//7,3,4,1,5,2,6,8,9
							$content = "$random_7|$random_3|$random_4|$random_1|$random_5|$random_2|$random_6|$random_8|$random_9";
						}else if($random == 8){//8,3,4,1,6,2,7,5,9
							$content = "$random_8|$random_3|$random_4|$random_1|$random_6|$random_2|$random_7|$random_5|$random_9";
						}else {//9,2,1,3,8,7,5,6,4
							$content = "$random_9|$random_2|$random_1|$random_3|$random_8|$random_7|$random_5|$random_6|$random_4";
						}
						echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<embed src="'.get_bloginfo("template_url").'/music.swf" flashvars="mp3='.$content.'&autostart=yes" type="application/x-shockwave-flash" wmode="transparent" width="240" height="20"></embed>';
					?>
				</div>
			</div>
			<div class="img_info">
				<ul class="date">发布时间：<?php the_time('Y-m-d H:i'); ?>&nbsp;&nbsp;&nbsp;&nbsp;<span class="edit"><?php edit_post_link('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', '  ', '  '); ?></span></ul>
				<ul class="category">所属分类：<?php echo get_the_term_list($post->ID,  'gallery', '', ', ', ''); ?></ul>
				<ul class="comment">图集评论：<?php comments_popup_link('赶快抢沙发', '只有板凳了', '共有 % 条评论'); ?></ul>
				<ul class="comment"> <?php if(function_exists('the_views')) { print '浏览次数：'; the_views(); print ' 次';  } ?></ul>
				<ul class="date">图集包含：<span id="myimg"></span></ul>
			</div>
			<div class="entry">
				<div class="entry_c">
					<div class="pic">
						<div class="top_t">
							<?php if ( get_post_meta($post->ID, 'small', true) ) : ?>
							<?php $image = get_post_meta($post->ID, 'small', true); ?>
							<?php $img = get_post_meta($post->ID, 'big', true); ?>
							<a class="cboxElement" href="<?php echo $img; ?>" rel="example4" title="<?php the_title(); ?>"><img src="<?php echo $image; ?>" alt="<?php the_title(); ?>"/></a>
							<?php else: ?>
						</div>
						<div class="thumbnail_hot">
							<?php 
							 if ( has_post_thumbnail()) {
							   $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large');
							   echo '<a class="cboxElement" href="' . $large_image_url[0] . '" rel="example4" title="' . the_title_attribute('echo=0') . '" >';
							   the_post_thumbnail('hot');
							   echo '</a>';
							 }
							 ?>
							<?php endif; ?>
						</div>
					</div>
					<?php the_content('Read more...'); ?>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="entry_sb">
		</div>
		<div class="entrymeta">
			<div class="authorbio">
				<div class="author_pic">
					<img src="<?php $mail = get_the_author_email();
					$a = get_bloginfo('wpurl') . '/avatar/' . md5(strtolower($mail)) . '.jpg'; echo $a; ?>" alt="<?php the_author_description();?>" title="<?php the_author_description();?>" width="42" height="42" >
				</div>
				<div class="clear"></div>
				<div class="author_text">
					<h4>作者: <span><?php the_author_posts_link('namefl'); ?></span></h4>
				</div>
			</div>
			<span class="spostinfo">
				<ul>
					<li><strong>转载注明：</strong><a href="<?php the_permalink() ?>" rel="bookmark" title="本文固定链接 <?php the_permalink() ?>"><?php the_title(); ?> | <?php bloginfo('name');?></a><a href="#" onclick="copy_code('<?php the_permalink() ?>'); return false;"> +点击复制</a></li>
					<li><strong>分类标签：</strong><?php echo get_the_term_list($post->ID,  'gallery', '', ', ', ' '); ?>》<?php echo get_the_term_list($post->ID,  'picture_tags', '', ', ', ''); ?></li>
					<li><strong>赞助支持：</strong><font color="#ff0000">点击广告或者通过 <a href="http://me.alipay.com/vfhky" title=" 支付宝赞助博客 " target="_blank"><strong><u>支付宝赞助</u></strong></a> 本站,感谢支持！</font></li>
				</ul>
			</span>
			<div class="clear"></div>
		</div>
		<div class="entry_sb"></div>
	<div class="context_b">
		<?php previous_post_link('【上篇】%link') ?><br/><?php next_post_link('【下篇】%link') ?>
	</div>
	<div class="ct"></div>
	<?php comments_template(); ?>
	<?php endwhile; else: ?>
	<?php endif; ?>
</div>
<div id="sidebar"><!--右边侧边栏开始-->
	<div class="widget">
		<?php  include(TEMPLATEPATH . '/includes/feed_email.php'); ?>
	</div>
	<?php include(TEMPLATEPATH . '/includes/tab2.php');include(TEMPLATEPATH . '/includes/tab.php');  ?>
	<div class="clear"></div>
</div>
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
	<a href="<?php echo stripslashes(get_option('swt_link_s')); ?>" title="申请友链">友情链接</a></h2><?php } ?>
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
	?><li><a href="<?php echo stripslashes(get_option('swt_link_s')); ?>">更多...</a></li>
	<div class="clear"></div>
    </div>
<?php } ?>	
    <div class="footer_bottom">
	<!--
  	作为一个节操程序员，请保留底部huishao和vfhky的版权链接信息（当然也不强求）。等你在https://github.com/vfhky/vfhky！
  -->
	<a href="https://github.com/vfhky/vfhky" title="GitHub源码" target="_blank">GitHub源码</a>&nbsp;|&nbsp;<a href="http://www.huangkeye.cn/sitemap.html" title="BaiDu Sitemap" target="_blank">百度Sitemap</a>&nbsp;|&nbsp;<a href="http://www.huangkeye.cn/sitemap.xml" title="Google XML Sitemap"target="_blank">谷歌Sitemap</a>&nbsp;|&nbsp;Powered by <a href="http://cn.wordpress.org/" title="WordPress官方中文博客" target="_blank">WordPress</a>&nbsp;|&nbsp;Theme by <a href="http://www.zuifengyun.com/" title="醉风云博客" target="_blank">huishao</a> && <a href="http://www.huangkeye.cn/" title="黄克业的博客">vfhky</a>&nbsp;|&nbsp;Online:&nbsp;<span class="online"></span><br/><br/>
	Copyright <?php echo comicpress_copyright(); ?> <a href="http://www.huangkeye.cn" title="黄克业的博客 | ——麻辣的视界">黄克业的博客</a>&nbsp;.&nbsp;All Rights Reserved&nbsp;.&nbsp;苏ICP备13016977号<br/>
    </div>
     <div class="clear"></div>
</div>

	<span id="pd_h_c_2"><?php echo stripslashes(get_option('swt_adtc')); ?></span>
	<script type="text/javascript">
		document.getElementById("pd_h_c1").innerHTML = document.getElementById("pd_h_c_2").innerHTML;
		document.getElementById("pd_h_c_2").innerHTML = "";		
	</script>

</body>
<?php wp_footer(); ?>
</html> 