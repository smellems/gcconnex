<?php

$list_id = elgg_extract('list_id', $vars, "forumlist");
$container_guids = elgg_extract('container_guids', $vars, ELGG_ENTITIES_ANY_VALUE);
$subtypes = elgg_extract('subtypes', $vars, array('hjforum', 'hjforumtopic'));

$title = false;

$getter_options = array(
	'types' => 'object',
	'subtypes' => $subtypes,
	'container_guids' => $container_guids,
);

if (!get_input("__ord_$list_id")) {
	$getter_options = hj_framework_get_order_by_clause('forum.sticky', 'DESC', $getter_options);
}

$list_options = array(
	'list_type' => 'table',
	'list_class' => 'hj-forumlist',
	'list_view_options' => array(
		'table' => array(
			'head' => array(
				'forum' => array(
					'text' => elgg_echo('hj:forum:tablecol:forum'),
					'sortable' => true,
					'sort_key' => 'oe.title',
				),
				'topics' => ($container_subtype !== 'hjforum' || HYPEFORUM_SUBFORUMS) ? array(
					'text' => elgg_echo('hj:forum:tablecol:topics'),
					'sortable' => true,
					'sort_key' => 'forum.topics'
				) : NULL,
				'posts' => array(
					'text' => elgg_echo('hj:forum:tablecol:posts'),
					'sortable' => true,
					'sort_key' => 'forum.posts'
				),
				'last_post' => array(
					'text' => elgg_echo('hj:forum:tablecol:last_post'),
					'sortable' => true,
					'sort_key' => 'e.last_action'
				),
				'menu' => array(
					'text' => '',
					'sortable' => false
				),
			)
		)
	),
	'pagination' => true
);

$viewer_options = array(
	'full_view' => true
);

$content .= hj_framework_view_list($list_id, $getter_options, $list_options, $viewer_options, 'elgg_get_entities');

echo elgg_view_module('forum-category', $title, $content);