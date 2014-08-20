<?php

function hj_forum_setup() {
	if (elgg_is_logged_in()) {
		hj_forum_setup_segment_form();
		hj_forum_setup_forumtopic_form();
		hj_forum_setup_forumpost_form();

		$forum = new ElggObject();
		$forum->subtype = 'hjforumtopic';
		$forum->title = elgg_echo('hj:forum:siteforum');
		$forum->owner_guid = elgg_get_logged_in_user_guid();
		$forum->container_guid = elgg_get_site_entity()->guid;
		$forum->access_id = ACCESS_PUBLIC;
		$forum_guid = $forum->save();
		$forum->priority = 1;
		$forum->children = 'forumtopic';
		$forum->instance = 'mainforum';


		$segment = new ElggObject();
		$segment->title = $forum->title;
		$segment->access_id = $forum->access_id;
		$segment->owner_guid = $forum->owner_guid;
		$segment->subtype = 'hjsegment';
		$segment->container_guid = $forum->guid;
		$segment_guid = $segment->save();
		$segment->priority = 1;
		$segment->handler = 'hjforumtopic';

		if ($segment_guid) {
			$segment = get_entity($segment_guid);
			$segment->addWidget('hjforumtopic', null, 'forum');
		}

		if ($forum_guid && $segment_guid) {
			elgg_set_plugin_setting('hj:forum:setup', true);
		}
		return true;
	}
	return false;
}

function hj_forum_setup_segment_form() {
	$form = new hjForm();
	$form->title = 'hypeForum:forum:create';
	$form->label = 'Create Forum';
	$form->description = '';
	$form->subject_entity_subtype = 'hjsegment';
	$form->handler = 'hjforumtopic';
	$form->notify_admins = false;
	$form->add_to_river = false;
	$form->comments_on = true;

	if ($form->save()) {
		$form->addField(array(
			'title' => 'Name of your forum',
			'name' => 'title',
			'mandatory' => true
		));

		$form->addField(array(
			'title' => 'Description',
			'name' => 'description',
			'input_type' => 'longtext',
			'class' => 'elgg-input-longtext',
			'mandatory' => true
		));

		$form->addField(array(
			'title' => 'Access Level',
			'input_type' => 'access',
			'mandatory' => true,
			'name' => 'access_id'
		));

		return true;
	}
	return false;
}

function hj_forum_setup_forumtopic_form() {
	$form = new hjForm();
	$form->title = 'hypeForum:forumtopic:create';
	$form->label = 'Create Forum';
	$form->description = '';
	$form->subject_entity_subtype = 'hjforumtopic';
	$form->notify_admins = false;
	$form->add_to_river = false;
	$form->comments_on = true;
	$form->ajaxify = true;

	if ($form->save()) {
		$form->addField(array(
			'title' => 'Icon',
			'name' => 'icon',
			'input_type' => 'radio',
			'options' => 'hj_forum_get_forum_icons();',
			'class' => 'elgg-horizontal'
		));

		$form->addField(array(
			'title' => 'Name of your forum',
			'name' => 'title',
			'mandatory' => true
		));

		$form->addField(array(
			'title' => 'Description',
			'name' => 'description',
			'input_type' => 'longtext',
			'class' => 'elgg-input-longtext',
			'mandatory' => true
		));
		$form->addField(array(
			'title' => 'Children',
			'name' => 'children',
			'input_type' => 'dropdown',
			'options_values' => "hj_forum_get_forum_children_options();"
		));
		$form->addField(array(
			'title' => 'Status',
			'name' => 'status',
			'input_type' => 'dropdown',
			'options_values' => 'hj_forum_get_forum_status_options();'
		));
		$form->addField(array(
			'title' => 'Sticky',
			'name' => 'sticky',
			'input_type' => 'dropdown',
			'options_values' => 'hj_forum_get_forum_sticky_options();'
		));
		$form->addField(array(
			'title' => 'Access Level',
			'input_type' => 'access',
			'mandatory' => true,
			'name' => 'access_id'
		));

		return true;
	}
	return false;
}

function hj_forum_setup_forumpost_form() {
	$form = new hjForm();
	$form->title = 'hypeForum:forumpost:create';
	$form->label = 'Reply to Forum Topic';
	$form->description = '';
	$form->subject_entity_subtype = 'hjannotation';
	$form->handler = 'hjforumpost';
	$form->notify_admins = false;
	$form->add_to_river = false;
	$form->comments_on = true;
	$form->ajaxify = true;

	if ($form->save()) {
		$form->addField(array(
			'title' => 'Subject',
			'name' => 'title',
			'mandatory' => true
		));
		$form->addField(array(
			'title' => 'Body',
			'name' => 'annotation_value',
			'input_type' => 'longtext',
			'class' => 'elgg-input-longtext',
			'mandatory' => true
		));
		$form->addField(array(
			'input_type' => 'hidden',
			'name' => 'annotation_name',
			'value' => 'hjforumpost'
		));

		return true;
	}
	return false;
}

run_function_once('hj_forum_add_subtypes');

function hj_forum_add_subtypes() {
	add_subtype('object', 'hjforumtopic', 'hjForumTopic');
}