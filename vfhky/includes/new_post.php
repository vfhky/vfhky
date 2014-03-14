<?php
    $args = array(
    'posts_per_page' => 3,
    'post__in' => get_option( 'sticky_posts' ),
    'ignore_sticky_posts' => 1
    );
    query_posts( $args ); while ( have_posts() ) : the_post();?>
<div class="entry_box">
	<span class="comment_a"><?php comments_popup_link('+0&deg; ', '+1&deg; ', '+%&deg; '); ?></span>
	<div class="box_entry">
		<div class="box_entry_title">
			<h3><i class="sticky sticky_ordinary"></i><a href="<?php the_permalink() ?>" rel="bookmark" title="详细阅读 <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
			<div class="info">
			  <span class="date"><?php the_time('Y年m月d日') ?></span> | <?php 
$category = get_the_category(); 
if($category[0]){
echo '分类：<a href='.get_category_link($category[0]->term_id ).'>'.$category[0]->cat_name.'</a>';
}
?> | <?php echo count_words ($text); ?> <?php  echo ' | 围观：'; the_views(); ?>次
			</div>
		</div>
		<div class="clear"></div>
	</div>
</div>
<div class="entry_box_b"></div>
<?php endwhile;wp_reset_query();?>

<?php
	$scrollcount = get_option('vfhky_new_post');//获取后台设置的最新文章显示的数目
 ?>
<?php 
	$sticky = get_option('sticky_posts');
	$swt_catagelory = get_option('vfhky_new_exclude');
	$args=array(
	'caller_get_posts' => 6,
	'showposts' => $scrollcount,
	'post__not_in' => $sticky,
	'cat' => $swt_catagelory,
	);
	query_posts($args);
	while ( have_posts() ) : the_post();$do_not_duplicate[] = $post->ID; ?>
<div class="entry_box">
	<span class="comment_a"><?php comments_popup_link('+0&deg; ', '+1&deg; ', '+%&deg; '); ?></span>
	<div class="box_entry">
		<div class="box_entry_title">
			<span class="cat_name">
				<?php 
				$category = get_the_category(); 
				if($category[0]){
				echo '<a href='.get_category_link($category[0]->term_id ).'>'.$category[0]->cat_name.'</a>';
				}
				?>
			</span>
			<h3><a href="<?php the_permalink() ?>" rel="bookmark" title="详细阅读 <?php the_title_attribute(); ?>"><?php the_title(); ?></a><img src="<?php bloginfo('template_directory'); ?>/images/new.gif" alt="最新发表" title="最新发表" width="24px" height="11px"/></h3>
			<div class="info">
			  <span class="date"><?php the_time('Y年m月d日') ?></span> | <?php echo count_words ($text); ?> <?php  echo ' | 围观：'; the_views(); ?>次
			</div>
		</div>
		<div class="clear"></div>
		<div class="thumbnail_box">
			<?php include('thumbnail.php'); ?>
		</div>
		<div class="post_entry">
            <div style="height: 110px;word-wrap: break-word;overflow: hidden;">
				<?php if (has_excerpt()) { the_excerpt(); }
				else{ echo mb_strimwidth(strip_tags(apply_filters('the_content', $post->post_content)), 0, 300,"..."); } ?>
            </div>
			<div class="clear"></div>
			<span class="archive_more"><a href="<?php the_permalink() ?>" title="详细阅读 <?php the_title(); ?>" rel="bookmark" class="title">More...</a></span>
			<div class="clear"></div>
		</div>
	</div>
</div>
<div class="entry_box_b"></div>
<?php if ($wp_query->current_post == 0) : ?>
	<?php if (get_option('vfhky_adh') == '关闭') {echo ''; } else { ?>
<div id="pd_h">
		<div id="pd_h_c"></div>
</div>
<div class="entry_box_b"></div><?php } ?>
<?php endif; ?>
<?php endwhile; ?>