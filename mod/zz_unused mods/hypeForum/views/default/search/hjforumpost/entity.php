<?php

/**
 * Default search view for a comment
 *
 * @uses $vars['entity']
 */
$entity = $vars['entity'];

if (elgg_instanceof($entity, 'object', 'hjannotation')) {
	switch ($entity->annotation_name) {
		case 'hjforumpost' :
			$container = $entity->findOriginalContainer();

			$title = $container->title;
			$forum = $container->getContainerEntity();
			$title = elgg_echo('hj:forum:post_in', array($title, $forum->title));
			$url = $container->getURL();
			$title = "<a href=\"$url\">$title</a>";

			$owner = get_entity($entity->owner_guid);
			$icon = elgg_view_entity_icon($owner, 'tiny');

			$description = $entity->getVolatileData('search_annotation_value');
			$tc = $entity->time_created;
			$time = elgg_view_friendly_time($tc);

			$body = "<p class=\"mbn\">$title</p>";
			$body .= "$river_item";
			$body .= "<p>$description</p>";
			$body .= "<p class=\"elgg-subtext\">$time</p>";

			echo elgg_view_image_block($icon, $body);

			break;

		default :
			return true;
			break;
	}
}