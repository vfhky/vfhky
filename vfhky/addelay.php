<?php wp_reset_query(); if ( is_home() || is_tag() || is_category() ) { ?>
<span id="pd_h_c_1">
	<?php echo stripslashes(get_option('vfhky_adh_c')); ?>
</span>
<script type="text/javascript">
document.getElementById("pd_h_c").innerHTML = document.getElementById("pd_h_c_1").innerHTML;
document.getElementById("pd_h_c_1").innerHTML = "";
</script>
<?php } ?>

<?php  wp_reset_query(); if (is_single()){ ?>
	<span id="pd_r_2"><?php echo stripslashes(get_option('vfhky_ad_rc')); ?></span>
	<span id="pd_h_c_1"><?php echo stripslashes(get_option('vfhky_adtc')); ?></span>
	<span id="pd_h_c_2"><?php echo stripslashes(get_option('vfhky_ad_c')); ?></span>
	<script type="text/javascript">
		document.getElementById("pd_r_1").innerHTML = document.getElementById("pd_r_2").innerHTML;
		document.getElementById("pd_r_2").innerHTML = "";
		document.getElementById("pd_h_c").innerHTML = document.getElementById("pd_h_c_1").innerHTML;
		document.getElementById("pd_h_c_1").innerHTML = "";
		document.getElementById("pd_h_c1").innerHTML = document.getElementById("pd_h_c_2").innerHTML;
		document.getElementById("pd_h_c_2").innerHTML = "";		
	</script>
<?php } ?> 
<?php  wp_reset_query(); if ( is_home() || (is_page() && !is_page('629')) || is_single() || is_search() ){ ?>
<span id="ads_c_1"><?php echo stripslashes(get_option('vfhky_adsc')); ?></span>
	<script type="text/javascript">
		document.getElementById("ads_c").innerHTML = document.getElementById("ads_c_1").innerHTML;
		document.getElementById("ads_c_1").innerHTML = "";
	</script>
<?php } ?>
<?php  wp_reset_query(); if ( is_single() ){ ?>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/google-code-prettify/prettify.js"></script>
	<script type="text/javascript">
		jQuery(document).ready(function () {
			jQuery("pre").addClass("prettyprint linenums");
			prettyPrint();
		});
	</script>
<?php } ?>