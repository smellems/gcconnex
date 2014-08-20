<?php

elgg_load_js('hj.framework.fieldcheck');

elgg_load_js('hj.framework.ajax');
elgg_load_js('hj.framework.tabs');
elgg_load_js('hj.forum.base');

elgg_load_css('hj.forum.base');
elgg_load_css('hj.framework.profile');

if (elgg_is_admin_logged_in()) {
    elgg_load_js('hj.framework.tabs.sortable');
}

$topic_guid = get_input('e');
$topic = get_entity($topic_guid);

if ($instance = $topic->getRootLevelTopic()->instance) {
	elgg_push_context($instance);
} else {
	elgg_push_context('forum');
}

if (!elgg_instanceof($topic)) {
    register_error('hj:forum:nosuchtopic');
    forward(REFERER);
}

elgg_push_breadcrumb($topic->title);

$topic_view = elgg_view_entity($topic, array('full_view' => true));

$content = elgg_view_module('main', null, $topic_view);

$page = elgg_view_layout('one_sidebar', array('content' => $content));

echo elgg_view_page($topic->title, $page);

elgg_pop_context();