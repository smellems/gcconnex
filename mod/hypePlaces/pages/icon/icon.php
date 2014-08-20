<?php

namespace hypeJunction\Places;

use ElggFile;

$ha = access_get_show_hidden_status();
access_show_hidden_entities(true);

$entity_guid = get_input('guid');
$entity = get_entity($entity_guid);

if (!$entity) {
	exit;
}

$size = strtolower(get_input('size', 'medium'));

$filename = "icons/" . $entity->guid . $size . ".jpg";
$etag = md5($entity->icontime . $size);

$filehandler = new ElggFile();
$filehandler->owner_guid = $entity->owner_guid;
$filehandler->setFilename($filename);
if ($filehandler->exists()) {
	$filehandler->open('read');
	$contents = $filehandler->grabFile();
	$filehandler->close();
} else {
	exit;
}

access_show_hidden_entities($ha);

header("Content-type: image/jpeg");
header("Etag: $etag");
header('Expires: ' . date('r', time() + 864000));
header("Pragma: public");
header("Cache-Control: public");
header("Content-Length: " . strlen($contents));

echo $contents;
