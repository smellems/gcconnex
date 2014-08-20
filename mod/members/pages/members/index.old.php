<?php
/**
 * Members index
 *
 */

$num_members = get_number_users();

$title = elgg_echo('members');

$departmentList1 = array("TBS-SCT","SCC-SCS","CSC-SCC");
//$departmentList = elgg_view_entity_list($departmentList1);

// $resultset = elgg_get_entities(array(
// 	'type' => 'object',
// 	'subtype' => 'gc_dept'));

	// $dept = new ElggObject();
	// $dept->subtype = 'gc_departments';
	// $dept->title = 'TBS-SCT / SCT-TBS';
	// $dept->description = 'Treasury Board of Canada Secretariat / Secretariat du Conseil Tresor du Canada';
	// $dept->save();
	// $dept->type = 'object';

	// $dept = new ElggObject();
	// $dept->subtype = 'gc_departments';
	// $dept->title = 'SSC-SPC / SPC-SCC';
	// $dept->description = 'Shared Services Canada / Services partages Canada';
	// $dept->save();
	// $dept->type = 'object';



// $resultset = elgg_get_entities(array(
// 	'type' => 'object',
// 	'subtype' => 'gc_departments'));

//echo 'START -- '.$resultset.' -- END';
$uhhh = array('TBS','SSC','SCS');

$options = array('type' => 'user', 'full_view' => false);
switch ($vars['page']) {
	case 'popular':
		$options['relationship'] = 'friend';
		$options['inverse_relationship'] = false;
		$content = elgg_list_entities_from_relationship_count($options);
		break;
	case 'online':
		$content = get_online_users();
		break;
	case 'department':
		$content = custom_list($uhhh);
		break;
	case 'newest':
	default:
		$content = elgg_list_entities_sorted($options, 'elgg_get_entities_from_metadata', 'elgg_view_entity_list_sorted', array( '0' => 'name-a', '1' => 'name-d', '2' => 'id-a', '3' => 'id-d', ));
//		$content = elgg_list_entities($options);
		break;
}




$params = array(
	'content' => $content,
	'sidebar' => elgg_view('members/sidebar'),
	'title' => $title . " ($num_members)",
	'filter_override' => elgg_view('members/nav', array('selected' => $vars['page'])),
);

$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);

 function custom_list(array $options = array(), $getter = 'elgg_get_entities', $viewer = 'elgg_view_entity_list') {
 
     global $autofeed;
     $autofeed = true;
 
     $offset_key = isset($options['offset_key']) ? $options['offset_key'] : 'offset';
 
     $defaults = array(
         'offset' => (int) max(get_input($offset_key, 0), 0),
         'limit' => (int) max(get_input('limit', 10), 0),
         'full_view' => FALSE,
         'list_type_toggle' => FALSE,
         'pagination' => TRUE,
     );
 
     $options = array_merge($defaults, $options);
 
     //backwards compatibility
     if (isset($options['view_type_toggle'])) {
         $options['list_type_toggle'] = $options['view_type_toggle'];
     }
 
     $options['count'] = TRUE;
     $count = $getter($options);
 
     $options['count'] = FALSE;
     $entities = $getter($options);
 
     $options['count'] = $count;
 
     return $viewer($entities, $options);
 }