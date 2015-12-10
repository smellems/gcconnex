<?php

//$entities = new ElggBlog();
$users = elgg_get_entities(array(
    'type' => 'user',
    //'owner_guid' => $owner_guid,
    //'wheres' => array('department = "Canada Economic Development for Quebec Regions / Développement économique Canada pour les régions du Québec"')
    'department' => 'Canada Economic Development for Quebec Regions / Développement économique Canada pour les régions du Québec'
));


$entities = elgg_get_entities(array(
    'type' => 'user',
    'subtype' => 'blog'
    //'owner_guid' => $owner_guid,
));

//echo count($entities);

foreach ($users as $user) {
    $text .= "---" . $user->department . "<br/>";
}

/*
foreach($entities as $blog) {
    $text .= print_r($blog);
    //$text .= $blog->title . "<br/>";
}
*/


//$text = $entities[0]->attributes->title;

$params = array(
    'title' => 'Hello world!',
    'content' => $text, //print_r($entities),
    'filter' => '',
);

$body = elgg_view_layout('content', $params);

echo elgg_view_page('ml', $body);

