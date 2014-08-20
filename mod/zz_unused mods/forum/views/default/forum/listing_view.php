<?php
	/**
	 * @file views/default/forum/listing_view.php
	 * @brief Displays the forum listing view 
	 */
?>

<div class='content_container listing_view'>
	<div class='listing_column_1 listing_forum_height float_left'>
		<!-- Main forum star image -->
		<?php echo elgg_view('forum/main_forum_star',$vars); ?>
		
		<!-- Link title of the entity -->
		<h4 class="float_left" ><a href="<?php echo $vars['entity']->getUrl(); ?>"><?php	echo $vars['entity']->title; ?></a></h4>
	
		<!-- Edit/Delete button for the owner and admins -->
		<div class="float_left"><?php echo elgg_view('forum/forum_edit_button',$vars); ?></div>
		
		<div class="clearfloat"></div>
		
		<!-- Session description -->
		<div class='forum_description'><?php echo $vars['entity']->description; ?></div>
	</div>
	
	<!-- Last topic info -->
	<div class='listing_column_2 listing_forum_height float_left'><?php echo elgg_view('forum/last_topic_info',$vars); ?></div>
	
	<!-- Subforum counter -->
	<div class='listing_counters_column listing_height float_left'><?php echo get_subforums($vars['entity']->guid,array('recursive'=>true,'count'=>true)); ?></div>
	
	<!-- Topics counter -->
	<div class='listing_counters_column listing_height float_left'><?php echo get_posts($vars['entity']->guid,array('recursive'=>true,'count'=>true)); ?></div>
	
	<!-- Comments counter -->
	<div class='listing_counters_column listing_height float_left'><?php echo get_comments($vars['entity']->guid,true,true); ?></div>
	
	<div class='clearfloat'></div>
</div>