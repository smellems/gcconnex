<?php

$forum_str = elgg_echo('hj:forum:headers:forum');

$entity = get_entity($vars['container_guid']);

if (!$entity->children || $entity->children !== 'forumpost') {
    $topic_str = elgg_echo('hj:forum:headers:topic');
}
$post_str = elgg_echo('hj:forum:headers:post');
$latest_str = elgg_echo('hj:forum:headers:latest');

$headers_view = <<<HTML
    <div class="hj-forum-topic-header clearfix">
        <div class="hj-forum-topic-col hj-forum-topic-col1">
        </div>
        <div class="hj-forum-topic-col hj-forum-topic-col2">
            $forum_str
        </div>
        <div class="hj-forum-topic-col hj-forum-topic-col3">
            $topic_str
        </div>
        <div class="hj-forum-topic-col hj-forum-topic-col4">
            $post_str
        </div>
        <div class="hj-forum-topic-col hj-forum-topic-col5">
            $latest_str
        </div>
    </div>
HTML;

echo $headers_view;