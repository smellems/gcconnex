<?php

 
$user_id = elgg_get_logged_in_user_entity();
$object = $vars['item']->getObjectEntity();
$subject = $vars['item']->getSubjectEntity();
$group = get_group_entity_as_row($object->group_guid);

/*
$subject_link = elgg_view('output/url', array(
        'href' => "activity/owner/$subject->username",
        'text' => $subject->name,
        'class' => 'elgg-river-subject',
        'is_trusted' => true,
));

$object_link = elgg_view('output/url', array(
        'href' => "groups/activity/$object->group_guid",
        'text' => $group->name,
        'class' => 'elgg-river-object',
        'is_trusted' => true,
));

$summary = elgg_echo("river:create:object:etherpad", array($subject_link, $object_link));
*/
$pad_url = elgg_view('output/url', array(
        'href' => $object->url."?userName=".$user_id->name,
        'text' => $object->url,
        'target' => "_blank"
));

$excerpt = $object->excerpt ? $object->excerpt : $object->objetive;
$excerpt = elgg_get_excerpt($excerpt);

echo elgg_view('river/elements/layout', array(
        'item' => $vars['item'],
        'message' => $excerpt,
	'attachments' => $pad_url,
//	'summary' => $summary,
));
