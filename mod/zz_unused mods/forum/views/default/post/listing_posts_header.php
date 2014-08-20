<?php
	/**
	 * @file views/default/post/listing_posts_header.php
	 * @brief Displays the header for a list of posts
	 */

	$class= ($vars['important_posts']) ? ('important_listing_header') : ('listing_header');
?>

<div class="<?php echo $class; ?>">
	<?php // Header title may be topics or important topics 
		$header_title = (!$vars['important_posts']) ? (elgg_echo('forum:topics')) : (elgg_echo('forum:important_topics'));
	?>
	<div class="listing_column_1 float_left"> <?php echo $header_title; ?></div>
	<div class="listing_column_2 float_left"><?php echo elgg_echo('forum:last_comment'); ?></div>
	<div class="listing_counters_column float_left"><?php echo elgg_echo('forum:comments'); ?></div>
	<?php // Include the views counter column if there is some views counting system enabled
		echo elgg_view('forum/components/views_counting_system_column',$vars);
		// Include the rate average column if there is some rating system enabled
		echo elgg_view('forum/components/rating_system_column',$vars);
	?>
	<div class="clearfloat"></div>
</div>

<?php // No sort options for important topics
	if (!$vars['important_posts']) {
		// Include the sort menu for the topics list
		echo elgg_view('forum/components/sort_by_options',$vars);
	}
?>