<?php

function hj_forum_find_site_forums($instance = 'mainforum') {
	$metadata = array(
		array(
		'name' => 'instance',
		'value' => $instance
	));
	$forums = hj_framework_get_entities_from_metadata_by_priority('object', 'hjforumtopic', null, elgg_get_site_entity()->guid, $metadata);
    return $forums;
}

function hj_forum_get_forum_status_options() {
    $user = elgg_get_logged_in_user_entity();
    $options['open'] = elgg_echo('hj:forum:topic:open');

    if (elgg_is_admin_logged_in() || $user->forum_admin || $user->forum_moderator) {
        $options['closed'] = elgg_echo('hj:forum:topic:closed');
    }
    $options = elgg_trigger_plugin_hook('hj:forum:status', 'all', null, $options);

    return $options;
}

function hj_forum_get_forum_children_options() {
    $user = elgg_get_logged_in_user_entity();

    $options['forumpost'] = elgg_echo('hj:forum:children:forumpost');

    if (elgg_is_admin_logged_in() || $user->forum_admin || $user->forum_moderator) {
        $options['forumtopic'] = elgg_echo('hj:forum:children:forumtopic');
    }

    $options = elgg_trigger_plugin_hook('hj:forum:children', 'all', null, $options);

    return $options;
}

function hj_forum_get_forum_sticky_options() {
    $user = elgg_get_logged_in_user_entity();

    $options['false'] = elgg_echo('hj:forum:sticky:false');

    if (elgg_is_admin_logged_in() || $user->forum_admin || $user->forum_moderator) {
        $options['true'] = elgg_echo('hj:forum:sticky:true');
    }

    $options = elgg_trigger_plugin_hook('hj:forum:sticky', 'all', null, $options);

    return $options;
}

function hj_forum_get_forum_icons() {
    $options = array('default', 'star', 'heart', 'question', 'important', 'info', 'idea', 'laugh', 'surprise', 'lightning', 'announcement', 'lock');

    $options = elgg_trigger_plugin_hook('hj:forum:icons', 'all', null, $options);

    foreach ($options as $option) {
        $label = elgg_view_icon("forum-$option");
        $options_values["$label"] = $option;
    }

    return $options_values;
}

function hj_forum_get_post_subject() {
    $extract = hj_framework_extract_params_from_url();
    $params = elgg_extract('params', $extract, array());

    $container = $params['container'];

    return elgg_echo('hj:forum:reply:prefix', array($container->title));
}
