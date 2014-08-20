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

$forum_guid = get_input('e');
$segment_guid = get_input('sg');

if (empty($forum_guid)) {
    $forums = hj_forum_find_site_forums();
    $forum = $forums[0];
} else {
    $forum = get_entity($forum_guid);
}

if (!$forum) {
	return true;
}

if ($instance = $forum->getRootLevelTopic()->instance) {
	elgg_push_context($instance);
} else {
	elgg_push_context('forum');
}

if (!$forum) {
    register_error('hj:forum:notsetup');
    forward(REFERER);
}
$segments = hj_framework_get_entities_by_priority('object', 'hjsegment', null, $forum->guid);

$context = elgg_get_context();

if (!empty($segments)) {
    $module = elgg_view_entity($segments[0], array('full_view' => true));
} else {
    if ($forum->canAdminister()) {
        elgg_push_breadcrumb(elgg_echo('hj:forum:setup'));
        $form = hj_framework_get_data_pattern('object', 'hjsegment', 'hjforum');
        $params = array(
            'owner_guid' => $user->guid,
            'container_guid' => $forum->guid,
            'form_guid' => $form->guid,
            'context' => 'forum',
            'subtype' => 'hjsegment',
            'handler' => 'hjforum',
	    'ajaxify' => false
        );
        foreach ($params as $key => $value) {
            set_input($key, $value);
        }
        $module = elgg_view_entity($form, $params);
    } else {
        forward();
    }
}
$title = sprintf(elgg_echo('hj:forum:forums'), $user->name);
$content = elgg_view_module('main', null, $module);

$page = elgg_view_layout('one_sidebar', array('content' => $content));

echo elgg_view_page($title, $page);

elgg_pop_context();
