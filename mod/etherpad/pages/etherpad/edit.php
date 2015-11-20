<?php

gatekeeper();

$pad_guid = get_input('guid');
$pad = get_entity($pad_guid);

if (!elgg_instanceof($pad, 'object', 'etherpad') || !$pad->canEdit()) {
	register_error(elgg_echo('etherpad:unknown_pad'));
	forward(REFERRER);
}

$page_owner = elgg_get_page_owner_entity();

$title = elgg_echo('etherpad:edit');
elgg_push_breadcrumb($title);
// create form
$form_vars = array();
$body_vars = etherpad_prepare_form_vars($pad);
$content = elgg_view_form('etherpad/save', $form_vars, $body_vars);

$body = elgg_view_layout('content', array(
	'filter' => '',
	'content' => $content,
	'title' => $title,
));

echo elgg_view_page($title, $body);
