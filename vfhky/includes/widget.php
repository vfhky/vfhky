<?php
// 最新评论
class comments extends WP_Widget{
    function comments(){
		$widget_options = array('classname'=>'set_contact','description'=>'主题自带的最新评论');
		$this->WP_Widget(false,'主题小工具&nbsp;&nbsp;&nbsp;&nbsp;最新评论',$widget_options);
    }
	function widget($instance){
		include("r_comments.php");
?>
<?php
}
}
add_action('widgets_init',create_function('', 'return register_widget("comments");'));

// 全部博客目录分类
class categories_s extends WP_Widget{
    function categories_s(){
		$widget_options = array('classname'=>'set_contact','description'=>'主题自带的全部分类');
		$this->WP_Widget(false,'主题小工具&nbsp;&nbsp;&nbsp;&nbsp;全部分类',$widget_options);
    }
	function widget($instance){
		include("s_category.php");
?>
<?php
}
}
add_action('widgets_init',create_function('', 'return register_widget("categories_s");'));

// 侧边广告
class ads extends WP_Widget{
    function ads(){
		$widget_options = array('classname'=>'set_contact','description'=>'主题自带的侧边广告，添加后需到主题设置中添加广告代码');
		$this->WP_Widget(false,'主题小工具&nbsp;&nbsp;&nbsp;&nbsp;侧边广告',$widget_options);
    }
	function widget($instance){
	echo '<div class="ad"><div id="ads_c"></div><div class="clear"></div><div class="box-bottom"></div></div>';
?>
<?php
}
}
add_action('widgets_init',create_function('', 'return register_widget("ads");'));

// tab菜单
class swt_tab1 extends WP_Widget{
	function swt_tab1(){
		$widget_options = array('classname'=>'set_contact','description'=>'主题自带的TAB菜单');
		$this->WP_Widget( false,'主题小工具&nbsp;&nbsp;&nbsp;&nbsp;tab菜单',$widget_options );
    }
	function widget($instance){
		include("tab.php");
?>
<?php
}
}
add_action('widgets_init',create_function('', 'return register_widget("swt_tab1");'));

// 本月十佳青年
class top_comments extends WP_Widget{
	function top_comments(){
		$widget_options = array('classname'=>'set_contact','description'=>'本月十佳青年');
		$this->WP_Widget( false,'主题小工具&nbsp;&nbsp;&nbsp;&nbsp;本月十佳青年',$widget_options );
    }
	function widget($instance){
		include("top_comment.php");
?>
<?php
}
}
add_action('widgets_init',create_function('', 'return register_widget("top_comments");'));
