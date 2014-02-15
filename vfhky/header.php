<!DOCTYPE html>
<html dir="ltr" lang="zh-CN" style="-webkit-text-size-adjust:none;">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php include('includes/seo.php'); ?>
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> Atom Feed" href="<?php bloginfo('atom_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/images/favicon.ico" />
<link rel="author" href="https://plus.google.com/u/0/101192347122765496150/">
<?php if (function_exists('wp_enqueue_script') && function_exists('is_singular')) : ?>
<script src="http://libs.baidu.com/jquery/1.8.3/jquery.min.js"></script>
<?php wp_head(); ?>
<?php if ( is_singular() ){ ?>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/comments-ajax.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/single.js"></script>
<?php } ?>
<?php endif; ?>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/custom.js"></script>
<?php if ( is_home() ){ ?><script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery.cycle.all.min.js"></script><!--幻灯片-->
<?php } ?>
<?php if (get_option('swt_pirobox') == '关闭') { ?>
<?php } else if(is_single()){ include(TEMPLATEPATH . '/includes/pirobox.php'); } ?><!--正文中图片的箱子显示-->

<script type="text/javascript">
$(function () {
$('.thumbnail img,.thumbnail_t img,.box_comment img,#a1_top1 img,#slideshow img,.r_comments img,.v_content_list img').hover(
function() {$(this).fadeTo("fast", 0.5);},
function() {$(this).fadeTo("fast", 1);
});
});
</script><!--图片渐隐-->
<?php include('includes/lazyload.php'); ?>
</head>
<body class="custom-background" >
<div class="header clearfix">
<div class="mainbanner">
<div id="header">
		<div class="header_c">
			<?php if (get_option('swt_logo') == '关闭') { ?>
			<h1><a href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a><br/><span  class="blog-title"><?php bloginfo('description'); ?></span ></h1>
			<?php  echo ''; } else{ ?>
			<a href="<?php bloginfo('siteurl'); ?>" title="<?php bloginfo('name'); ?>"><div class="logo"></div></a><?php } ?>
			<div class="time"><?php date_default_timezone_set(PRC);$week= array('日','一','二','三','四','五','六'); echo date('Y年m月d日', time()).' 星期'.$week[date('w')];?></div>
		</div>
		<div class="clear"></div>
	</div>
</div>
<div id="top">
		<div id='topnav'>
			<div class="left_top ">
				<?php wp_nav_menu( array( 'theme_location' => 'header-menu' ) ); ?> 
			</div>
			<div id="searchbar">
				<form  method="get" action="<?php bloginfo('home'); ?>" id="searchbar_form">
					<?php if ( is_search() ){ ?>
					<input type="text" value="<?php the_search_query(); ?>" onfocus="if (this.value != '') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Google+Baidu：输入关键字回车';}" name="s" class="search_s" size="30" x-webkit-speech />
					<?php }else { ?>
					<input type="text" value="Google+Baidu：输入关键字回车" onfocus="if (this.value != '') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Google+Baidu：输入关键字回车';}" name="s"   class="search_s" size="30"  x-webkit-speech />
					<?php } ?>
				</form>
			</div>
		</div>
	</div>
</div><!--页面头部结束-->
<div id="wrapper"><!--页面中间部分开始-->
	<?php include('includes/scroll.php'); ?><!--右边侧栏快速返回功能-->