<?php

$entity = elgg_extract('entity', $vars, false);
$full = elgg_extract('full_view', $vars, true);

if (!$entity) {
	return true;
}

$owner = get_entity($entity->owner_guid);

if (!elgg_instanceof($owner)) {
	return true;
}

if ($full) {
	$menu = elgg_view_menu('commentshead', array(
		'entity' => $entity,
		'handler' => $handler,
		'class' => 'elgg-menu-entity elgg-menu-hz',
		'sort_by' => 'priority',
		'params' => $params
			));

	$icon = elgg_view_entity_icon($owner, 'medium', array('use_hover' => false));
	//$icon .= elgg_view_entity_icon('hj/forum/userstats', array('entity' => $owner));

	$author = elgg_view('output/url', array(
		'text' => $owner->name,
		'href' => $owner->getURL(),
		'class' => 'hj-comments-item-comment-owner'
			));

	$comment = elgg_view('output/longtext', array(
		'value' => $entity->annotation_value
			));

	$subject = $entity->title;
	$time = elgg_view_friendly_time($entity->time_created);

//$bar = elgg_view('hj/comments/bar', $vars);

	$icon_stats = <<<HTML
	    <div class="hj-forum-post-stats">
		<div class="hj-forum-post-author">
		    $author
		</div>
		<div class="hj-forum-post-time">
		    $time
		</div>
	    </div>
HTML;

	$icon .= $icon_stats;

	$content = <<<HTML
    $menu
    <div class="hj-forum-post-subject">$subject</div>
    <div class="hj-forum-post-body">
	$comment
    </div>
HTML;

	echo elgg_view_image_block($icon, $content);
} else {
	$latest_post_timestamp = elgg_get_friendly_time($entity->time_created);
	$latest_post_subject = elgg_view('output/url', array(
		'href' => $entity->getURL(),
		'text' => $entity->title
	));
	$latest_post_topic = get_entity($entity->container_guid);
	$latest_post_link = elgg_view('output/url', array(
		'href' => $latest_post_topic->getURL(),
		'text' => $latest_post_topic->title
			));
	$latest_post_link = elgg_echo('hj:forum:latestpost:in', array($latest_post_link));

	$latest_post_author = get_entity($latest_post_topic->owner_guid);
	$latest_post_author_link = elgg_view('output/url', array(
		'href' => $latest_post_author->getURL(),
		'text' => $latest_post_author->username
			));
	$latest_post_author_link = elgg_echo('hj:forum:latestpost:by', array($latest_post_author_link));

	$latest_post_html = <<<HTML
            <div class="hj-forum-latest-post-short">
				<div class="hj-latest-post-subject">
                    $latest_post_subject
                </div>
				<div class="hj-latest-post-timestamp">
                    $latest_post_timestamp
                </div>
				<div class="hj-latest-post-topic">
                    $latest_post_link
                </div>
                <div class="hj-latest-post-author">
                    $latest_post_author_link
                </div>
            </div>
HTML;

	echo $latest_post_html;
}