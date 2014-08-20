<?php

gatekeeper();

$guid   = get_input('guid');
$entity = get_entity($guid);

if (phloor_body_background_instanceof($entity) && $entity->canEdit()) {
    $entity_url = $entity->getURL(); // get entity url

	if ($entity->delete()) {
		system_message(elgg_echo('phloor:message:deleted_entity'));

		//if(elgg_http_url_is_identical(REFERER, $entity_url, true)) {
	        $container = get_entity($entity->container_guid);

    		if (elgg_instanceof($container, 'group')) {
    			forward("phloor_body_background/group/$container->guid/all");
    		} else {
    			forward("phloor_body_background/owner/$container->username");
    		}
		//}
		exit();
	} else {
		register_error(elgg_echo('phloor:error:cannot_delete_entity'));
	}
} else {
	register_error(elgg_echo('phloor:error:entity_not_found'));
}

forward(REFERER);
exit();

