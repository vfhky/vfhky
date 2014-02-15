<div id="tab-reader-hot-random">
	<ul class="htotabs">
		<li class="widget2"><span class="selected">本季热文</span></li>
		<li class="widget2"><span>读者热评</span></li>
		<li class="widget2"><span>最新文章</span></li>
		<li class="widget2"><span>博客统计</span></li>
	</ul>
  <div id="tab-content">
		<ul><?php simple_get_most_viewed(9,90); ?></ul>
		<ul><?php get_most_viewed('',9,42,true,true);?></ul>
		<ul><?php new_article(9); ?></ul>
		<ul>
			<li>博客文章：<?php $count_posts = wp_count_posts(); echo $published_posts = $count_posts->publish;?>篇</li>
			<li>博客评论：<?php global $wpdb;echo $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->comments");?>条</li>
			<li>博客分类：<?php echo $count_categories = wp_count_terms('category'); ?>个</li>
			<li>博客标签：<?php echo $count_tags = wp_count_terms('post_tag'); ?>个</li>
			<li>博客友链：<?php $link = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->links"); echo $link; ?>个</li>
			<li>安全运行：<?php
								 $blog_time_common = (time()-strtotime(get_option('swt_builddate')));
								 $blog_time_year = floor($blog_time_common/86400/360);	//整数年
								 $blog_time_month = floor($blog_time_common/86400/30) - $blog_time_year*12;	//整数月
								 $blog_time_days = floor($blog_time_common/86400) - $blog_time_year*360 - $blog_time_month*30;	//整数天
								 $blog_time_diff = floor($blog_time_common/86400);	//总的天数
								 echo $blog_time_year."年".$blog_time_month."月".$blog_time_days."日（共计".$blog_time_diff."天）";
						   ?>
			</li>
			<li>注册用户：<?php $s=$wpdb->get_var("select count(ID) from $wpdb->users");echo $s; ?>人</li>
			<li><?php echo get_num_queries();?>次查询： <?php echo timer_stop() ;?>  秒</li>
			<li>数据版本：<?php echo date("Y-m-d H:i",strtotime(get_lastpostdate())); ?></li>
		</ul>
	</div>
</div>
<div class="box-bottom"></div>