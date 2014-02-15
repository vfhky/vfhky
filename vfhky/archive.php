<?php get_header(); ?>
<div id="content">
	<div id="map">
		<div class="browse">当前位置：<a title="返回首页" href="<?php echo get_settings('Home'); ?>/">首页</a> &gt; <?php if (have_posts()) : ?> 
			<?php $post = $posts[0]; ?>
			<?php if (is_category()) { ?><?php echo get_category_parents( get_query_var('cat') , true , ' &gt; ' ); ?>文章
			<?php } elseif( is_tag() ) { ?><?php single_tag_title(); ?>
			<?php } elseif (is_day()) { ?><?php the_time('Y年m月'); ?>发表的文章
			<?php } elseif (is_month()) { ?>所有<?php the_time('Y年m月'); ?>文章			<?php } elseif (is_year()) { ?>Archive for <?php the_time('Y'); ?>			<?php } elseif (is_author()) { ?><?php wp_title( '');?>发表的所有文章			<?php } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>			<h1>Blog Archives</h1>			<?php } ?>		</div>	</div>	<?php while ( have_posts() ) : the_post(); ?>	<div class="entry_box">		<span class="comment_a"><?php comments_popup_link('+0&deg; ', '+1&deg; ', '+%&deg; '); ?></span>  		<div class="archive_box">			<div class="archive_title_box">				<div class="archive_title">					<h3><a href="<?php the_permalink() ?>" rel="bookmark" title="详细阅读 <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>				</div> 				<div class="archive_info">					<span class="date"><?php the_author() ?> | <?php the_time('Y-m-d H:i'); ?></span>
					<span class="category"> | <?php the_category(', ') ?></span>
					<span class="comment"> | <?php comments_popup_link('暂无评论', '评论数 1', '评论数 %'); ?></span>
					<?php if(function_exists('the_views')) { print ' | 围观：'; the_views(); print '+';  } ?>
					<span class="edit"><?php edit_post_link('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', '  ', '  '); ?></span>				</div>			</div>			<div class="thumbnail_box">				<?php include('includes/thumbnail.php'); ?>			</div>			<div class="archive">				<?php if (has_excerpt())				{ ?> 					<?php the_excerpt() ?>				<?php				}				else{					echo mb_strimwidth(strip_tags(apply_filters('the_content', $post->post_content)), 0, 300,"...");				} 				?>			</div>			<div class="clear"></div>			<span class="archive_more"><a href="<?php the_permalink() ?>" title="详细阅读 <?php the_title(); ?>" rel="bookmark" class="title">+阅读全文</a></span>			<div class="clear"></div>		</div>	</div>	<div class="entry_box_b">	</div>	<?php if ($wp_query->current_post == 0) : ?>	<?php if (get_option('swt_adh') == '关闭') { ?>	<?php { echo ''; } ?>	<?php } else { ?>
<div id="pd_h">
		<div id="pd_h_c"></div>
</div>
<div class="entry_box_b"></div><?php } ?>	<?php endif; ?>		<?php endwhile; else: ?>	<?php endif; ?>    <div class="navigation"><?php pagination($query_string); ?></div>	<div class="clear"></div></div><?php get_sidebar(); ?><?php get_footer(); ?>