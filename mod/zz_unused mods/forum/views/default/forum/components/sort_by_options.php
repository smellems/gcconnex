<?php
	/**
	 * @file views/default/forum/components/sort_by_options.php
	 * @brief Displays the sort_by options for list topics 
	 */

	$views_counting_system = trigger_plugin_hook('views_counting_system','plugin');
	$rating_system = trigger_plugin_hook('rating_system','plugin');
	
	// There is some of those system then lets show a sort menu
	if ($views_counting_system || $rating_system) {
?>
		<div class="sort_by">
			<?php
				echo elgg_echo('forum:sort_by');
				$url = $vars['url'].'pg/forums/'.$vars['entity']->guid.'/';
				$sort_by = get_input('sort_by');
				
				if (($sort_by != 'most_recent_desc') && ($sort_by)) {
			?>
					<img class="sort_by_arrow" src="<?php echo $vars['url']; ?>/mod/forum/graphics/down_arrow.jpg" /><a href="<?php echo $url; ?>most_recent_desc"><?php echo elgg_echo('forum:most_recent'); ?></a>
			<?php
				} else {
			?>
					<img class="sort_by_arrow" src="<?php echo $vars['url']; ?>/mod/forum/graphics/up_arrow.jpg" /><a href="<?php echo $url; ?>most_recent_asc"><?php echo elgg_echo('forum:most_recent'); ?></a>
			<?php
				}
				
				if ($views_counting_system) {
					if ($sort_by != 'most_popular_desc') {
			?>
						,<img class="sort_by_arrow" src="<?php echo $vars['url']; ?>/mod/forum/graphics/down_arrow.jpg" /><a href="<?php echo $url; ?>most_popular_desc"><?php echo elgg_echo('forum:most_popular'); ?></a>
						 
			<?php
					} else {
			?>
						,<img class="sort_by_arrow" src="<?php echo $vars['url']; ?>/mod/forum/graphics/up_arrow.jpg" /><a href="<?php echo $url; ?>most_popular_asc"><?php echo elgg_echo('forum:most_popular'); ?></a>
			<?php
					}
				}
				
				if ($rating_system) {
					if ($sort_by != 'rate_average_desc') {
			?>
						,<img class="sort_by_arrow" src="<?php echo $vars['url']; ?>/mod/forum/graphics/down_arrow.jpg" /><a href="<?php echo $url; ?>rate_average_desc"><?php echo elgg_echo('forum:rate_average'); ?></a>
			<?php
					} else {
			?>
						,<img class="sort_by_arrow" src="<?php echo $vars['url']; ?>/mod/forum/graphics/up_arrow.jpg" /><a href="<?php echo $url; ?>rate_average_asc"><?php echo elgg_echo('forum:rate_average'); ?></a>
			<?php 
					}
				}
			?>
		</div>
	<?php
		}
	?>
