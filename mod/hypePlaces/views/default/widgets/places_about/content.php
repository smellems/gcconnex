<?php

$entity = elgg_get_page_owner_entity();

if (strip_tags($entity->description)) {
	echo elgg_view('output/longtext', array(
		'value' => $entity->description,
	));
}