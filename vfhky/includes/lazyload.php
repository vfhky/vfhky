<script type="text/javascript" src="<?php bloginfo('template_directory');?>/js/lazyload.js"></script>
<script type="text/javascript">
	$(function() {          
    	$(".entry_box img,.entry_box_h img,#content img,#entry img,.entry_b img").not(".user_avatar img,.author_avatar img,.comment-info img").lazyload({
            effect:"fadeIn",
			failurelimit : 10
          });
    	});
</script>