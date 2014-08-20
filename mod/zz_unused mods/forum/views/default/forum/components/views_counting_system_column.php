<?php
	/**
	 * @file views/default/forum/components/views_counting_system_column.php
	 * @brief Includes a views couting system column if there is some views counting system enabled
	 */

	if (trigger_plugin_hook('views_counting_system','plugin')) {
		if (get_plugin_setting('add_view_counting_system','forum')=='yes') {
?>
			<div class="listing_counters_column float_left"><?php echo elgg_echo('forum:views');?></div>
<?php
		}
	}
?>