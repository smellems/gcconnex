<?php

$entity = elgg_extract('entity', $vars);
$full = elgg_extract('full_view', $vars, false);

$icon = elgg_view_icon("forum-$entity->icon");

$title = elgg_view('output/url', array(
	'href' => $entity->getURL(),
	'text' => $entity->title
		));

$description = $entity->description;

if (!$full) {
	$description = elgg_get_excerpt($description, 80);

	if ($entity->children == 'forumtopic') {
		$topic_count = $entity->countSubTopics();
	}
	$post_count = $entity->countPosts();

	$latest_post = $entity->getLatestPost();
	if (elgg_instanceof($latest_post)) {
		$latest_post_html = elgg_view_entity($latest_post, array('full_view' => false));
	} else {
		$no_latest_post = elgg_echo('hj:forum:nolatestpost');
		$latest_post_html = <<<HTML
            <div class="hj-forum-latest-post-short">
                $no_latest_post
            </div>
HTML;
	}
	$html = <<<HTML
    <div class="hj-forum-topic-short clearfix">
        <div class="hj-forum-topic-col hj-forum-topic-col1">
            $icon
        </div>
        <div class="hj-forum-topic-col hj-forum-topic-col2">
            <div class="hj-forum-topic-title">$title</div>
            <div class="hj-forum-topic-desc">$description</div>
        </div>
        <div class="hj-forum-topic-col hj-forum-topic-col3">
            $topic_count
        </div>
        <div class="hj-forum-topic-col hj-forum-topic-col4">
            $post_count
        </div>
        <div class="hj-forum-topic-col hj-forum-topic-col5">
            $latest_post_html
        </div>
    </div>
HTML;

	echo $html;
} else {

	$form = hj_framework_get_data_pattern('object', 'hjannotation', 'hjforumpost');

	$reply_params = array(
		'target' => "hj-annotations-$entity->guid",
		'full_view' => true,
		'dom_order' => 'prepend',
		'form_guid' => $form->guid,
		'owner_guid' => elgg_get_logged_in_user_guid(),
		'subtype' => 'hjannotation',
		'entity_guid' => null,
		'handler' => 'hjforumpost',
		'event' => 'create',
		'owner_guid' => elgg_get_logged_in_user_guid(),
		'container_guid' => $entity->guid
	);

	$reply_params = hj_framework_extract_params_from_params($reply_params);


	$form = hj_framework_get_data_pattern('object', 'hjforumtopic');

	$params = array(
		'target' => "elgg-object-$entity->guid",
		'full_view' => true,
		'form_guid' => $form->guid,
		'subject_guid' => $entity->guid,
		'subtype' => 'hjforumtopic',
		'event' => 'update',
		'ajaxify' => false,
	);

	$params = hj_framework_extract_params_from_entity($entity, $params);

	$header_menu = elgg_view_menu('hjentityhead', array(
		'entity' => $entity,
		'current_view' => $full,
		'class' => 'elgg-menu-hz hj-menu-hz',
		'sort_by' => 'priority',
		'reply_params' => $reply_params,
		'params' => $params
			));

	$comments = elgg_view('hj/forum/commentsbar', array(
		'entity' => $entity,
		'aname' => 'hjforumpost'
			));

	$owner = get_entity($entity->owner_guid);

	$author = elgg_view('output/url', array(
		'text' => $owner->name,
		'href' => $owner->getURL(),
		'class' => 'hj-comments-item-comment-owner'
			));

	$time = elgg_view_friendly_time($entity->time_created);

	$icon = elgg_view_entity_icon($owner, 'medium');
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

	$html = elgg_view_image_block($icon, $description);

	$html = <<<HTML
	<div class="hj-forum-topic-body">
	    $html
	</div>
HTML;

	$body = elgg_view_module('forum', $title . $header_menu, $html);

	echo $body;
	echo $comments;
}