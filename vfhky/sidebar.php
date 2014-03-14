<div id="sidebar">
	<div class="widget">
		<?php include(TEMPLATEPATH . '/includes/feed_email.php'); ?><!--调用订阅和公告模板-->
	</div>	
	
	<div class="widget">
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('全部页面小工具') ) : ?>
		<?php endif; ?>
	</div><!--调用全部小工具-->


	<?php if (get_option('vfhky_mimg') == '显示') { ?>
	<?php include('includes/mimg.php'); ?>
	<?php } else { } ?>


	<?php if (get_option('vfhky_mcat') == '显示') { ?>
	<?php wp_reset_query();if (is_single()) { ?>
		<?php include('includes/mcat.php'); ?><!--同类最新-->
	<?php } ?>
	<?php } else { } ?>

</div>