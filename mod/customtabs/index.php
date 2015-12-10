<?php

/**
	 * Elgg Custom Tabs plugin
	 *
	 * @package Elgg Custom Tabs
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Alex Falk, RiverVanRain
	 * @URL http://o.wzm.me/crewz/p/1983/personal-net
	 * @copyright (c) organiZm 2k13
	 */

require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");


switch ($vars['page']) {
	case 'tab1':
	default:
		$content = elgg_view('tab1');	
		break;
	case 'tab2':
		$content = elgg_view('tab2');	
		break;
	case 'tab3':
		$content = elgg_view('tab3');	
		break;
}

$title = elgg_echo("customtabs");
	
$body = elgg_view_layout('content', array(
	'content' => $content,
	'title' => $title,
	'filter_override' => elgg_view('customtabs/nav', array('selected' => $vars['page'])),
	'sidebar' => elgg_view('customtabs/sidebar'),
));

echo elgg_view_page($title, $body);
?>
