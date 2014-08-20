<?php
	/**
	 * @file views/default/forum/last_topic_info.php
	 * @brief Displays information about the last topic published in a forum
	 */

	// Check if the forum was passed to this view
	if ($vars['entity']) {
		// Get the topics of this forum	
		$topics = get_posts($vars['entity']->guid);
		if ($topics) {
			// The first one is always the most recent topic
			$last_topic = $topics[0];
			$topic_url = $last_topic->getUrl();
			echo "<a href='{$topic_url}'>";
			echo $last_topic->title;
			echo '</a>';			
			echo '<br />';
			
			// Displays the creation time in a friendly way
			echo friendly_time($last_topic->time_created);
			
			// Get the owner of this topic
			$owner = get_entity($last_topic->owner_guid);
			$owner_url = $owner->getUrl();
			echo ', ';
			echo "<a href='{$owner_url}'>";
			echo $owner->name;
			echo '</a>';
		} else {
			echo elgg_echo('forum:no_topics_created');
		}
	}
?>