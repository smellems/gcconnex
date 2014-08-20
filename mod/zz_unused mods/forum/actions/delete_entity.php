<?php
	/**
	 * @file actions/delete_entity.php
	 * @brief Delete any elgg entity that the user has access for
	 */

	action_gatekeeper();

	// Get the guid of any elgg entity
	$entity_guid = get_input('entity_guid');
	
	if ($entity_guid) {
		// Check if It is possible to get an entity with this guid
		if ($entity = get_entity($entity_guid)) {
			
			// Get the entity title for objects and the name for sites, groups and users
			$title = ($entity->title) ? ($entity->title) : $entity->name;

			// Try to delete the entity
			if ($entity->delete()) {
				// Shows confirmation message
				system_message(sprintf(elgg_echo('forum:deleted_successfully'),$title));
			} else {
				// Shows error message
				system_messages(sprintf(elgg_echo('forum:errors:cant_be_deleted'),$title),'errors');
			}
		}
	}
	
	// Forward the user to the all forum listing page	
	forward($_SERVER['HTTP_REFERER']);
?>