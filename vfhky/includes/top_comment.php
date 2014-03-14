<div id="top-comments">
	<h3>本月优秀青年</h3>
	<div class="box">
		<div class="box_comment">
			<?php
      global $wpdb;
			$counts = $wpdb->get_results("SELECT COUNT(comment_ID) AS cnt, comment_author, comment_author_url, comment_author_email FROM (SELECT * FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->posts.ID=$wpdb->comments.comment_post_ID) WHERE comment_date > date_sub( NOW(), INTERVAL 30 DAY ) AND user_id='0' AND comment_author_email != '' AND post_password='' AND comment_approved='1' AND comment_type='') AS tempcmt GROUP BY comment_author_email ORDER BY cnt DESC LIMIT 15");
			foreach ($counts as $count) {
			$a = get_bloginfo('wpurl') . '/avatar/' . md5(strtolower($count->comment_author_email)) . '.jpg';
			$c_url = $count->comment_author_url;
			$mostactive .= '<ul><li class="mostactive">' . '<a href="http://www.huangkeye.cn/go.php?url='. $c_url . '" rel="external nofollow" target="_blank"><img src="' . $a . '" alt="' . $count->comment_author . '（共留下 '. $count->cnt . ' 个脚印）" title="' . $count->comment_author . '（共留下 '. $count->cnt . ' 个脚印）" class="avatar" width="39" height="39"/></a></li></ul>';
			}
			echo $mostactive;
			?>
			<div class="clear"></div>
		</div>
	</div>
	<div class="box-bottom">
	</div>
</div>