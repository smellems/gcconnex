<?php

class hjForumTopic extends ElggObject {

	protected function initializeAttributes() {
		parent::initializeAttributes();

		$this->attributes['subtype'] = "hjforumtopic";
		$this->attributes['access_id'] = ACCESS_PUBLIC;
	}

	public function canAdminister() {
		$user = elgg_get_logged_in_user_entity();
		$return = false;

		if (elgg_is_admin_logged_in() || $this->canEdit() || $user->forum_admin) {
			$return = true;
		}
		return elgg_trigger_plugin_hook('hj:forum:canadminister', 'all', null, $return);
	}

	public function canModerate() {
		$user = elgg_get_logged_in_user_entity();
		$return = false;

		if (elgg_is_admin_logged_in() || $this->canEdit() || $user->forum_moderator) {
			$return = true;
		}
		return elgg_trigger_plugin_hook('hj:forum:canmoderate', 'all', null, $return);
	}

	public function canPost() {
		return elgg_trigger_plugin_hook('hj:forum:canpost', 'all', null, true);
	}

	public function getAsocSegmentGUID() {
		$segments = elgg_get_entities(array(
			'type' => 'object',
			'subtype' => 'hjsegment',
			'container_guid' => $this->guid,
			'limit' => 1
				));
		if ($segments) {
			return $segments[0]->guid;
		}
		return false;
	}

	public function getParentTopic() {
		$parent = $this->getContainerEntity();
		if (!elgg_instanceof($parent, 'object', 'hjforumtopic')) {
			return $parent;
		}
		return false;
	}

	public function getRootLevelTopic() {
		$check = true;
		$parent = $return = $this;
		while ($check) {
			$parent = $parent->getContainerEntity();
			if (elgg_instanceof($parent, 'object', 'hjforumtopic')) {
				$return = $parent;
			} else {
				$check = false;
			}
		}
		return $return;
	}

	public function getSubTopics($count = false, $limit = 0) {
		$subtopics = elgg_get_entities(array(
			'type' => 'object',
			'subtype' => 'hjforumtopic',
			'container_guid' => $this->guid,
			'count' => $count,
			'limit' => $limit
				));

		return $subtopics;
	}

	public function countSubTopics() {
		$subtopics = $this->getSubTopics();

		$count = sizeof($subtopics);

		foreach ($subtopics as $subtopic) {
			$count = $count + $subtopic->countSubTopics();
		}

		return $count;
	}

	public function getPosts($count = false, $limit = 0, $timestamp = null) {
		$options = array(
			'type' => 'object',
			'subtype' => 'hjannotation',
			'container_guid' => $this->guid,
			'metadata_name_value_pairs' => array(
				array('name' => 'annotation_name', 'value' => 'hjforumpost'),
				array('name' => 'annotation_value', 'value' => '', 'operand' => '!=')
			),
			'count' => $count,
			'limit' => $limit
		);

		if ($timestamp) {
			$options['wheres'] = "e.time_created < $timestamp";
		}
		$posts = elgg_get_entities_from_metadata($options);
		return $posts;
	}

	public function getLatestPost($timestamp = null) {
		$child_posts = $this->getPosts(false, 1, $timestamp);
		if (is_array($child_posts))
			$latest_post = $child_posts[0];

		$topics = $this->getSubTopics();
		foreach ($topics as $topic) {
			//$post = $topic->getPosts(false, 1);
			$sub_post = $topic->getLatestPost($timestamp);
			if ($sub_post->time_created > $latest_post->time_created) {
				$latest_post = $sub_post;
			}
		}
		return $latest_post;
	}

	public function countPosts() {
		$count = $this->getPosts(true);
		$topics = $this->getSubtopics();
		foreach ($topics as $topic) {
			$count = $count + $topic->countPosts();
		}
		return $count;
	}

}