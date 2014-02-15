<?php get_header(); ?>
	<div class="slider_box">
		<?php include (TEMPLATEPATH . '/includes/slider.php'); ?><!--幻灯片结束-->
		<div class="hot_box">
			<?php include (TEMPLATEPATH . '/includes/hot_n.php'); ?><!--幻灯片右侧的热点推荐结束-->
			<?php include (TEMPLATEPATH . '/includes/rolling_n.php'); ?><!--热点推荐下面的滚动信息结束-->
		</div>
        <div class="a_top">
          <div class="a1_top"></div>
            <center>
			 				<div id="a1_top1"><a target="_blank" href="http://wp.qq.com/wpa/qunwpa?idkey=7a4a9a79a8ffb22519dd090155dc06be3105616c245e4078693adfd21481f356" title="点击加入博客QQ技术群 [24385396] "><img src="<?php bloginfo('template_directory'); ?>/images/top3.jpg" title="点击加入博客QQ技术群 [24385396] " alt="点击加入博客QQ技术群 [24385396] " style="width:250px;height:78px;"></a><a href="http://www.huangkeye.cn/tag/%E5%8D%9A%E5%AE%A2%E6%88%90%E9%95%BF%E5%BD%95" target="_blank" title="黄克业的博客,一个专注于IT互联网技术的博客。" alt="黄克业的博客,一个专注于IT互联网技术的博客。"><img src="<?php bloginfo('template_directory'); ?>/images/top2.jpg" title="黄克业的博客,一个专注于IT互联网技术的博客。" alt="黄克业的博客,一个专注于IT互联网技术的博客。" style="width:250px;height:78px;"></a><a href="http://www.huangkeye.cn/gallery/nba" target="_blank" title="博客NBA图集系列" alt="博客NBA图集系列"><img src="<?php bloginfo('template_directory'); ?>/images/top1.jpg" alt="博客NBA图集系列" title="博客NBA图集系列" style="width:250px;height:78px;"></a></div>
            </center>
        </div>
	</div><!--幻灯片、热点推荐、右侧博客展示平台结束-->
	<div class="clear12"></div>
<div id="post"><!--网页中间部分文章信息开始-->
	<?php include(TEMPLATEPATH . '/includes/new_post.php'); ?><!--调用最新更新的文章结束-->
	<div id="cmsl"><!--循环输出左侧的分类模块-->
		<?php $display_categories = explode(',', get_option('swt_catl') ); foreach ($display_categories as $category) { ?>
		<?php
			query_posts( array(
				'showposts' => 1,
				'cat' => $category,
				'post__not_in' => $do_not_duplicate
				)
			);
		?>
		<div class="entry_box_h">
			<?php while (have_posts()) : the_post(); ?>
			<div class="box_entry_title_h">
			<span class="cat_name_l"><?php single_cat_title(); ?></span><!--分类模块的标题-->
					<h3><a href="<?php the_permalink() ?>" rel="bookmark" title="详细阅读 <?php the_title_attribute(); ?>"><?php echo mb_strimwidth($post->post_title,0,40); ?></a></h3>
					<div class="info">
						<span class="date"><?php the_time('Y年m月d日') ?></span>
						<span class="comment"> | <?php comments_popup_link('暂无评论', '评论数：1', '评论数：%'); ?></span>
						<?php print ' | 围观：'; the_views(); print '次'; ?>
					</div>
			</div>
			<div class="clear"></div>
			<div class="thumbnail_box_h">
				<?php include('includes/thumbnail.php'); ?>
			</div>
			<div class="cat_box">
				<?php echo mb_strimwidth(strip_tags(apply_filters('the_content', $post->post_content)), 0, 140); ?>
			</div>
			<div class="clear"></div>
			<?php endwhile; ?>
			<div class="cat_post_box">
		  		<?php
					query_posts( array(
						'showposts' => get_option('swt_cat_n'),
						'cat' => $category,
						'offset' => 1,
						'post__not_in' => $do_not_duplicate
						)
		 			);
				?>
				<?php while (have_posts()) : the_post(); ?>
				<ul><li>
					<span class="hoem_date"><?php the_time('Y-m-d'); ?></span>
					<a href="<?php the_permalink() ?>" rel="bookmark"  title="<?php if (has_excerpt()){ the_excerpt();} else{ echo mb_strimwidth(strip_tags(apply_filters('the_content', $post->post_content)), 0, 190);} ?>"><?php echo mb_strimwidth($post->post_title,0,30); ?></a>
				</li></ul>
				<?php endwhile; ?>
			</div>
				<div class="ption">
					<span class="cat_name_c">共有<?php echo wt_get_category_count(); ?>篇文章</span>
					<span class="archive_more"><a href="<?php echo get_category_link($category);?>" rel="bookmark" title="查看【<?php single_cat_title(); ?>】类别下的所有文章">More...</a></span>
				</div>
				<div class="clear"></div>
		</div>
		<div class="cms_box_b">
		</div>
		<?php } ?>
	</div><!--循环输出左侧的分类模块结束-->

	<div id="cmsr"><!--循环输出右侧的分类模块-->
		<?php $display_categories = explode(',', get_option('swt_catr') ); foreach ($display_categories as $category) { ?>
		<?php
			query_posts( array(
				'showposts' => 1,
				'cat' => $category,
				'post__not_in' => $do_not_duplicate
				)
			);
		?>
		<div class="entry_box_h">
			<?php while (have_posts()) : the_post(); ?>
			<div class="box_entry_title_h">
			<span class="cat_name_l"><?php single_cat_title(); ?></span><!--分类模块的标题-->
					<h3><a href="<?php the_permalink() ?>" rel="bookmark" title="详细阅读 <?php the_title_attribute(); ?>"><?php echo mb_strimwidth($post->post_title,0,40); ?></a></h3>
					<div class="info">
						<span class="date"><?php the_time('Y年m月d日') ?></span>
						<span class="comment"> | <?php comments_popup_link('暂无评论', '评论数：1', '评论数：%'); ?></span>
						<?php if(function_exists('the_views')) { print ' | 围观：'; the_views(); print '次';  } ?>
					</div>
			</div>
			<div class="clear"></div>
			<div class="thumbnail_box_h">
				<?php include('includes/thumbnail.php'); ?>
			</div>
			<div class="cat_box">
				<?php echo mb_strimwidth(strip_tags(apply_filters('the_content', $post->post_content)), 0,140); ?>
			</div>
			<?php endwhile; ?>
			<div class="cat_post_box">
		  		<?php
					query_posts( array(
						'showposts' => get_option('swt_cat_n'),
						'cat' => $category,
						'offset' => 1,
						'post__not_in' => $do_not_duplicate
						)
		 			);
				?>
				<?php while (have_posts()) : the_post(); ?>
				<ul><li>
					<span class="hoem_date"><?php the_time('Y-m-d'); ?></span>
					<a href="<?php the_permalink() ?>" rel="bookmark" 
					title="<?php if (has_excerpt()){the_excerpt();} else{ echo mb_strimwidth(strip_tags(apply_filters('the_content', $post->post_content)), 0, 190);} ?>"><?php echo mb_strimwidth($post->post_title,0,30); ?></a>
				</li></ul>
				<?php endwhile; ?>
			</div>
				<div class="ption">
					<span class="cat_name_c">共有<?php echo wt_get_category_count(); ?>篇文章</span>
					<span class="archive_more"><a href="<?php echo get_category_link($category);?>" rel="bookmark" title="查看【<?php single_cat_title(); ?>】类别下的所有文章">More...</a></span>
				</div>
				<div class="clear"></div>
		</div>
		<div class="cms_box_b">
		</div>
		<?php } ?>
	</div>
	<!--循环输出右侧的分类模块结束-->
</div>
<!--网页中间部分文章信息结束-->
<?php get_sidebar(); ?>
<?php get_footer(); ?>