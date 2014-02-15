<?php
/*
Template Name: 热门标签
*/
?>
<?php get_header(); ?>
	<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>	
			<div id="map_box">
				<div id="map_l">
					<div class="browse">当前位置：<a title="返回首页" href="<?php echo get_settings('Home'); ?>/">首页</a> &gt; <?php the_title(); ?></div>
				</div>
				<div id="map_r"></div>
			</div>
			<div class="clear"></div>
			<div class="entry_box_s_2">
				<div class="tagall">
					<?php wp_tag_cloud('smallest=14&largest=14&orderby=count&unit=px&number=&order=RAND');?>
				</div>
			</div>
			<div class="entry_sb_2"></div>
		<?php endwhile; ?>
	<?php endif; ?>
<?php get_footer(); ?>