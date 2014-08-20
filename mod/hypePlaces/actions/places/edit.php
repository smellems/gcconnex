<?php

namespace hypeJunction\Places;

use hypeJunction\Filestore\IconHandler;

elgg_make_sticky_form('places/edit');

$guid = get_input('guid', null);
$container_guid = get_input('container_guid', null);
$title = get_input('title');
$description = get_input('description');
$access_id = get_input('access_id');
$tags = get_input('tags');
$specialties = get_input('specialties');
$markertype = get_input('markertype', 'default');

$address = get_input('address', array());
$street_address = elgg_extract('street_address', $address);
$extended_address = elgg_extract('extended_address', $address);
$locality = elgg_extract('locality', $address);
$region = elgg_extract('region', $address);
$postal_code = elgg_extract('postal_code', $address);
$country_iso = elgg_extract('country_code', $address);
$country = elgg_extract('country', $address);

if (!$title || !$street_address || !$locality || !$postal_code || (!$country_iso && !$country)) {
	register_error(elgg_echo('places:place:edit:error:required_field_empty'));
	forward(REFERER);
}

$entity = get_entity($guid);
$container = get_entity($container_guid);

if (!$entity) {
	$river = true;
	$entity = new Place();
	$entity->container_guid = $container->guid;
}

$entity->access_id = ($access_id == '') ? $container->access_id : $access_id;
$entity->title = $title;
$entity->description = $description;
$entity->tags = string_to_tag_array($tags);
$entity->specialties = string_to_tag_array($specialties);
$entity->markertype = $markertype;
$entity->street_address = $street_address;
$entity->extended_address = $extended_address;
$entity->locality = $locality;
$entity->region = $region;
$entity->postal_code = $postal_code;
$entity->country_code = $country_iso;
if ($entity->country_code && is_callable(array('hypeJunction\\Geo\\Countries', 'getCountries'))) {
	$countries = call_user_func(array('hypeJunction\\Geo\\Countries', 'getCountries'), 'iso', 'name', 'name');
	$country = $countries[$country_iso];
}
$entity->country = $country;
$entity->phone = get_input('phone');
$entity->website = get_input('website');
$entity->twitter = get_input('twitter');

$tools = get_input('tools', array());
$entity->checkins = elgg_extract('checkins', $tools, false);

if ($entity->save()) {

	$entity->location = implode(', ', array_filter(array($street_address, $extended_address, $locality, $region, $postal_code, $country)));

	if (!empty($_FILES['icon']['name']) && $_FILES['icon']['error'] == UPLOAD_ERR_OK && substr_count($_FILES['icon']['type'], 'image/')) {
		IconHandler::makeIcons($entity, $_FILES['icon']['tmp_name']);
	}

	if ($river) {
		add_to_river('framework/river/places/create', 'create', $entity->owner_guid, $entity->guid);
	}
	elgg_clear_sticky_form('places/edit');
	system_message(elgg_echo('places:edit:success', array($entity->title)));

	$forward_url = $entity->getURL();
} else {
	register_error(elgg_echo('places:edit:error'));
	$forward_url = REFERER;
}

forward($forward_url);
