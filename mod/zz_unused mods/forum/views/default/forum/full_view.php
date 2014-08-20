<?php
	/**
	 * @file views/default/forum/full_view.php
	 * @brief Display the forum full view 
	 */
?>

<div class="forum forum_wrapper">
	<!-- Displays a star if It is a main forum -->
	<?php echo elgg_view('forum/main_forum_star',$vars); ?>
	
	<!-- Breadcrumbs -->
	<h4 class="float_left" ><?php echo get_breadcrumbs($vars['entity']->guid); ?></h4>
	
	<!-- Edit/delete button for forums -->
	<div class="float_left"><?php echo elgg_view('forum/forum_edit_button',$vars); ?></div>
	
	<div class="clearfloat"></div>

	<div class="forum_body">
		<!-- Listing forums -->
		<?php
			if ($forums = elgg_view('forum/list_forums',$vars)) {
				echo $forums;
				echo '<br />';
			}
		?>

		<!-- Listing important posts -->
		<?php 
			if ($important_topics = elgg_view('post/list_important_posts',$vars)) {
				echo $important_topics;
				echo '<br />';
			}
		?>		

		<!-- Listing posts -->
		<?php 
			if ($posts = elgg_view('post/list_posts',$vars)) {
				echo $posts;
				echo '<br />';
			}
		?>
	</div>
</div>