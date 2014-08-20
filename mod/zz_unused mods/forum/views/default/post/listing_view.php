<?php
	/**
	 * @file views/default/post/listing_view.php
	 * @brief Displays the post listing view 
	 */
?>

<div class='content_container listing_view'>
	<div class='listing_column_1 float_left'>
		<!-- Show the appropriated icons for each posts -->
		<?php  echo elgg_view('post/topic_icons',$vars); ?>
		
		<div class='float_left'>
			<!-- Link title of the entity -->
			<h4 class='float_left' ><a href="<?php echo $vars['entity']->getUrl(); ?>">	<?php	echo $vars['entity']->title; ?></a></h4>
			<div class='clearfloat'></div>
			
			<!-- Owner info that lies below the title -->
			<?php echo elgg_view('post/post_owner_info',$vars); ?>
			
			<!-- Displays the links for handle posts: edit, delete, close, stick, important  -->
			<?php echo elgg_view('post/handle_post_links',$vars); ?>
		</div>
	</div>
	
	<!-- Last comment info -->
	<div class='listing_column_2 float_left'><?php echo elgg_view('post/last_comment_info',$vars); ?></div>
	
	<!-- Comments counter -->
	<div class='listing_counters_column float_left'><?php echo get_comments($vars['entity']->guid,true); ?></div>
	
	<?php
		
		if (trigger_plugin_hook('views_counting_system','plugin')) {
			if (get_plugin_setting('add_views_counting_system','forum') != 'no') {
				$params['entity'] = $vars['entity'];
				$views_counter = trigger_plugin_hook('get_views_counter_hook','plugin',$params);
?>
				<!-- Views counter column -->
				<div class='listing_counters_column float_left'><?php echo $views_counter; ?></div>
<?php
			}
		}
	?>

	
	<?php
		if (trigger_plugin_hook('rating_system','plugin')) {
			if (get_plugin_setting('add_rating_system','forum')!='no') {
	?>
				<div class='listing_counters_column float_left'><?php echo elgg_view('rating',$vars); ?></div>
	<?php
			}
		}
	?>
	
	<div class='clearfloat'></div>	
</div>