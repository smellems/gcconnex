<?php

namespace hypeJunction\Places;

$item = elgg_extract('item', $vars);

$object = $item->getObjectEntity();
$subject = $item->getSubjectEntity();

if ($object->guid != elgg_get_page_owner_guid()) {
	$attachments = elgg_view('framework/places/staticmap', array(
		'entity' => $object,
		'size' => (elgg_in_context('widgets')) ? '300x300' : '800x200',
	));
}

echo elgg_view('river/elements/layout', array(
	'item' => $item,
	'attachments' => $attachments,
));
