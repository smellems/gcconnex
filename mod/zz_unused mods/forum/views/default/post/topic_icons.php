<?php
	/**
	 * @file views/default/post/topic_icons.php
	 * @brief Shows the appropriate icons for an topic
	 */

	if ($vars['entity']) {
		$icons_counter = 0;
?>
		<div class="topic_icons float_left">
			<div class="icon_column">
			<?php
				if ($vars['entity']->important_topic == 'yes') {
					// Beginning of icon columns control
					$icons_counter++;
					if ($icons_counter > 2) {
						$icons_counter = 1;
						// Close the last icon column
						echo '</div>';
						// Open a new icon column
						echo '<div class="icon_column">';
					}
					// End of icon columns control

					// Display the exclamation icon
					echo elgg_view('post/important_topic_exclamation',$vars);
				}
				 
				if ($vars['entity']->status == 'closed') {
					// Beginning of icon columns control
					$icons_counter++;
					if ($icons_counter > 2) {
						$icons_counter = 1;
						// Close the last icon column
						echo '</div>';
						// Open a new icon column
						echo '<div class="icon_column">';
					} // End of icon columns control
					
					// Display the lock icon
					echo elgg_view('post/lock',$vars);
				}
				
			if ($vars['entity']->stick) {
					// Beginning of icon columns control
					$icons_counter++;
					if ($icons_counter > 2) {
						$icons_counter = 1;
						// Close the last icon column
						echo '</div>';
						// Open a new icon column
						echo '<div class="icon_column">';
					} // End of icon columns control
					
					// Display the lock icon
					echo elgg_view('post/pin',$vars);
				}
				
				if (is_topic_updated($vars['entity']->guid)) {
					// Beginning of icon columns control
					$icons_counter++;
					if ($icons_counter > 2) {
						$icons_counter = 1;
						// Close the last icon column
						echo '</div>';
						// Open a new icon column
						echo '<div class="icon_column">';
					} // End of icon columns control
					
					echo elgg_view('post/topic_updated',$vars);
				}
				
				if (!did_see_last_comment($vars['entity']->guid)) {
					// Beginning of icon columns control
					$icons_counter++;
					if ($icons_counter > 2) {
						$icons_counter = 1;
						// Close the last icon column
						echo '</div>';
						// Open a new icon column
						echo '<div class="icon_column">';
					} // End of icon columns control
					
					echo elgg_view('post/new_comment_icon',$vars);
				}
			?>
			</div>
		</div>
<?php
	}
?>