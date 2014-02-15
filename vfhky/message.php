<?php
/*
Template Name: 留言吧
*/
?>
<?php get_header(); ?>
<div id="content">
	<?php if (have_posts()): ?><?php while (have_posts()): the_post(); ?>
		<div id="map">
			<div class="browse">当前位置：<a title="返回首页" href="<?php
        echo get_settings('Home'); ?>/">首页</a> &gt; <?php
        the_title(); ?></div>
		</div>
	<div class="clear"></div>
	<div class="entry_box_s"><br/><h1 style="text-align:center"><font size="4px" color="#ff0000"><font color="#000000">【Show Time】</font> 年度最佳贡献奖<font color="#000000">【前24名】</font></font></h1>
		<?php
			$adminEmail = get_option('admin_email');
			$wall = $wpdb->get_results("SELECT COUNT(comment_ID) AS cnt, comment_author, comment_author_url, comment_author_email FROM (SELECT * FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->posts.ID=$wpdb->comments.comment_post_ID) WHERE comment_date > date_sub( NOW(), INTERVAL 24 MONTH ) AND user_id='0' AND comment_author_email != '$adminEmail' AND post_password='' AND comment_approved='1' AND comment_type='') AS tempcmt GROUP BY comment_author_email ORDER BY cnt DESC LIMIT 24");
			$maxNum = $wall[0]->cnt;
			foreach ($wall as $comment)
			{
				$width = round(40 / ($maxNum / $comment->cnt),2);//此处是对应的血条的宽度
				$avatar = get_bloginfo('wpurl') . '/avatar/' . md5(strtolower($comment->comment_author_email)) . '.jpg';
				if( $comment->comment_author_url ){
					$url = $comment->comment_author_url ;
					$mostactive.= '<li><a href="' . get_bloginfo('wpurl') . '/go.php?url=' . $url . '" title="' . $comment->comment_author . ' 【狂踩 ' . $comment->cnt . ' 次】" target="_blank" rel="external nofollow"><img src="' . $avatar . '" alt="' . $comment->comment_author . ' 【狂踩 ' . $comment->cnt . ' 次】" width="36px" height="36px" /><em>' . $comment->comment_author . '</em> <strong>+' . $comment->cnt . '</strong></br>' .mb_substr(str_replace("/","",str_replace("http://","","$url")),0,22). '</a></li>';
				}
				else {
					$mostactive.= '<li><a href="#" title="' . $comment->comment_author . ' 【狂踩 ' . $comment->cnt . ' 次】" ><img src="' . $avatar . '" alt="' . $comment->comment_author . ' 【狂踩 ' . $comment->cnt . ' 次】" width="36px" height="36px" /><em>' . $comment->comment_author . '</em> <strong>+' . $comment->cnt . '</strong></br>[忘了写网址]</a></li>';
				}
			}
			$output = "<ul class=\"readers-list\">".$mostactive."</ul>";
			echo $output;
			echo "<br/>被围观：";the_views();echo "+";
		?>
	</div>
	<div class="entry_sb_l"></div>
	<?php comments_template(); ?>
	<?php endwhile; else: ?>
		<?php endif; ?>
</div>
<?php get_sidebar(); ?> 	
<?php get_footer(); ?>