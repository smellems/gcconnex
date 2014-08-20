<?php
	/**
	 * @file views/default/forum/components/rating_system_column.php
	 * @brief Includes a rate average column if there is some rating system enabled
	 */

	if (trigger_plugin_hook('rating_system','plugin')) {
		if (get_plugin_setting('add_rating_system','forum')!='no') {
?>
			<div class="listing_counters_column float_left"><?php echo elgg_echo('forum:rate_avg');?></div>
<?php		
		}
	}
?>