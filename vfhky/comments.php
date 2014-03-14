<?php // Do not delete these lines
	if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');
	if (!empty($post->post_password)) { // if there's a password
		if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
			?>
			<p class="nocomments">必须输入密码，才能查看评论！</p>
			<?php
			return;
		}
	}
	$oddcomment = '';
?>
<?php if ($comments) : ?>
<?php
  /* Loop throught comments to count these totals */
  foreach ($comments as $comment)
?>
	<h2 id="comments">目前共有
		<?php
			$my_email = get_bloginfo ( 'admin_email' );
			$str = "SELECT COUNT(*) FROM $wpdb->comments WHERE comment_post_ID = $post->ID AND comment_approved = '1' AND comment_type = '' AND comment_author_email";
			$count_t = $post->comment_count;
			$count_v = $wpdb->get_var("$str != '$my_email'");
			$count_h = $wpdb->get_var("$str = '$my_email'");
			$count_r = $count_v - $count_h;
			echo "<font color='#ff0000'>",$count_t,"</font> 条评论，访客 <font color='#ff0000'>", $count_v,":",$count_h;
			if ($count_r>5) echo '-轻松超越';
			elseif ($count_r >0) echo '-小幅领先';
			elseif ($count_r ==0) echo '-持平';
			else echo '-小幅落后';	echo "</font> 博主";
		?>
	</h2>
<ol class="commentlist"><?php wp_list_comments('type=comment&callback=vfhky_comment&end-callback=vfhky_end_comment'); ?>
<?php $comment_pages = paginate_comments_links('echo=0');
  if ($comment_pages){ ?><div class="navigation_c"><div class="previous"><?php paginate_comments_links(); ?></div></div>
<?php } ?>
</ol>
<div class="navigation_space"></div>
 <?php else : // this is displayed if there are no comments so far ?>
	<?php if ('open' == $post->comment_status) : ?>
		<!-- If comments are open, but there are no comments. -->
	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<p class="nocomments">抱歉!评论已关闭.</p>
	<?php endif; ?>
	<?php endif; ?>
	<?php if (get_option('vfhky_adc') == '关闭') { ?>
	<?php { echo ''; } ?>
	<?php } else {  if (!is_page()){ ?>
		<!--评论框上面的图片-->
<div id="pd_h">
		<div id="pd_h_c1">正在加载中……</div>
		<div class="clear"></div>
</div>
<div class="entry_box_b"></div>
<?php }} ?>
	<?php if ('open' == $post->comment_status) : ?>
	<div id="respond_box">
	<div id="respond">
		<h3>发表评论</h3>
		<div class="cancel-comment-reply">
			<small><?php cancel_comment_reply_link(); ?></small>
			<div id="real-avatar">
				<?php if(!isset($_COOKIE['comment_author_email_'.COOKIEHASH]) && !$user_ID ){  global $user_email;echo get_avatar($user_email, 40);}?>
			</div>
		</div>
		<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
		<p><?php echo '您必须'; ?><a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>"> [ 登录 ] </a>才能发表留言！</p>
		<?php else : ?>
		<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
			<?php if ( $user_ID ) : ?>
			<p><div class="user_avatar"><?php vfhky_avatar(get_the_author_email(),'40','',$user_identity); ?></div><?php echo "<font color='#B2B2B2'>[ 登录人员 ]：</font>"; ?><a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo "<font color='#ff0000'>".$user_identity."</font>"; ?></a><br/>
			<a href="<?php echo wp_logout_url(get_permalink()); ?>" title="注销登录"><?php echo "<font color='#B2B2B2'>[ 注销登录 ]</font>"; ?></a>
			<?php elseif ( '' != $comment_author ): ?>
			<div class="author_avatar">			
				<?php vfhky_avatar($comment_author_email, '36' ,'',$comment_author);  ?>
				<?php echo '欢迎回来 <strong>'.$comment_author.'</strong>'; ?>
				<a href="javascript:toggleCommentAuthorInfo();" id="toggle-comment-author-info">[ 更改 ]</a><br/>
				<?php echo WelcomeCommentAuthorBack($comment_author_email); ?>
			</div>
			<script type="text/javascript" charset="utf-8">
				//<![CDATA[
				var changeMsg = "[ 更改 ]";
				var closeMsg = "[ 隐藏 ]";
				function toggleCommentAuthorInfo() {
					jQuery('#comment-author-info').slideToggle('slow', function(){
						if ( jQuery('#comment-author-info').css('display') == 'none' ) {
						jQuery('#toggle-comment-author-info').text(changeMsg);
						} else {
						jQuery('#toggle-comment-author-info').text(closeMsg);
						}
					});
				}
				jQuery(document).ready(function(){
					jQuery('#comment-author-info').hide();
				});
				//]]>
			</script>
			</p>
			<?php endif; ?>
			<?php if ( ! $user_ID ): ?>
			<div id="comment-author-info">
			<p>
			<input type="text" name="author" id="author" class="commenttext" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
			<label for="author">昵称<?php if ($req) echo " *"; ?></label>
			</p>
			<p>
			<input type="text" name="email" id="email" class="commenttext" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
			<label for="email">邮箱 * <a id="Get_Gravatar" title="查看如何申请一个自己的Gravatar全球通用头像" target="_blank" href="http://www.huangkeye.cn/cms/wordpress/5.html">（<font color="#0088DD">用于显示个性头像</font>）</a></label>
			</p>
			<p>
			<input type="text" name="url" id="url" class="commenttext" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
			<label for="url">网址</label>
			</p>
			<p><?php if(!isset($_COOKIE['comment_author_email_'.COOKIEHASH]))spam_provent_math();?></p>
			</div>
			<?php endif; ?>
			<div class="clear"></div>
		<p id="smiley"><?php include(TEMPLATEPATH . '/includes/smiley.php'); ?></p>
		<p><textarea name="comment" id="comment" tabindex="4"></textarea></p>
		<p>
			<input class="submit" name="submit" type="submit" id="submit" tabindex="5" value="提交"/>
			<input class="reset" name="reset" type="reset" id="reset" tabindex="6" value="<?php esc_attr_e( '重写' ); ?>" />
			<?php comment_id_fields(); ?>
		</p>
		<p><strong>XHTML：</strong> 开放Tag最大权限：支持 <code> &lt;span style=""&gt;</code> 标签<br/><strong>快捷提交：</strong> Ctrl+Enter<br/><span style="color:#ccc;"><strong>留言须知：</strong> 1.使用Gravatar头像，才能发表评论；</span><br/><span style="color:#ccc;margin-left:63px;">2.插入代码的方法：<a href="http://www.huangkeye.cn/mix/835.html" title="查看如何在评论中插入高亮代码" target="_blank"><span style="color:#ccc;">点击此处</span></a>；</span><br/><a href="http://www.huangkeye.cn/siteverify" title="查看 黑名单" target="_blank"><span style="color:#FF4500;margin-left:63px;">3.已开启广告黑名单功能，发现即拉黑广告网站！&rArr;查看&lArr;</span></a></p>
		</p>
		<script type="text/javascript">	//Crel+Enter
			$(document).keypress(function(e){
				if(e.ctrlKey && e.which == 13 || e.which == 10) { 
					$(".submit").click();
					document.body.focus();
				} else if (e.shiftKey && e.which==13 || e.which == 10) {
					$(".submit").click();
				}
			})
		</script>
		<?php do_action('comment_form', $post->ID); ?>
    </form>
	<div class="clear"></div>
    <?php endif; // If registration required and not logged in ?>
	</div>
	</div>
	<div class="respond_b"></div>
	<?php endif; // if you delete this the sky will fall on your head ?>