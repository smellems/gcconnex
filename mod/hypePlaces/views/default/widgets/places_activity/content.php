<?php

$entity = elgg_extract('entity', $vars);

$options = array(
	'limit' => $num,
	'pagination' => false,
	'object_guids' => elgg_get_page_owner_guid(),
);

$content = elgg_list_river($options);
if (!$content) {
	$content = elgg_echo('river:none');
}

echo $content;
