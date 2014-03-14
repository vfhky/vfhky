<?php
$themename = "VFHKY";
$shortname = "vfhky";
$categories	= get_categories('hide_empty=0&orderby=name');
$wp_cats = array();
foreach	($categories as	$category_list ) {
	   $wp_cats[$category_list->cat_ID]	= $category_list->cat_name;
}
//Stylesheets Reader $alt_stylesheet_path = TEMPLATEPATH	. '/styles/';
$alt_stylesheets = array();
if ( is_dir($alt_stylesheet_path) )	{
	if ($alt_stylesheet_dir	= opendir($alt_stylesheet_path)	) {
		while (	($alt_stylesheet_file =	readdir($alt_stylesheet_dir)) !== false	) {
			if(stristr($alt_stylesheet_file, ".css") !== false)	{
				$alt_stylesheets[] = $alt_stylesheet_file;
			}
		}
	}
}

$number_entries	= array("选择数量:","1","2","3","4","5","6","7","8","9","10", "12","14", "16", "18", "20" );
$options = array (
array( "name" => $themename." Options",
	   "type" => "title"),

//1. CMS布局首页设置
	array( "name" => "首页CMS布局",
		   "type" => "section"),
	array( "type" => "open"),

	array( "name" => "首页左侧分类",
				"desc" => "根据右边提示输入ID，例如输入'1,2'",
				"id" =>	$shortname."_catl",
				"type" => "text",
				"std" => "1,2"),

	array( "name" => "首页右侧分类ID设置",
				"desc" => "根据右边提示输入ID，例如输入'1,2'",
				"id" =>	$shortname."_catr",
				"type" => "text",
				"std" => "3,4"),

	array( "name" => "每个分类所要显示的文章数",
				"desc" => "默认显示4篇",
				"id" =>	$shortname."_cat_n",
				"type" => "text",
				"std" => "4"),

	array( "name" => "输入幻灯片处的滚动文章的分类ID",
				"desc" => "多个ID用英文逗号＂,＂隔开",
				"id" =>	$shortname."_roll",
				"type" => "text",
				"std" => "1,2,3"),

	array( "name" => "滚动文章显示的篇数",
				"desc" => "默认20篇",
				"id" =>	$shortname."_roll_n",
				"type" => "text",
				"std" => "20"),

	array( "name" => "首页是否显示最新日志",
				"desc" => "默认显示",
				"id" =>	$shortname."_new_p",
				"type" => "select",
				"std" => "关闭",
				"options" => array("显示", "关闭")),

	array( "name" => "最新日志显示的篇数",
				"desc" => "默认显示4篇",
				"id" =>	$shortname."_new_post",
				"std" => "4",
				"type" => "select",
				"options" => $number_entries),

	array( "name" => "输入最新文章排除的分类ID",
				"desc" => "比如：-1,-2,-3<br/>多个ID用英文逗号隔开",
				"id" =>	$shortname."_new_exclude",
				"type" => "text",
				"std" => ""),


//2. 综合功能设置
	array( "type" => "close"),
	array( "name" => "综合功能设置",
		   "type" => "section"),
	array( "type" => "open"),

	array( "name" => "是否显示LOGO",
				"desc" => "默认显示",
				"id" =>	$shortname."_logo",
				"type" => "select",
				"std" => "关闭",
				"options" => array("显示", "关闭")),

	array( "name" => "特色图片功能",
				"desc" => "默认闭关。开启后，本地上传图片，会自动生成三张裁剪后的缩略图，选择作为特色图像，主题自动调用裁剪后的缩略图",
				"id" =>	$shortname."_cut_img",
				"type" => "select",
				"std" => "开启",
				"options" => array("关闭", "开启")),
			
	array( "name" => "暗箱放大特效",
				"desc" => "默认开启",
				"id" =>	$shortname."_pirobox",
				"type" => "select",
				"std" => "关闭",
				"options" => array("开启", "关闭")),

	array( "name" => "正文底部相关文章",
				"desc" => "默认显示",
				"id" =>	$shortname."_related",
				"type" => "select",
				"std" => "关闭",
				"options" => array("显示", "关闭")),

	array( "name" => "输入从侧边固定分类排除的分类ID",
				"desc" => "比如：-1,-2,-3多个ID用英文逗号＂,＂隔开",
				"id" =>	$shortname."_cat_exclude",
				"type" => "text",
				"std" => ""),

	array( "name" => "建站日期",
				"desc" => "日期格式：2012-06-12",
				"id" =>	$shortname."_builddate",
				"type" => "text",
				"std" => "2012-06-12"),


//3. SEO设置
	array( "type" => "close"),
	array( "name" => "网站SEO设置及流量统计",
	   		"type" => "section"),
	array( "type" => "open"),

	array( "name" => "首页描述（Description）",
				"desc" => "",
				"id" =>	$shortname."_description",
				"type" => "textarea",
				"std" => "输入你的网站描述，一般不超过200个字符"),

	array( "name" => "首页关键词（KeyWords）",
				"desc" => "",
				"id" =>	$shortname."_keywords",
				"type" => "textarea",
				"std" => "输入你的网站关键字，一般不超过100个字符"),

	array("name" =>	"流量统计代码",
				"desc" => "",
				"id" =>	$shortname."_track_code",
				"type" => "textarea",
				"std" => ""),


//4. 公告设置
	array( "type" => "close"),
	array( "name" => "公告设置",
				"type" => "section"),
	array( "type" => "open"),

	array( "name" => "是否开启侧边栏公告",
				"desc" => "默认开启",
        "id" => $shortname."_gg",
        "type" => "select",
        "std" => "Hide",
        "options" => array("Display", "Hide")),

	array( "name" => "输入公告内容",
        "desc" => "支持html代码，可用&lt;br/&gt;换行",
        "id" => $shortname."_ggao",
        "type" => "textarea",
        "std" => "使用主题有任何问题请到黄克业的博客中搜索相关教程或在留言板留言，博客专用QQ群24385396"),


//5. 微博及订阅设置
	array( "type" => "close"),
	array( "name" => "微博及订阅设置",
			"type" => "section"),
	array( "type" => "open"),

	array( "name" => "是否开启关注本站小工具",
				"desc" => "默认开启",
        "id" => $shortname."_gzbz",
        "type" => "select",
        "std" => "Hide",
        "options" => array("Display", "Hide")),

   array("name" => "需要展示的QQ号",
        "desc" => "",
        "id" => $shortname."_qq",
        "type" => "text",
        "std" => "546836353"),

   array("name" => "输入QQ邮我功能的地址",
        "desc" => "",
        "id" => $shortname."_email",
        "type" => "text",
        "std" => "http://mail.qq.com/cgi-bin/qm_share?t=qm_mailme&email=Dzo7OTc8OTw6PE9_fiFsYGI"),

 	array("name" => "输入腾讯微博地址",
        "desc" => "",
        "id" => $shortname."_qqmblog",
        "type" => "text",
        "std" => "http://t.qq.com/bloghky"),

   array("name" => "输入新浪微博地址",
        "desc" => "",
        "id" => $shortname."_sinamblog",
        "type" => "text",
        "std" => "http://weibo.com/2454160852"),
        
   array("name" => "输入网站Feed地址",
        "desc" => "",
        "id" => $shortname."_rsssub",
        "type" => "text",
        "std" => "http://www.huangkeye.cn/feed"),

//6. 广告设置
	array( "type" => "close"),
	array( "name" => "广告设置",
			"type" => "section"),
	array( "type" => "open"),

	array( "name" => "是否显示首页中部广告",
			"desc" => "默认显示",
			"id" =>	$shortname."_adh",
			"type" => "select",
			"std" => "关闭",
			"options" => array("显示", "关闭")),

	array( "name" => "输入首页中部广告代码",
			"desc" => "",
			"id" =>	$shortname."_adh_c",
			"type" => "textarea",
			"std" => "<script type='text/javascript'>
var sogou_ad_id=233329;
var sogou_ad_height=90;
var sogou_ad_width=728;
</script>
<script language='JavaScript' type='text/javascript' src='http://images.sohu.com/cs/jsfile/js/c.js'></script>"),

	array( "name" => "输入首页侧边广告代码(小工具)",
			"desc" => "",
			"id" =>	$shortname."_adsc",
			"type" => "textarea",
			"std" => "<script type='text/javascript'>
var sogou_ad_id=154732;
var sogou_ad_height=250;
var sogou_ad_width=250;
</script>
<script language='JavaScript' type='text/javascript' src='http://images.sohu.com/cs/jsfile/js/c.js'></script>
"),

	array( "name" => "是否显示评论框上方广告",
			"desc" => "默认显示",
			"id" =>	$shortname."_adc",
			"type" => "select",
			"std" => "关闭",
			"options" => array("显示", "关闭")),

	array( "name" => "输入评论框上方广告代码",
			"desc" => "",
			"id" =>	$shortname."_ad_c",
			"type" => "textarea",
			"std" => "<script type='text/javascript'>
var sogou_ad_id=233330;
var sogou_ad_height=60;
var sogou_ad_width=640;
</script>
<script language='JavaScript' type='text/javascript' src='http://images.sohu.com/cs/jsfile/js/c.js'></script>"),

	array( "name" => "是否显示正文上面的广告",
			"desc" => "默认显示",
			"id" =>	$shortname."_ad_r",
			"type" => "select",
			"std" => "关闭",
			"options" => array("显示", "关闭")),

	array( "name" => "输入正文上面的广告代码",
			"desc" => "",
			"id" =>	$shortname."_ad_rc",
			"type" => "textarea",
			"std" => "<script type='text/javascript'>
var sogou_ad_id=233331;
var sogou_ad_height=250;
var sogou_ad_width=300;
</script>
<script language='JavaScript' type='text/javascript' src='http://images.sohu.com/cs/jsfile/js/c.js'></script>
"),

	array( "name" => "是否显示正文底部广告",
			"desc" => "默认显示",
			"id" =>	$shortname."_adt",
			"type" => "select",
			"std" => "关闭",
			"options" => array("显示", "关闭")),

	array( "name" => "输入正文底部广告代码",
			"desc" => "",
			"id" =>	$shortname."_adtc",
			"type" => "textarea",
			"std" => "<script type='text/javascript'>
var sogou_ad_id=233330;
var sogou_ad_height=60;
var sogou_ad_width=640;
</script>
<script language='JavaScript' type='text/javascript' src='http://images.sohu.com/cs/jsfile/js/c.js'></script>"),

	array( "type" => "close") );
	
function mytheme_add_admin() {
	global $themename, $shortname, $options;
	if ( $_GET['page'] == basename(__FILE__) ) {
		if ( 'save'	== $_REQUEST['action'] ) {
			foreach	($options as $value) { update_option( $value['id'], $_REQUEST[	$value['id'] ] ); }
			foreach	($options as $value) {
				if(	isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'],	$_REQUEST[ $value['id']	]  ); }
				else { delete_option( $value['id'] ); }
			}
			header("Location: admin.php?page=theme_options.php&saved=true");
			die;
		}
		else if( 'reset' ==	$_REQUEST['action']	) {
			foreach	($options as $value) { delete_option( $value['id']	); }
			header("Location: admin.php?page=theme_options.php&reset=true"); die;
		}
	}
	add_theme_page($themename."	Options", "主题设置", 'edit_themes', basename(__FILE__), 'mytheme_admin'); }

	function mytheme_add_init()	{
		$file_dir=get_bloginfo('template_directory');
		wp_enqueue_style("functions", $file_dir."/includes/options/options.css", false,	"1.0", "all");
		wp_enqueue_script("rm_script", $file_dir."/includes/options/rm_script.js", false, "1.0");
	}

	function mytheme_admin() {
		global $themename, $shortname, $options; $i=0;
		if ( $_REQUEST['saved']	) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' 主题设置已保存</strong></p></div>';
		if ( $_REQUEST['reset']	) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' 主题已重新设置</strong></p></div>';
?>
	<div class="wrap rm_wrap">
		<h2>主题 [VFHKY] 设置</h2> <p>当前主题的版本是: 
			 <?php
				 $currentversion = get_themeversion();
				 echo ' ['.$currentversion[1]."]&nbsp;&nbsp;主题最新版本是: [".$currentversion[0]."]&nbsp;&nbsp;";
				 if( $currentversion[0] > $currentversion[1] )
				 		echo "&nbsp;&nbsp;<font color=#FF0000>当前主题存在bug，请立即更新主题!</font>";
				 elseif( $currentversion[0] = $currentversion[1] )
				 		echo "&nbsp;&nbsp;<font color=#00FF00>恭喜您，当前主题与远端主题版本一致!</font>";
				 else
				 		echo "&nbsp;&nbsp;<font color=#FF0000>远端主题版本出错，请联系vfhky!</font>";
			 ?><br/>
			 主题作者:<a href="http://www.huangkeye.cn"	target="_blank"> vfhky</a> <font style="font-size:20px;"color=#ff0000><strong> &hearts; </strong></font> <font color=#000>捐助我，支付宝：<font color=#21759b><strong><a href="https://me.alipay.com/vfhky"	target="_blank">点此捐助</a></strong></font></font>	| <a href="http://www.huangkeye.cn/tag/博客成长录" target="_blank">查看主题更新及使用教程</a></p>
		
		<div class="rm_opts"> <form method="post"> <?php foreach ($options	as $value) {
			switch ( $value['type']	) {
				case "open": ?>
					<?php break;
				case "close": ?>
					</div> </div> <br/>
					<?php break;
				case "title": ?>
					<?php break;
				case 'text': ?>
					<div class="rm_input rm_text"> 	<label for="<?php echo $value['id']; ?>"><?php echo	$value['name'];	?></label> 	<input name="<?php echo	$value['id']; ?>" id="<?php	echo $value['id']; ?>" type="<?php echo	$value['type'];	?>"	value="<?php if	( get_settings(	$value['id'] ) != "") {	echo stripslashes(get_settings(	$value['id'])  ); }	else { echo	$value['std']; } ?>" />  <small><?php echo $value['desc']; ?></small><div class="clearfix"></div></div>
					 <?php break;
				case 'textarea': ?>
					<div class="rm_input rm_textarea"> 	<label for="<?php echo $value['id']; ?>"><?php echo	$value['name'];	?></label> 	<textarea name="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" cols="" rows=""><?php	if ( get_settings( $value['id']	) != "") { echo	stripslashes(get_settings( $value['id']) );	} else { echo $value['std']; } ?></textarea>  <small><?php echo $value['desc']; ?></small><div class="clearfix"></div></div>
					<?php break;
				case 'select': ?>
					<div class="rm_input rm_select"> 	<label for="<?php echo $value['id']; ?>"><?php echo	$value['name'];	?></label>
					<select	name="<?php	echo $value['id']; ?>" id="<?php echo $value['id'];	?>"> <?php foreach ($value['options'] as	$option) { ?> 		<option	<?php if (get_settings(	$value['id'] ) == $option) { echo 'selected="selected"'; } ?>><?php	echo $option; ?></option><?php } ?> </select>
					<small><?php echo $value['desc']; ?></small><div class="clearfix"></div> </div>
					<?php break;
				case "checkbox": ?>
					<div class="rm_input rm_checkbox"> 	<label for="<?php echo $value['id']; ?>"><?php echo	$value['name'];	?></label>
					<?php if(get_option($value['id'])){	$checked = "checked=\"checked\""; }else{ $checked =	"";} ?> <input type="checkbox" name="<?php echo	$value['id']; ?>" id="<?php	echo $value['id']; ?>" value="true"	<?php echo $checked; ?>	/>
					<small><?php echo $value['desc']; ?></small><div class="clearfix"></div>  </div>
					<?php break;
				case "section":
					$i++;
					?>
					<div class="rm_section"> <div class="rm_title"><h3><img src="<?php bloginfo('template_directory')?>/includes/options/clear.png" class="inactive"	alt="""><?php echo $value['name']; ?></h3><span	class="submit"><input name="save<?php echo $i; ?>" type="submit" value="保存设置" /> </span><div	class="clearfix"></div></div> <div class="rm_options">
					<?php break;
						} }
					?>
<?php
function show_id() {
	global $wpdb;
	$request = "SELECT $wpdb->terms.term_id, name FROM $wpdb->terms	";
	$request .=	" LEFT JOIN	$wpdb->term_taxonomy ON	$wpdb->term_taxonomy.term_id = $wpdb->terms.term_id	";
	$request .=	" WHERE	$wpdb->term_taxonomy.taxonomy =	'category' ";
	$request .=	" ORDER	BY term_id asc";
	$categorys = $wpdb->get_results($request);
	foreach	($categorys	as $category) {
		$output	= '<ul>'.$category->name."&nbsp;&nbsp;ID= <em>".$category->term_id.'</em> </ul>';
		echo $output;
	}
}
?>
 <span class="show_id"><h4>站点所有分类ID</h4><?php	show_id();?></span>
<input type="hidden" name="action" value="save"	/>
</form>
<form method="post">
<p class="submit">
<input name="reset"	type="submit" value="恢复默认设置" />
<input type="hidden" name="action" value="reset" />
</p>
</form>
<p>提示：此按钮将恢复主题初始状态，您的所有设置将消失！</p>
 </div>
<?php
}
?>
<?php
function mytheme_wp_head() {
	$stylesheet	= get_option('vfhky_alt_stylesheet');
	if($stylesheet != ''){?>
<?php }
}
add_action('wp_head', 'mytheme_wp_head');
add_action('admin_init', 'mytheme_add_init');
add_action('admin_menu', 'mytheme_add_admin');
?>