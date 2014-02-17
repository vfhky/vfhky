<?php
if (get_option('swt_cut_img') == '关闭') { echo ''; } 
else { add_image_size('thumbnail', 140, 100, true); } 
?>
<?php

//1、移除头部多余信息
remove_action('wp_head','wp_generator');//禁止在head泄露wordpress版本号
remove_action('wp_head','rsd_link');//移除head中的rel="EditURI"
remove_action('wp_head','wlwmanifest_link');//移除head中的rel="wlwmanifest"
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );//rel=pre
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0 );//rel=shortlink 
remove_action('wp_head', 'rel_canonical' );

//2、阻止站内文章pingback
function vfhky_no_self_ping( &$links ) {
$home = get_option( 'home' );
foreach ( $links as $l => $link )
if ( 0 === strpos( $link, $home ) )
unset($links[$l]);
}
add_action( 'pre_ping', 'vfhky_no_self_ping' );

//3、禁用半角符号自动转换为全角
remove_filter('the_content', 'wptexturize');

//4、禁止自动保存和修改历史记录
remove_action('pre_post_update', 'wp_save_post_revision');
add_action('wp_print_scripts', 'no_autosave');
function no_autosave() {
    wp_deregister_script('autosave');
}

include ("includes/theme_options.php");
include ("includes/widget.php");
require 'theme-update-checker.php';
$example_update_checker = new ThemeUpdateChecker(
    'vfhky',
    'http://www.huangkeye.cn/upgrade/info.json'
);
if (function_exists('register_sidebar')) {
    register_sidebar(array(
        'name' => '全部页面小工具',
        'before_widget' => '',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3><div class="box">',
        'after_widget' => '</div>
    	<div class="box-bottom">
		</div>',
    ));
}
//自定义菜单
register_nav_menus(array(
    'header-menu' => __('导航自定义菜单') ,
    'footer-menu' => __('页角自定义菜单')
));
// This theme uses wp_nav_menu() in one location.
if (function_exists('register_nav_menu')) {
    register_nav_menu('mainmenu', '主导航');
    register_nav_menu('topmenu', '顶部导航');
}
if (!is_nav_menu('主导航') || !is_nav_menu('顶部导航')) {
    $menu_id_1 = wp_create_nav_menu('主导航');
    $menu_id_2 = wp_create_nav_menu('顶部导航');
    wp_update_nav_menu_item($menu_id_1, 0);
    wp_update_nav_menu_item($menu_id_2, 1);
}
//背景
add_custom_background();

//后台预览
add_editor_style('/css/editor-style.css');

//支持外链缩略图
if (function_exists('add_theme_support')) add_theme_support('post-thumbnails');

//5、抓取第一张图片
function catch_first_image() {
    global $post, $posts;
    $first_img = '';
    ob_start();
    ob_end_clean();
    $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
    $first_img = $matches[1][0];
    if (empty($first_img)) { //Defines a default image
        $random = mt_rand(1, 24);
        echo get_bloginfo('stylesheet_directory');
        echo '/images/random/' . $random . '.jpg';
    }
    return $first_img;
}

//6、禁止历史文章
remove_action('pre_post_update', 'wp_save_post_revision');
add_action('wp_print_scripts', 'disable_autosave');
function disable_autosave() {
wp_deregister_script('autosave'); 
}

//7、相册图片
function post_type_picture() {
register_post_type(
	'picture', 
	array( 'public' => true,
		'publicly_queryable' => true,
		'hierarchical' => false,
  	'labels'=>array(
			'name' => _x('相册', 'post type general name'),
			'singular_name' => _x('图片', 'post type singular name'),
			'add_new' => _x('添加图片', '图片'),
			'add_new_item' => __('添加图片'),
			'edit_item' => __('编辑图片'),
			'new_item' => __('新的图片'),
			'view_item' => __('预览图片'),
			'search_items' => __('搜索图片'),
			'not_found' =>  __('您还没有发布图片'),
			'not_found_in_trash' => __('回收站中没有图片'), 
			'parent_item_colon' => ''
		),
		'show_ui' => true,
		'menu_position'=>5,
		'supports' => array(
			'title',
			'author', 
			'excerpt',
			'thumbnail',
			'trackbacks',
			'editor', 
			'comments',
			'custom-fields',
			'revisions'	) ,
	)
);
}
add_action('init', 'post_type_picture');
function create_gallery_taxonomy() 
{
  $labels = array(
	  'name' => _x( '相册分类', 'taxonomy general name' ),
	  'singular_name' => _x( 'gallery', 'taxonomy singular name' ),
	  'search_items' =>  __( '搜索分类' ),
	  'all_items' => __( '全部分类' ),
	  'parent_item' => __( '父级分类目录' ),
		'parent_item_colon' => __( '父级分类目录:' ),
	  'edit_item' => __( '编辑相册分类' ), 
	  'update_item' => __( '更新' ),
	  'add_new_item' => __( '添加新相册分类' ),
	  'new_item_name' => __( 'New Genre Name' ),
  );
// Tags
	register_taxonomy(
		'picture_tags',
		'picture',
		array(
			'hierarchical' => false,
			'label' => '图片标签',
			'query_var' => true,
			'rewrite' => true
		)
	);
	register_taxonomy('gallery',array('picture'), array(
  	'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'gallery' ),
  ));
}
add_action( 'init', 'create_gallery_taxonomy', 0 );


//8、彩色标签云
function colorCloud($text) {
	$text = preg_replace_callback('|<a (.+?)>|i', 'colorCloudCallback', $text);
	return $text;
}

function colorCloudCallback($matches) {
	$text = $matches[1];
	$color = dechex(rand(0,16777215));
	$pattern = '/style=(\'|\")(.*)(\'|\")/i';
	$text = preg_replace($pattern, "style=\"color:#{$color};$2;\"", $text);
	return "<a $text>";
}
add_filter('wp_tag_cloud', 'colorCloud', 1);

//9、分页1
function pagination($query_string){
	global $posts_per_page, $paged;
	$my_query = new WP_Query($query_string ."&posts_per_page=-1");
	$total_posts = $my_query->post_count;
	if(empty($paged))$paged = 1;
	$prev = $paged - 1;							
	$next = $paged + 1;	
	$range = 6; // 修改数字,可以显示更多的分页链接
	$showitems = ($range * 2)+1;
	$pages = ceil($total_posts/$posts_per_page);
	if(1 != $pages){
		echo "<div class='pagination'>";
		echo ($paged > 2 && $paged+$range+1 > $pages && $showitems < $pages)? "<a href='".get_pagenum_link(1)."'>最前</a>":"";
		echo ($paged > 1 && $showitems < $pages)? "<a href='".get_pagenum_link($prev)."'>上一页</a>":"";		
		for ($i=1; $i <= $pages; $i++){
			if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )){
				echo ($paged == $i)? "<span class='current'>".$i."</span>":"<a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a>"; 
			}
		}
		echo ($paged < $pages && $showitems < $pages) ? "<a href='".get_pagenum_link($next)."'>下一页</a>" :"";
		echo ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) ? "<a href='".get_pagenum_link($pages)."'>最后</a>":"";
		echo "</div>\n";
	}
}
//10、分页2，taxonomy-gallery.php、taxonomy-picture_tags.php
if ( !function_exists('pagenavi') ) {
	function pagenavi( $p = 5 ) { // 取当前页前后各 2 页，根据需要改
		if ( is_singular() ) return; // 文章与插页不用
		global $wp_query, $paged;
		$max_page = $wp_query->max_num_pages;
		if ( $max_page == 1 ) return; // 只有一页不用
		if ( empty( $paged ) ) $paged = 1;
		if ( $paged > $p + 1 ) p_link( 1, '最前页' );
		if ( $paged > $p + 2 ) echo '... ';
		for( $i = $paged - $p; $i <= $paged + $p; $i++ ) { // 中间页
			if ( $i > 0 && $i <= $max_page ) $i == $paged ? print "<span class='page-numbers current'>{$i}</span> " : p_link( $i );
		}
		if ( $paged < $max_page - $p - 1 ) echo '... ';
		if ( $paged < $max_page - $p ) p_link( $max_page, '最后页' );
	}

	function p_link( $i, $title = '' ) {
		if ( $title == '' ) $title = "第 {$i} 页";
		echo "<a class='pagination' href='", esc_html( get_pagenum_link( $i ) ), "' title='{$title}'>{$i}</a> ";
	}
	next_posts_link("下页");
}

//11、正文索引
function article_index($content) {
    $matches = array();
    $ul_li = '';
    $r = "/<(h[2-5])>([^<]+)<\/(h[2-5])>/im";
    if (preg_match_all($r, $content, $matches)) {
        foreach ($matches[2] as $num => $title) {
            //if($num==0)
            if (true) {
                $content = str_replace($matches[0][$num], '<' . $matches[1][$num] . ' id="title-' . $num . '">' . $title . '</' . $matches[3][$num] . '>', $content);
            } else {
                $content = str_replace($matches[0][$num], '<div id="content_title"><' . $matches[1][$num] . ' id="title-' . $num . '">' . $title . '</' . $matches[3][$num] . '><span id="article-index-top"><a href="#article-index">top</a></span></div>', $content);
            }
            if ($matches[1][$num] == 'h2') $ul_li.= '<li class="level2"><a href="#title-' . $num . '" title="' . $title . '">' . mb_strimwidth(strip_tags($title) , 0, 26) . "</a></li>\n";
            else if ($matches[1][$num] == 'h3') $ul_li.= '<li class="level3"><a href="#title-' . $num . '" title="' . $title . '">' . mb_strimwidth(strip_tags($title) , 0, 20) . "</a></li>\n";
        }
    if(is_single()){$content =  '<div id="article-index">
					<div id="index-title"><span id="the-index-title">正文索引</span><span id="show-index">[ 隐藏 ]</span></div>
					<div id="index-ul"><ul>' . $ul_li . '</ul></div></div>'.$content;}
    }
    return $content;
}
add_filter("the_content", "article_index");

//12、各分类目录的文章数
function wt_get_category_count($input = '') {
    global $wpdb;
    if ($input == '') {
        $category = get_the_category();
        return $category[0]->category_count;
    } elseif (is_numeric($input)) {
        $SQL = "SELECT $wpdb->term_taxonomy.count FROM $wpdb->terms, $wpdb->term_taxonomy WHERE $wpdb->terms.term_id=$wpdb->term_taxonomy.term_id AND $wpdb->term_taxonomy.term_id=$input";
        return $wpdb->get_var($SQL);
    } else {
        $SQL = "SELECT $wpdb->term_taxonomy.count FROM $wpdb->terms, $wpdb->term_taxonomy WHERE $wpdb->terms.term_id=$wpdb->term_taxonomy.term_id AND $wpdb->terms.slug='$input'";
        return $wpdb->get_var($SQL);
    }
}

//13、文章归档
function archives_list_SHe() {
     global $wpdb,$month;
     $lastpost = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_date <'" . current_time('mysql') . "' AND post_status='publish' AND post_type='post' AND post_password='' ORDER BY post_date DESC LIMIT 1");
     $output = get_option('SHe_archives_'.$lastpost);
     if(empty($output)){
         $output = '';
         $wpdb->query("DELETE FROM $wpdb->options WHERE option_name LIKE 'SHe_archives_%'");
         $q = "SELECT DISTINCT YEAR(post_date) AS year, MONTH(post_date) AS month, count(ID) as posts FROM $wpdb->posts p WHERE post_date <'" . current_time('mysql') . "' AND post_status='publish' AND post_type='post' AND post_password='' GROUP BY YEAR(post_date), MONTH(post_date) ORDER BY post_date DESC";
         $monthresults = $wpdb->get_results($q);
         if ($monthresults) {
             foreach ($monthresults as $monthresult) {
             $thismonth    = zeroise($monthresult->month, 2);
             $thisyear    = $monthresult->year;
             $q = "SELECT ID, post_date, post_title, comment_count FROM $wpdb->posts p WHERE post_date LIKE '$thisyear-$thismonth-%' AND post_date AND post_status='publish' AND post_type='post' AND post_password='' ORDER BY post_date DESC";
             $postresults = $wpdb->get_results($q);
             if ($postresults) {
                 $text = sprintf('%s %d', $month[zeroise($monthresult->month,2)], $monthresult->year);
                 $postcount = count($postresults);
                 $output .= '<ul class="archives-list"><li><span class="archives-yearmonth">' . $text . ' &nbsp;(' . count($postresults) . '&nbsp;' . __('篇文章','freephp') . ')</span><ul class="archives-monthlisting">' . "\n";
             foreach ($postresults as $postresult) {
                 if ($postresult->post_date != '0000-00-00 00:00:00') {
                 $url = get_permalink($postresult->ID);
                 $arc_title    = $postresult->post_title;
                 if ($arc_title)
                     $text = wptexturize(strip_tags($arc_title));
                 else
                     $text = $postresult->ID;
                     $title_text = __('详细阅读 ','freephp') . '《' . wp_specialchars($text, 1) . '》';
                     $output .= '<li>' . mysql2date('d日', $postresult->post_date) . ':&nbsp;' . "<a href='$url' title='$title_text'>$text</a>";
                     $output .= '&nbsp;(' . $postresult->comment_count . ')';
                     $output .= '</li>' . "\n";
                 }
                 }
             }
             $output .= '</ul></li></ul>' . "\n";
             }
         update_option('SHe_archives_'.$lastpost,$output);
         }else{
             $output = '<div class="errorbox">'. __('Sorry, no posts matched your criteria.','freephp') .'</div>' . "\n";
         }
     }
     echo $output;
 }
 
//14、本季（或者年度）热文
function simple_get_most_viewed($posts_num=10, $days=90){
    global $wpdb;
    $sql = "SELECT ID , post_title , comment_count
           FROM $wpdb->posts
           WHERE post_type = 'post' AND post_status = 'publish' AND TO_DAYS(now()) - TO_DAYS(post_date) < $days
           ORDER BY comment_count DESC LIMIT 0 , $posts_num ";
    $posts = $wpdb->get_results($sql);
    $output = "";
    foreach ($posts as $post){
        $output .= "\n<li><a href= \"".get_permalink($post->ID)."\" rel=\"bookmark\" title=\"".$post->post_title."(".$post->comment_count."条评论)\" >".mb_strimwidth($post->post_title,0,34)."</a></li>";
    }
    echo $output;
} 

//15、最新文章
function new_article($number=10){
	global $post;
	$args = array( 'numberposts' => $number, 'offset'=> 0, 'caller_get_posts' => 20 );
	$myposts = get_posts( $args );
	foreach( $myposts as $post ){
	  $results .= '<li><a href='.get_permalink().' title=《'.get_the_title().'》  >'.mb_strimwidth(get_the_title(), 0, 34).' </a></li>' ;
    }
    echo $results;
}

//16、检测是否gravatar头像
function vfhky_checkgravatar($email){
	$hash = md5(strtolower(trim($email)));
	$uri = 'http://www.gravatar.com/avatar/' . $hash . '?d=404';
	$headers = @get_headers($uri);
	if (!preg_match("|200|", $headers[0])) {
		return 0;
	}
	else {return 1;}
}

//17、获取gravatar头像
function vfhky_avatar($email, $size, $default, $alt) {
    $alt = ('' == $alt) ? '' : $alt; //用于设置当鼠标移到头像上显示提示文字
    $f = md5(strtolower($email)); //根据email的值来生成一个md5变量值，作为本地.jpg头像的名字
    $a = get_bloginfo('wpurl') . '/avatar/' . $f . '.jpg'; //需要在根目录下面新建一个avatar文件夹
    $e = ABSPATH . 'avatar/' . $f . '.jpg'; //缓存的头像的绝对路径
    
    $t = 2592000; // 缓存有效期30天, 这里单位:秒
    if (empty($default)) $default = get_bloginfo('wpurl') . '/avatar/guest.png'; //设置默认头像
    
    if (!is_file($e) || (time() - filemtime($e)) > $t) {
    	if( vfhky_checkgravatar($email)==1 ){
        $g = 'http://www.gravatar.com/avatar/' . $f;
      	copy($g, $e);
      }
      else {$a = $default ;}
    }
    echo "<img title='{$alt}' alt='{$alt}' src='{$a}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";
}

//18、评论验证码
 function spam_provent_math(){
    $a=rand(5,15);
    $b=rand(5,15);
    echo "<input type='text' name='sum' id='sum'  size='22' tabindex='3' value='动手又动脑，哦也 ！' onfocus='if (this.value != \"\") {this.value = \"\";}' onblur='if (this.value == \"\") {this.value = \"动手又动脑，哦也 ！\";}' > = $a + $b （<font color='#0088DD'>防止机器人评论</font>）"
        ."<input type='hidden' name='a' value='$a'>"
        ."<input type='hidden' name='b' value='$b'>";
}
function spam_provent_pre($spam_result){
    $sum=$_POST['sum'];
    switch($sum){
        case $_POST['a']+$_POST['b']:break;
        case null:err(__('亲，算个结果撒') );break;
        default:err(__('算错啦⊙﹏⊙b汗') );
    }
    return $spam_result;
}
if (( !isset($user_ID) || (0 == $user_ID) ) && ( $comment_data['comment_type'] == '' ) ){
    add_filter('preprocess_comment','spam_provent_pre');
}

//19、评论相对时间
function time_diff($time_type) {
    switch ($time_type) {
        case 'comment': //如果是评论的时间
            $time_diff = current_time('timestamp') - get_comment_time('U');
            if ($time_diff < 60) {
                echo "发表于1分钟内";
            } else if ($time_diff <= 3600 && $time_diff >= 60) {
                $time_diff = '发表于' . floor($time_diff / 60) . '分钟前';
                echo $time_diff;
            } else comment_date('Y-m-d H:i');
            break;

        case 'post'; //如果是日志的时间
        $time_diff = current_time('timestamp') - get_the_time('U');
        if ($time_diff < 60) {
            echo "1分钟内";
        } else if ($time_diff <= 3600 && $time_diff >= 60) {
            $time_diff = '发表于' . floor($time_diff / 60) . '分钟前';
            echo $time_diff;
        } else the_time('Y-m-d H:i');
        break;
    }
}

//20、评论者回复信息列表
function vfhky_comment($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    global $commentcount, $wpdb, $post;
    if (!$commentcount) { //初始化楼层计数器
        $comments = $wpdb->get_results("SELECT * FROM $wpdb->comments WHERE comment_post_ID = $post->ID AND comment_type = '' AND comment_approved = '1' AND !comment_parent");
        $cnt = count($comments); //获取主评论总数量
        $page = get_query_var('cpage'); //获取当前评论列表页码
        $cpp = get_option('comments_per_page'); //获取每页评论显示数量
        if (ceil($cnt / $cpp) == 1 || ($page > 1 && $page == ceil($cnt / $cpp))) {
            $commentcount = $cnt + 1; //如果评论只有1页或者是最后一页，初始值为主评论总数
            
        } else {
            $commentcount = $cpp * $page + 1;
        }
    }
?>
   <li <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">
   <div id="div-comment-<?php comment_ID() ?>">
      <?php $add_below = 'div-comment'; ?>
		<div class="author_box">
			<div class="t" style="display:none;" id="comment-<?php comment_ID(); ?>"></div>
			<span id="avatar">
				<?php vfhky_avatar($comment->comment_author_email, '40', '', $comment->comment_author); ?>
			</span>
			<span  class="comment-author">
				<span class="comment-info"><strong><?php
    comment_author_link(); ?></strong>  <font color="#B2B2B2">[<span class="vfhkyipquery" data-ip="<?php echo $comment->comment_author_IP; ?>" >正在查询<img src="<?php echo get_bloginfo('template_url'); ?>/images/waiting.gif" alt="..." style="vertical-align:baseline;" /></span>]</font></span>
				<span class="reply">
					<?php
    if (!$parent_id = $comment->comment_parent) {
        switch ($commentcount) {
            case 2:
                echo "<font size='2px' color='#ff0000'>沙发</font>";
                --$commentcount;
                break;

            case 3:
                echo "<font size='2px' color='#ff0000'>板凳</font>";
                --$commentcount;
                break;

            case 4:
                echo "<font size='2px' color='#ff0000'>地板</font>";
                --$commentcount;
                break;

            default:
                printf('%1$s<font size="1px">F</font>', --$commentcount);
        }
    } ?>
				  <?php
    if ($depth > 1) {
        printf('<font size=1px>+%1$s</font>', $depth - 1);
    } ?></span>
			</span><br/>
		</div>
		<?php
    if ($comment->comment_approved == '0'): ?>
		您的评论正在等待审核中...
		<br/>
		<?php  endif; ?><?php comment_text() ?>
    <div class="datetime">
          <?php
    time_diff($time_type = 'comment'); ?><?php
    edit_comment_link('编辑 ', ' +', ''); ?>
					<?php
    if (is_user_logged_in()) {
        $url = get_bloginfo('url');
        echo '  <a id="delete-' . $comment->comment_ID . '" href="' . wp_nonce_url("$url/wp-admin/comment.php?action=deletecomment&amp;p=" . $comment->comment_post_ID . '&amp;c=' . $comment->comment_ID, 'delete-comment_' . $comment->comment_ID) . '"" >×删除</a> ';
    }
?>
					<span class="replyat"><?php
    comment_reply_link(array_merge($args, array(
        'reply_text' => '@回复',
        'add_below' => $add_below,
        'depth' => $depth,
        'max_depth' => $args['max_depth']
    ))); ?></span>
    </div>		
		<i class="lt"></i>
		<i class="rt"></i>
		<i class="lb"></i>
		<i class="rb"></i>
		<div class="clear"></div>
  </div>
<?php
}
function vfhky_end_comment() {
    echo '</li>';
}

//21、自动生成版权时间
function comicpress_copyright() {
    global $wpdb;
    $copyright_dates = $wpdb->get_results("
    SELECT
    YEAR(min(post_date_gmt)) AS firstdate,
    YEAR(max(post_date_gmt)) AS lastdate
    FROM
    $wpdb->posts
    WHERE
    post_status = 'publish'
    ");
    $output = '';
    if ($copyright_dates) {
        $copyright = "&copy; " . $copyright_dates[0]->firstdate;
        if ($copyright_dates[0]->firstdate != $copyright_dates[0]->lastdate) {
            $copyright.= '-' . $copyright_dates[0]->lastdate;
        }
        $output = $copyright;
    }
    return $output;
}

//22、密码保护提示
function password_hint($c) {
    global $post, $user_ID, $user_identity;
    if (empty($post->post_password)) return $c;
    if (isset($_COOKIE['wp-postpass_' . COOKIEHASH]) && stripslashes($_COOKIE['wp-postpass_' . COOKIEHASH]) == $post->post_password) return $c;
    if ($hint = get_post_meta($post->ID, 'password_hint', true)) {
        $url = get_option('siteurl') . '/wp-pass.php';
        if ($hint) $hint = '密码提示：' . $hint;
        else $hint = "请输入您的密码";
        if ($user_ID) $hint.= sprintf('欢迎进入，您的密码是：', $user_identity, $post->post_password);
        $out = <<<END
<form method="post" action="$url">
<p>这篇文章是受保护的文章，请输入密码继续阅读:</p>
<div>
<label>$hint<br/>
<input type="password" name="post_password"/></label>
<input type="submit" value="Submit" name="Submit"/>
</div>
</form>
END;
        return $out;
    } else {
        return $c;
    }
}
add_filter('the_content', 'password_hint');

//23、登录者留言信息
function WelcomeCommentAuthorBack($email = '') {
    if (empty($email)) {
        return;
    }
    global $wpdb;
    $past_30days = gmdate('Y-m-d H:i:s', ((time() - (24 * 60 * 60 * 30)) + (get_option('gmt_offset') * 3600)));
    $sql = "SELECT count(comment_author_email) AS times FROM $wpdb->comments
					WHERE comment_approved = '1'
					AND comment_author_email = '$email'
					AND comment_date >= '$past_30days'";
    $times = $wpdb->get_results($sql);
    $times = ($times[0]->times) ? $times[0]->times : 0;
    $message = $times ? sprintf(__('过去30天内您写了 <strong>%1$s</strong> 条留言，感谢关注！') , $times) : '亲，你已经好久发表评论了哦！';
    return $message;
}

//24、文章字数统计
function count_words($text) {
    global $post;
    if ('' == $text) {
        $text = $post->post_content;
        if (mb_strlen($output, 'UTF-8') < mb_strlen($text, 'UTF-8')) $output.= '字数：' . mb_strlen(preg_replace('/\s/', '', html_entity_decode(strip_tags($post->post_content))) , 'UTF-8');
        return $output;
    }
}

//25、去掉描述P标签
function deletehtml($description) {
    $description = trim($description);
    $description = strip_tags($description, "");
    return ($description);
}
add_filter('category_description', 'deletehtml');

//26、后台友链
add_filter( 'pre_option_link_manager_enabled', '__return_true' );

//27、自定义后台登陆样式
add_filter('login_headerurl', create_function(false, "return get_bloginfo( 'siteurl' );"));
add_filter('login_headertitle', create_function(false, "return get_bloginfo( 'sitename' );"));
add_action('login_head', 'my_custom_login_logo');
function my_custom_login_logo() {
    echo '<style type="text/css">
        h1 a { background-image:url(' . get_bloginfo('template_directory') . '/images/wordpress-logo.png) !important; }
    </style>';
}

//28、评论框上的表情调用
add_filter('smilies_src', 'custom_smilies_src', 1, 10);
function custom_smilies_src($img_src, $img, $siteurl) {
    return get_bloginfo('template_directory') . '/images/smilies/' . $img;
}

//29、三种音乐播放器
function myplayer($atts, $content=null){  
    extract(shortcode_atts(array("auto"=>'no',"loop"=>'no'),$atts));  
   return '<embed src="'.get_bloginfo("template_url").'/single_player.swf?soundFile='.$content.'&loop='.$loop.'&autostart='.$auto.'" type="application/x-shockwave-flash" wmode="transparent" allowscriptaccess="always" width="290" height="30">';  
}  
add_shortcode('smusic','myplayer'); 

function singleplayer1($atts, $content=null){   
extract(shortcode_atts(array("auto"=>'no',"loop"=>'no'),$atts));   
return '<embed src="'.get_bloginfo("template_url").'/single_player.swf?soundFile='.$content.'&bg=0xcccccc&leftbg=0x357dce&lefticon=0xFFFFFF&rightbg=0xf06a51&rightbghover=0xaf2910&righticon=0xFFFFFF&righticonhover=0xffffff&text=0x666666&slider=0x666666&track=0xFFFFFF&border=0x666666&loader=0xeeeeee&loop='.$loop.'&autostart='.$auto.'" type="application/x-shockwave-flash" wmode="transparent" allowscriptaccess="always" width="290" height="30">';
}   
add_shortcode('smusic1','singleplayer1'); 

function multilplayer($atts, $content=null) {
extract(shortcode_atts(array("auto"=>'no',"loop"=>'no'),$atts)); 
	return '<embed src="'.get_bloginfo("template_url").'/music.swf" flashvars="mp3='.$content.'&loop='.$loop.'&autostart='.$auto.'" type="application/x-shockwave-flash" wmode="transparent" width="240" height="20"></embed>';
}
add_shortcode('mmusic','multilplayer');

//30.1、BaiDuUrlAPI Service：$type, create表示long to short，query表示short to long
function bdurlAPI($type, $url){
		$baseurl = 'http://dwz.cn/'.$type.'.php';
		$ch=curl_init();
		curl_setopt($ch,CURLOPT_URL,$baseurl);
		curl_setopt($ch,CURLOPT_POST,true);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		if($type == 'create')
			$data=array('url'=>$url);
		else
			$data=array('tinyurl'=>$url);
		curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
		$strRes=curl_exec($ch);
		curl_close($ch);
		$arrResponse=json_decode($strRes,true);
		if($type == 'create')
			return $arrResponse['tinyurl'];
		else
			return $arrResponse['longurl'];
}
//30.2、评论者链接的网址重定向跳转
add_filter('get_comment_author_link', 'add_redirect_comment_link', 5);
add_filter('comment_text', 'add_redirect_comment_link', 99);
function add_redirect_comment_link($text = '') {
    $text = str_replace('href="', 'target="_blank" href="' . get_option('home') . '/go.php?url=', $text);
    $text = str_replace("href='", "target='_blank' href='" . get_option('home') . "/go.php?url=", $text);
    $text = str_replace('<a target="_blank" href="http://www.huangkeye.cn/go.php?url=#div-comment', '<a href="#div-comment', $text);
    return $text;
}

//31、获得真实访问ip
function vfhky_real_ip() {
    if (isset($_SERVER)) {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $aIps = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            foreach ($aIps as $sIp) {
                $sIp = trim($sIp);
                if ($sIp != 'unknown') {
                    $sRealIp = $sIp;
                    break;
                }
            }
        } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $sRealIp = $_SERVER['HTTP_CLIENT_IP'];
        } else {
            if (isset($_SERVER['REMOTE_ADDR'])) {
                $sRealIp = $_SERVER['REMOTE_ADDR'];
            } else {
                $sRealIp = '0.0.0.0';
            }
        }
    } else {
        if (getenv('HTTP_X_FORWARDED_FOR')) {
            $sRealIp = getenv('HTTP_X_FORWARDED_FOR');
        } elseif (getenv('HTTP_CLIENT_IP')) {
            $sRealIp = getenv('HTTP_CLIENT_IP');
        } else {
            $sRealIp = getenv('REMOTE_ADDR');
        }
    }
    return $sRealIp;
}

//32、后台登录提醒邮件中的地区、IP服务商等信息
function ipdatainfo($ip) {
		$url = "http://ip.taobao.com/service/getIpInfo.php?ip=";
		$data = json_decode(file_get_contents($url . $ip));
		$ipdata = $data->data;
		return $ipdata->country . $ipdata->region . $ipdata->city . $ipdata->isp;
}

//33、后台登陆成功提醒
function wp_login_notify() {
    date_default_timezone_set('PRC');
    $admin_email = get_bloginfo('admin_email');
    $to = $admin_email;
    $subject = '【' . get_option("blogname") . '】后台登录成功提醒';
    $message = '<p>尊敬的管理员，您的博客：【' . get_option("blogname") . '】已成功登陆后台！</p>' . '<p>登录者的具体信息如下：</p>' . '<p>登录名：' . $_POST['log'] . '</p>' . '<p>登录时间：' . date("Y-m-d H:i:s") . '</p>' . '<p>登录IP：' . vfhky_real_ip() . '    ' . ipdatainfo(vfhky_real_ip()) . '</p>';
    $wp_email = 'no-reply@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME']));
    $from = "From: \"" . get_option('blogname') . "\" <$wp_email>";
    $headers = "$from\nContent-Type: text/html; charset=utf-8\n";
    wp_mail($to, $subject, $message, $headers);
}
add_action('wp_login', 'wp_login_notify');

//34、后台登陆失败提醒
function wp_login_failed_notify() {
    date_default_timezone_set('PRC');
    $admin_email = get_bloginfo('admin_email');
    $to = $admin_email;
    $subject = '【' . get_option("blogname") . '】后台登录失败警告';
    $message = '<p>尊敬的管理员，您的博客：【' . get_option("blogname") . '】出现了后台登录失败的情况！</p>' . '<p>登录者的具体信息如下：</p>' . '<p>登录名：' . $_POST['log'] . '</p>' . '<p>登录密码：' . $_POST['pwd'] . '</p>' . '<p>登录时间：' . date("Y-m-d H:i:s") . '</p>' . '<p>登录IP：' . vfhky_real_ip() . '    ' . ipdatainfo(vfhky_real_ip()) . '</p>';
    $wp_email = 'no-reply@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME']));
    $from = "From: \"" . get_option('blogname') . "\" <$wp_email>";
    $headers = "$from\nContent-Type: text/html; charset=utf-8\n";
    wp_mail($to, $subject, $message, $headers);
}
add_action('wp_login_failed', 'wp_login_failed_notify');

//35、评论者邮件通知
function vfhky_mail_notify($comment_id) {
   $comment = get_comment($comment_id);//根据id取得评论的所有信息
   $content=$comment->comment_content;//取得评论的内容
   //对评论内容进行匹配
   $match_count=preg_match_all('/<a href="#comment-([0-9]+)?" rel="nofollow">/si',$content,$matchs);
   if($match_count>0){//如果匹配到了
       foreach($matchs[1] as $parent_id){//对每个子匹配都进行邮件发送操作
           vfhky_send_email($parent_id,$comment);//调用自定义的邮件发送函数
       }
   }elseif($comment->comment_parent!='0'){//如果没匹配到，有人故意删了@回复，则通过查找父级评论id来确定邮件发送对象to
       $parent_id=$comment->comment_parent;
       vfhky_send_email($parent_id,$comment);
   }else return;
}
add_action('comment_post', 'vfhky_mail_notify');
function vfhky_send_email($parent_id,$comment){//reply mail-notice by vfhky
   $adminEmail = get_option('admin_email'); //取得博主的邮箱
   $parent_comment=get_comment($parent_id);//取得被回复者的所有信息
   $author_email=trim($comment->comment_author_email);//取得评论者的邮箱
   $to = trim($parent_comment->comment_author_email);//取得被回复者的邮箱
   $spam_confirmed = $comment->comment_approved;
   if ($spam_confirmed != 'spam') {
       $wp_email = 'no-reply@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME'])); // 
       $subject = '尊敬的 ' . trim(get_comment($parent_id)->comment_author) . '，您在 [' . get_option("blogname") . '] 中的评论有了新的回复';
$message = '<b>尊敬的：' . trim(get_comment($parent_id)->comment_author) . ' </b><br/>
<HR style="FILTER: alpha(opacity=100,finishopacity=0,style=1)" width="100%" color=#987cb9 SIZE=3>
<font style="margin:0px 0px 0px 25px;">您之前在 [' . get_option("blogname") . '] 中的一篇文章《' . get_the_title($comment->comment_post_ID) . '》上发表了如下评论：</font>
<p style="background-color:#EEE;border: 1px solid #DDD; padding: 20px;margin: 6px 0px  20px 25px;">'
. nl2br(trim(get_comment($parent_id)->comment_content)). '
</p>
<b>回复人：' . trim($comment->comment_author) . ' </b><br/>
<HR style="FILTER: alpha(opacity=100,finishopacity=0,style=1)" width="100%" color=#987cb9 SIZE=3>
<font style="margin:0px 0px 0px 25px;">给您的回复如下：</font><p style="background-color:#EEE;border: 1px solid #DDD; padding: 20px;margin: 6px 0px  20px 25px;">'
. nl2br(trim($comment->comment_content)) .
' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a style="text-decoration:none;"  href="' . htmlspecialchars(get_comment_link($parent_id,array("type" => "all"))) . '" target="_blank">' .'[查看回复详情]</a></p>
<b>获取博客最新资讯：</b><br/>
<HR style="FILTER: alpha(opacity=100,finishopacity=0,style=1)" width="100%" color=#987cb9 SIZE=3>
<p style="background-color:#EEE;border: 1px solid #DDD; padding: 20px;margin: 15px 0px  15px 25px;">
新浪微博：<a style="text-decoration:none;"  href="'.stripslashes(get_option('swt_sinamblog')).'" target="_blank">'.stripslashes(get_option('swt_sinamblog')).'</a><br/>
腾讯微博：<a style="text-decoration:none;"  href="'.stripslashes(get_option('swt_qqmblog')).'" target="_blank">'.stripslashes(get_option('swt_qqmblog')).'</a><br/>
QQ邮箱订阅：<a style="text-decoration:none;"  href="http://mail.qq.com/cgi-bin/feed?u='.get_option("siteurl").'/feed" target="_blank">http://mail.qq.com/cgi-bin/feed?u='.get_option("siteurl").'/feed</a><br/>
Google+：<a style="text-decoration:none;"  href="https://plus.google.com/101192347122765496150?rel=author" target="_blank">vfhky</a><br/>
</p>

<div align="center">感谢您对 <a href="'.get_option("siteurl").'" target="_blank">黄克业的博客</a> 的支持！<br/>任何疑问，敬请访问 <a href="'.get_option("siteurl").'/contact" target="_blank">'.get_option(siteurl).'/contact</a><br/>
Copyright &copy;2012-'.date("Y").' All Rights Reserved</div>';
		 $message = convert_smilies($message);
     $from = "From: \"" . get_option('blogname') . "\" <$wp_email>";
     $headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
     wp_mail( $to, $subject, $message, $headers );
     }
 }

?>