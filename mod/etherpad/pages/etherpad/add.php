<?php

$page_owner = elgg_get_page_owner_entity();

$title = elgg_echo('etherpad:add');
elgg_push_breadcrumb($title);
// create form
$form_vars = array();

$vars = etherpad_prepare_form_vars();
$content = elgg_view_form('etherpad/save', $form_vars, $vars);

$body = elgg_view_layout('content', array(
	'filter' => '',
	'content' => $content,
	'title' => $title,
));

echo elgg_view_page($title, $body);
