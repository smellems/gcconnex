<?php

/*global $sort_arr;

$sort_strings = array(
'name-a'	=>	'name asc',
'id-a'		=>	'guid asc'

);*/

require_once( elgg_get_plugins_path() . 'gcSort/sort_arrays.php' );	// load global arrays

function elgg_list_entities_from_metadata_sorted($options, array $sortby = array()) {
	return elgg_list_entities_sorted($options, 'elgg_get_entities_from_metadata', 'elgg_view_entity_list', $sortby);
}


/**
 * Returns a string of parsed entities.
 ***********GCchange by Ilia Salem: extended to provide sorting options on top of the usual list display.
 *
 * Displays list of entities with formatting specified
 * by the entity view.
 *
 * @tip Pagination is handled automatically.
 *
 * @internal This also provides the views for elgg_view_annotation().
 *
 * @param array $options Any options from $getter options plus:
 *	full_view => BOOL Display full view entities
 *	list_type => STR 'list' or 'gallery'
 *	list_type_toggle => BOOL Display gallery / list switch
 *	pagination => BOOL Display pagination links
 *
 * @param mixed $getter  The entity getter function to use to fetch the entities
 * @param mixed $viewer  The function to use to view the entity list.
 *
 * @return string
 * @see elgg_get_entities()
 * @see elgg_view_entity_list()
 */
 
function elgg_list_entities_sorted( array $options = array(), $getter = 'elgg_get_entities_from_metadata',
	$viewer = 'elgg_view_entity_list_sorted', array $sortby = array() ) {

	global $autofeed;
	global $sort_sql;
	
	$autofeed = true;
	
	// addition for sorting
	if ( count( $sortby ) > 0 )
		$sort_get = get_input( 'sort', $sortby[0] );
		
	else 
		$sort_get = 'id-a';
	
	//convert above into mysql order_by syntax
	$order_by = $sort_sql[$sort_get];

	register_error($order_by);
	
	$defaults = array(
		'offset' => (int) max(get_input('offset', 0), 0),
		'limit' => (int) max(get_input('limit', 10), 0),
		'full_view' => TRUE,
		'list_type_toggle' => FALSE,
		'pagination' => TRUE,
	//	'order_by'	=> $order_by,
	);

	$options = array_merge($defaults, $options);
	
	// for sorting
	$dbprefix = elgg_get_config("dbprefix");
	$options["joins"]	= array("JOIN " . $dbprefix . "users_entity ge ON e.guid = ge.guid");
	$options['order_by'] = $order_by;

	//backwards compatibility
	if (isset($options['view_type_toggle'])) {
		$options['list_type_toggle'] = $options['view_type_toggle'];
	}

	$options['count'] = TRUE;
	$count = $getter($options);

	$options['count'] = FALSE;
	$entities = $getter($options);

	$options['count'] = $count;

	return $viewer($entities, $options, $sortby);
}


/**
 * Returns a rendered list of entities with pagination. This function should be
 * called by wrapper functions.
 *
 * @see elgg_list_entities()
 * @see list_user_friends_objects()
 * @see elgg_list_entities_from_metadata()
 * @see elgg_list_entities_from_relationships()
 * @see elgg_list_entities_from_annotations()
 *
 * @param array $entities Array of entities
 * @param array $vars     Display variables
 *		'count'            The total number of entities across all pages
 *		'offset'           The current indexing offset
 *		'limit'            The number of entities to display per page
 *		'full_view'        Display the full view of the entities?
 *		'list_class'       CSS class applied to the list
 *		'item_class'       CSS class applied to the list items
 *		'pagination'       Display pagination?
 *		'list_type'        List type: 'list' (default), 'gallery'
 *		'list_type_toggle' Display the list type toggle?
 *
 * @return string The rendered list of entities
 * @access private
 */
function elgg_view_entity_list_sorted($entities, $vars = array(), $sortby = array( '1' => '===test sort option===' ), $offset = 0, $limit = 10, $full_view = true,
$list_type_toggle = true, $pagination = true) {

	if (!is_int($offset)) {
		$offset = (int)get_input('offset', 0);
	}

	// list type can be passed as request parameter
	$list_type = get_input('list_type', 'list');
	if (get_input('listtype')) {
		elgg_deprecated_notice("'listtype' has been deprecated by 'list_type' for lists", 1.8);
		$list_type = get_input('listtype');
	}

	if (is_array($vars)) {
		// new function
		$defaults = array(
			'items' => $entities,
			'list_class' => 'elgg-list-entity',
			'full_view' => true,
			'pagination' => true,
			'list_type' => $list_type,
			'list_type_toggle' => false,
			'offset' => $offset,
		);

		$vars = array_merge($defaults, $vars);

	} else {
		// old function parameters
		elgg_deprecated_notice("Please update your use of elgg_view_entity_list()", 1.8);

		$vars = array(
			'items' => $entities,
			'count' => (int) $vars, // the old count parameter
			'offset' => $offset,
			'limit' => (int) $limit,
			'full_view' => $full_view,
			'pagination' => $pagination,
			'list_type' => $list_type,
			'list_type_toggle' => $list_type_toggle,
			'list_class' => 'elgg-list-entity',
		);
	}

	if ($vars['list_type'] != 'list') {
		return elgg_view('page/components/gallery', $vars);
	} else {
		return sort_selector( $sortby ) . elgg_view("page/components/list", $vars, true);
	}
}

function sort_selector( array $options )
{
	$option_text = array();
	
	foreach ( $options as $option ){
		$option_text[$option] = elgg_echo('gcSort:' . $option);		// get the correct language text
	}
	
	
	return elgg_view("input/dropdown", array("name" => "gcsort-selector", "id" => "gcsort-selector", "options_values" => $option_text, "value" => get_input( 'sort', '' ), /*"onChange" => "gcsort();"*/ ));
	
	//elgg_load_js('ui.gcsort');
}


?>