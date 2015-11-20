<?php
/**
 * Prepare the add/edit form variables
 *
 * @param ElggObject $pad A pad object.
 * @return array
 */
 
function etherpad_prepare_form_vars($pad = null) {
	// input names => defaults
	$values = array(
		'url' => get_input('url', ''),
		'objetive' => get_input('objetive', ''),
		'access_id' => ACCESS_DEFAULT,
		'container_guid' => elgg_get_page_owner_guid(),
		'guid' => null,
		'entity' => $pad,
	);

	if ($pad) {
		foreach (array_keys($values) as $field) {
			if (isset($pad->$field)) {
				$values[$field] = $pad->$field;
			}
		}
	}

	if (elgg_is_sticky_form('etherpad')) {
		$sticky_values = elgg_get_sticky_values('etherpad');
		foreach ($sticky_values as $key => $value) {
			$values[$key] = $value;
		}
	}

	elgg_clear_sticky_form('etherpad');

	return $values;
}
