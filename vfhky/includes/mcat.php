<div class="random_r">
	<h3>同类最新</h3>
	<div class="box_r">
	<?php if ( is_single() ) : global $post;$categories = get_the_category();foreach ($categories as $category) : ?>
	    <ul> 
	        <?php $posts = get_posts('category='.$category->term_id.'&numberposts='.get_option('vfhky_mcat_n'));foreach($posts as $post) : ?>
			<li><a href="<?php the_permalink(); ?>"  title="《<?php echo get_the_title(); ?>》"><?php echo mb_strimwidth(get_the_title(), 0, 34);?></a></li>
	        <?php endforeach; ?>
	    </ul>
		<?php endforeach; endif; ?>
		<div class="clear"></div>
	</div>
	<div class="box-bottom">
	</div>
</div>