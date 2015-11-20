<?php

$user_id = elgg_get_logged_in_user_entity();
$pad = elgg_extract('entity', $vars, FALSE);
$owner = $pad->getOwnerEntity();
$owner_icon = elgg_view_entity_icon($owner, 'tiny');

if (!$pad) { return; }

$pad_url = elgg_view('output/url', array(
	'href' => $pad->url."?userName=".$user_id->name,
	'text' => $pad->url,
        'target' => "_blank"
));

$owner_link = elgg_view('output/url', array(
        'href' => "etherpad/owner/$owner->username",
        'text' => $owner->name,
));
$author_text = elgg_echo('byline', array($owner_link));
$date = elgg_view_friendly_time($pad->time_created);

$metadata = elgg_view_menu('entity', array(
        'entity' => $vars['entity'],
        'handler' => 'etherpad',
        'sort_by' => 'priority',
        'class' => 'elgg-menu-hz',
));

$subtitle = "$author_text $date";

$content = elgg_get_excerpt($pad->objetive);

$metadata .= $pad_url;


$params = array(
            'entity' => $pad,
            'metadata' => $metadata,
            'subtitle' => $subtitle,
	    'content' => $pad->objetive,
        );
//$params = $params + $vars;
$body = elgg_view('object/elements/summary', $params);

echo elgg_view_image_block($owner_icon, $body);


