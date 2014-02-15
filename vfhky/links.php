<?php
/*
Template Name: 友情链接
*/
?>
<?php get_header(); ?>
<div id="content">
	<?php if (have_posts()) : ?><?php while (have_posts()) : the_post(); ?>
		<div id="map">
			<div class="browse">当前位置：<a title="返回首页" href="<?php echo get_settings('Home'); ?>/">首页</a> &gt; <?php the_title(); ?></div>
		</div>
	<div class="clear"></div>
		<div class="entry_box_s">
			<script type="text/javascript">jQuery(document).ready(function($){
				$(".link_page a").each(function(e){
				$(this).prepend("<img src=http://www.google.com/s2/favicons?domain="+this.href.replace(/^(http:\/\/[^\/]+).*$/, '$1').replace( 'http://', '' )+">");});});
			</script>
		<div class="link_page">
			<?php wp_list_bookmarks('orderby=rand&category_orderby=id'); ?>
			<div class="clear"></div>
		</div>
	</div>
	<div class="entry_sb_l">
	</div>
	<div class="entry_box_s_l">
		<div class="links_m">
			<div class="page" id="post-<?php the_ID(); ?>">
				<?php the_content('More &raquo;'); ?><span class="edit">
				<div class="clear"></div><br/>
				<div><span class="edit">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><?php if(function_exists('the_views')) { print ' 被围观 '; the_views(); print '+';  } ?><?php edit_post_link('【编辑】', '', ''); ?></div>
			</div>
		</div>
			<div class="clear"></div>
	</div>
	<div class="entry_sb_l">
	</div> <?php comments_template(); ?>
	<?php endwhile; else: ?>
	<?php endif; ?>
	</div> 	
<?php get_sidebar(); ?> 
<?php get_footer(); ?>