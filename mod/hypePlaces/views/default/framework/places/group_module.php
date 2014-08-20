<?php

namespace hypeJunction\Places;

$group = elgg_get_page_owner_entity();

if ($group->places_enable == "no") {
	return true;
}

$all_link = elgg_view('output/url', array(
	'href' => PAGEHANDLER . "/group/$group->guid",
	'text' => elgg_echo('link:view:all'),
	'is_trusted' => true,
		));

elgg_push_context('widgets');

$options = array(
	'types' => 'object',
	'subtypes' => array(Place::SUBTYPE),
	'container_guids' => $group->guid,
	'full_view' => false,
	'pagination' => false,
);

$content = elgg_list_entities($options);
elgg_pop_context();

if (!$content) {
	$content = '<p>' . elgg_echo('places:list:empty') . '</p>';
}

if ($group->canWriteToContainer(0, 'object', Place::SUBTYPE)) {
	$new_link = elgg_view('output/url', array(
		'href' => PAGEHANDLER . "/create/$group->guid",
		'text' => elgg_echo('places:create'),
		'is_trusted' => true,
	));
}

echo elgg_view('groups/profile/module', array(
	'title' => elgg_echo('places:group'),
	'content' => $content,
	'all_link' => $all_link,
	'add_link' => $new_link,
));
