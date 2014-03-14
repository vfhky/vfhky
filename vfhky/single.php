<?php get_header(); ?>
<?php include('includes/addclass.php'); ?>
<script type="text/javascript">
    function doZoom(size) {
        var zoom = document.all ? document.all['entry'] : document.getElementById('entry');
        zoom.style.fontSize = size + 'px';
    }
</script>
<div id="content">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div id="map">
			<div class="browse">当前位置：<a title="返回首页" href="<?php echo get_settings('Home'); ?>/">首页</a> &gt; <?php $categories = get_the_category(); echo(get_category_parents($categories[0]->term_id, TRUE, ' &gt; '));  ?>正文</div>
			<div class="font"><a href="javascript:doZoom(12)">小</a> <a href="javascript:doZoom(13)">中</a> <a href="javascript:doZoom(18)">大</a></div>
		</div>
		<div class="entry_box_s">
			<div class="entry_title_box">
				<div class="entry_title"><?php the_title(); ?></div>
				<div class="archive_info">
					作者：<?php the_author_posts_link('namefl'); ?> &nbsp; 发布：<?php the_time('Y-m-d H:i'); ?> &nbsp; 分类：<?php the_category(', '); ?> &nbsp; <?php echo count_words ($text); ?> &nbsp; <?php if(function_exists('the_views')) { echo '围观：';the_views();echo '+';} ?> &nbsp; <?php comments_popup_link ('抢沙发','1条评论','%条评论'); ?><span class="edit"><?php edit_post_link('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', '  ', '  '); ?></span>
				</div>
			</div>
			<div class="entry">
				<div id="entry">
					<?php if (get_option('vfhky_ad_r') == '关闭') { ?>
					<?php { echo ''; } ?>
					<?php } else { ?>
						<div class="pd_r">
							<div id="pd_r_1">图片正在加载中……</div>
						</div>
						<s></s>
					<?php } ?>
					<?php the_content('Read more...'); ?>
				<?php wp_link_pages( array( 'before' => '<p class="pages">' . __( '日志分页:'), 'after' => '</p>' ) ); ?>
				<div class="clear"></div>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="entry_sb"></div>
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
					<li><?php the_tags('<strong>分类标签：</strong>', '，', ''); ?></li>
					<li><strong>赞助支持：</strong><font color="#ff0000">点击广告或者通过 <a href="http://me.alipay.com/vfhky" title=" 黄克业的博客_官方支付宝 " target="_blank" rel="external"><strong><u>支付宝</u></strong></a> 赞助本站，感谢支持！</font></li>
				</ul>
			</span>
			<div class="clear"></div>
		</div>
		<div class="entry_sb"></div>
		<?php if (get_option('vfhky_adt') == '关闭') { ?>
		<?php { echo ''; } ?>
		<?php } else {  ?>
			<div id="pd_h">
				<div id="pd_h_c"></div>
				<div class="clear"></div>
			</div>
			<div class="entry_box_b"></div>
		<?php } ?>
			<div class="context_b">
				<?php previous_post_link('【上篇】%link') ?><br/><?php next_post_link('【下篇】%link') ?>
			</div>
		<div class="ct"></div>
		<?php comments_template(); ?>
		<?php endwhile; else: ?>
		<?php endif; ?>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>