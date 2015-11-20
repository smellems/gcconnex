<?php

$owner = elgg_get_page_owner_entity();

elgg_push_breadcrumb($owner->name, "etherpad/owner/$owner->username");
elgg_push_breadcrumb(elgg_echo('friends'));

elgg_register_title_button();

$title = elgg_echo('etherpad:friends');

$content = elgg_list_entities_from_relationship(array(
	'type' => 'object',
	'subtype' => 'etherpad',
	'full_view' => false,
	'relationship' => 'friend',
	'relationship_guid' => $owner->guid,
	'relationship_join_on' => 'container_guid',
	'no_results' => elgg_echo('etherpad:none'),
));

$params = array(
	'filter_context' => 'friends',
	'content' => $content,
	'title' => $title,
);

$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);
