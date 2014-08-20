<?php

/**
 * Get latest forum topics
 *
 * @param int $container_guid	Guid of the forum
 * @param int $limit			Number of topics to return
 * @param boolean $count		Return a total number of topics
 * @param boolean $recursive	Recurse into the forum tree (nested forums and topics)
 * @return mixed
 */
function hj_forum_get_latest_topics($container_guid, $limit = 10, $count = false, $recursive = false) {

	$options = array(
		'types' => 'object',
		'subtypes' => array('hjforumtopic', 'hjforum'),
		'count' => $count,
		'limit' => $limit,
		'relationship' => 'descendant',
		'relationship_guid' => $container_guid,
		'inverse_relationship' => true,
		'order_by' => 'e.time_created DESC'
	);

	if (!$recursive) {
		$options['container_guids'] = $container_guid;
	}

	return elgg_get_entities_from_relationship($options);
}

/**
 * Get latest posts
 *
 * @param int $container_guid	Guid of the topic or forum
 * @param int $limit			Number of posts to return
 * @param boolean $count		Return a total number of posts
 * @param boolean $recursive	Recurse into the forum tree (nested forums and topics)
 * @return mixed
 */
function hj_forum_get_latest_posts($container_guid, $limit = 10, $count = false, $recursive = false) {
	$options = array(
		'types' => 'object',
		'subtypes' => array('hjforumpost', 'hjforumtopic'),
		'count' => $count,
		'limit' => $limit,
		'relationship' => 'descendant',
		'relationship_guid' => $container_guid,
		'inverse_relationship' => true,
		'order_by' => 'e.time_created DESC'
	);

	if (!$recursive) {
		$options['container_guids'] = $container_guid;
	}

	return elgg_get_entities_from_relationship($options);
}

/**
 * Notify subscribed users
 * @param int $guid
 */
function hj_forum_notify_subscribed_users($guid) {

	$entity = get_entity($guid);

	$subscribers = $entity->getSubscribedUsers();

	$subtype = $entity->getSubtype();
	
	$from = elgg_get_site_entity()->guid;

	$subject = elgg_echo("hj:forum:new:$subtype");
	
	$subject_link = elgg_view('framework/bootstrap/user/elements/name', array('entity' => $entity->getOwnerEntity()));
	$object_link = elgg_view('framework/bootstrap/object/elements/title', array('entity' => $entity));
	$breadcrumbs = elgg_view('framework/bootstrap/object/elements/breadcrumbs', array('entity' => $entity));
	if (!empty($breadcrumbs)) {
		$breadcrumbs_link = elgg_echo('river:in:forum', array($breadcrumbs));
	}
	$key = "river:create:object:$subtype";
	$summary = elgg_echo($key, array($subject_link, $object_link)) . $breadcrumbs_link;
	$body = elgg_view('framework/bootstrap/object/elements/description', array('entity' => $entity));
	$link = elgg_view('output/url', array(
		'text' => elgg_echo('hj:framework:notification:link'),
		'href' => $entity->getURL(),
		'is_trusted' => true
	));
	$footer = elgg_echo('hj:framework:notification:full_link', array($link));
	
	$message = "<p>$summary</p><p>$body</p><p>$footer</p>";

	notify_user($subscribers, $from, $subject, $message);

}

//function hj_forum_notify_message($hook, $type, $message, $params) {}