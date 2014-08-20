<?php
/**
 * @file views/default/entities/entity_list.php
 * @brief View a list of entities
 */

$context = $vars['context'];
$offset = $vars['offset'];
$entities = $vars['entities'];
$limit = $vars['limit'];
$count = $vars['count'];
$baseurl = $vars['baseurl'];
$context = $vars['context'];
$viewtype = $vars['viewtype'];
$pagination = $vars['pagination'];
$fullview = $vars['fullview'];

$html = "";
$nav = "";

if (isset($vars['viewtypetoggle'])) {
	$viewtypetoggle = $vars['viewtypetoggle'];
} else {
	$viewtypetoggle = true;
}

if ($context == "search" && $count > 0 && $viewtypetoggle) {
	$nav .= elgg_view('navigation/viewtype', array(
		'baseurl' => $baseurl,
		'offset' => $offset,
		'count' => $count,
		'viewtype' => $viewtype,
	));
}


if ($pagination) {
	$nav .= elgg_view('navigation/pagination',array(
		'baseurl' => $baseurl,
		'offset' => $offset,
		'count' => $count,
		'limit' => $limit,
	));
}

if (($vars['viewtypetoggle'] == 'post_listing')&&(is_array($entities) && sizeof($entities) > 0)) {
	$html .= '<div class="float_right minus_margin">'.$nav.'</div>';
	$html .= '<div class="clearfloat"></div>';
} else {
	$html .= $nav;
}

if ($viewtype == 'list') {
	if (is_array($entities) && sizeof($entities) > 0) {
		foreach($entities as $entity) {
			$html .= elgg_view_entity($entity, $fullview);
		}
	}
} else {
	if (is_array($entities) && sizeof($entities) > 0) {
		$html .= elgg_view('entities/gallery', array('entities' => $entities));
	}
}

if ($count) {
	$html .= '<div class="clearfloat"></div>';
	if ($vars['viewtypetoggle'] == 'post_listing') {
		$html .= '<div class="float_right">'.$nav.'</div>';
		$html .= '<div class="clearfloat"></div>';
	} else { 
		$html .= $nav;
	}
}

echo $html;