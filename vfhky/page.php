<?php get_header(); ?>
<div id="content">
	<?php if (have_posts()) : ?><?php while (have_posts()) : the_post(); ?>	<div id="map">
		<div class="browse">当前位置：<a title="返回首页" href="<?php echo get_settings('Home'); ?>/">首页</a> &gt; <?php the_title(); ?></div>
	</div>
	<div class="clear"></div>
	<div class="entry_box_s">
		<div class="entry">
			<div class="page" id="post-<?php the_ID(); ?>">
				<?php the_content('More &raquo;'); ?>
				<div class="clear"></div>
				<?php the_tags('标签: ', ', ', ' '); ?>
				<span class="edit">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><?php if(function_exists('the_views')) { echo ' 被围观 '; the_views();} ?>+<?php edit_post_link('【编辑】', '', ''); ?>
			</div>
		</div>		<div class="clear"></div>
	</div>
	<div class="entry_sb"></div>
	<div class="ct"></div>
	<?php comments_template(); ?>
	<?php endwhile;endif; ?>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>