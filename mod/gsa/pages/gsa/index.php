<?php
/**
 * Elgg search page
 *
 * @todo much of this code should be pulled out into a library of functions
 */

// Search supports RSS
global $autofeed;
$autofeed = true;

// $search_type == all || entities || trigger plugin hook
$search_type = get_input('search_type', 'all');

// @todo there is a bug in get_input that makes variables have slashes sometimes.
// @todo is there an example query to demonstrate ^
// XSS protection is more important that searching for HTML.
$query = stripslashes(get_input('q', get_input('tag', '')));

// @todo - create function for sanitization of strings for display in 1.8
// encode <,>,&, quotes and characters above 127
if (function_exists('mb_convert_encoding')) {
	$display_query = mb_convert_encoding($query, 'HTML-ENTITIES', 'UTF-8');
} else {
	// if no mbstring extension, we just strip characters
	$display_query = preg_replace("/[^\x01-\x7F]/", "", $query);
}
$display_query = htmlspecialchars($display_query, ENT_QUOTES, 'UTF-8', false);

// check that we have an actual query
if (!$query) {
	$title = sprintf(elgg_echo('gsa:results'), "\"$display_query\"");
	
	$body  = elgg_view_title(elgg_echo('gsa:search_error'));
	$body .= elgg_echo('gsa:no_query');
	$layout = elgg_view_layout('one_sidebar', array('content' => $body));
	echo elgg_view_page($title, $layout);

	return;
}

// get limit and offset.  override if on search dashboard, where only 2
// of each most recent entity types will be shown.
$limit = ($search_type == 'all') ? 2 : get_input('limit', 10);
$offset = ($search_type == 'all') ? 0 : get_input('offset', 0);

$entity_type = get_input('entity_type', ELGG_ENTITIES_ANY_VALUE);
$entity_subtype = get_input('entity_subtype', ELGG_ENTITIES_ANY_VALUE);
$owner_guid = get_input('owner_guid', ELGG_ENTITIES_ANY_VALUE);
$container_guid = get_input('container_guid', ELGG_ENTITIES_ANY_VALUE);
$friends = get_input('friends', ELGG_ENTITIES_ANY_VALUE);
$sort = get_input('sort');
switch ($sort) {
	case 'relevance':
	case 'created':
	case 'updated':
	case 'action_on':
	case 'alpha':
		break;

	default:
		$sort = 'relevance';
		break;
}

$order = get_input('order', 'desc');
if ($order != 'asc' && $order != 'desc') {
	$order = 'desc';
}

// set up search params
$params = array(
	'query' => $query,
	'offset' => $offset,
	'limit' => $limit,
	'sort' => $sort,
	'order' => $order,
	'search_type' => $search_type,
	'type' => $entity_type,
	'subtype' => $entity_subtype,
//	'tag_type' => $tag_type,
	'owner_guid' => $owner_guid,
	'container_guid' => $container_guid,
//	'friends' => $friends
	'pagination' => ($search_type == 'all') ? FALSE : TRUE
);

$types = get_registered_entity_types();
$custom_types = elgg_trigger_plugin_hook('search_types', 'get_types', $params, array());

// add sidebar items for all and native types
// @todo should these maintain any existing type / subtype filters or reset?
$data = htmlspecialchars(http_build_query(array(
	'q' => $query,
	'entity_subtype' => $entity_subtype,
	'entity_type' => $entity_type,
	'owner_guid' => $owner_guid,
	'search_type' => 'all',
	//'friends' => $friends
)));
$url = elgg_get_site_url() . "gsa?$data";
$menu_item = new ElggMenuItem('all', elgg_echo('all'), $url);
elgg_register_menu_item('page', $menu_item);

foreach ($types as $type => $subtypes) {
	// @todo when using index table, can include result counts on each of these.
	if (is_array($subtypes) && count($subtypes)) {
		foreach ($subtypes as $subtype) {
			$label = "item:$type:$subtype";

			$data = htmlspecialchars(http_build_query(array(
				'q' => $query,
				'entity_subtype' => $subtype,
				'entity_type' => $type,
				'owner_guid' => $owner_guid,
				'search_type' => 'entities',
				'friends' => $friends
			)));

			$url = elgg_get_site_url()."gsa?$data";
			$menu_item = new ElggMenuItem($label, elgg_echo($label), $url);
			elgg_register_menu_item('page', $menu_item);
		}
	} else {
		$label = "item:$type";

		$data = htmlspecialchars(http_build_query(array(
			'q' => $query,
			'entity_type' => $type,
			'owner_guid' => $owner_guid,
			'search_type' => 'entities',
			'friends' => $friends
		)));

		$url = elgg_get_site_url() . "gsa?$data";

		$menu_item = new ElggMenuItem($label, elgg_echo($label), $url);
		elgg_register_menu_item('page', $menu_item);
	}
}

// add sidebar for custom searches
foreach ($custom_types as $type) {
	$label = "search_types:$type";

	$data = htmlspecialchars(http_build_query(array(
		'q' => $query,
		'search_type' => $type,
	)));

	$url = elgg_get_site_url()."gsa?$data";

	$menu_item = new ElggMenuItem($label, elgg_echo($label), $url);
	elgg_register_menu_item('page', $menu_item);
}

// start the actual search
$results_html = '';


if ($search_type == 'all' || $search_type == 'entities') {

    // build cURL request
    $hostname = elgg_get_plugin_setting('hostname', 'gsa');
    $collection = elgg_get_plugin_setting('collection', 'gsa');
    $frontend = elgg_get_plugin_setting('frontend', 'gsa');
    $results_per_page = 20;
    $filter = 1;
    $timeout = 30;

    $search_query_data['gsa_host'] = check_plain($hostname . '/search');
    $search_query_data['gsa_query_params'] = array(
        'site' => check_plain($collection),
        'oe' => 'utf8',
        'ie' => 'utf8',
        'getfields' => '*',
        'client' => check_plain($frontend),
        'start' => $offset,
        'num' => check_plain($results_per_page),
        'filter' => check_plain($filter),
        'q' => $query,
        'output' => 'xml_no_dtd',
        'sort' => $sort,
        'access' => 'p',
        //'requiredfields' => $filter_param
    );

    // query the GSA for search results
    $gsa_response = _curl_get(
        $search_query_data['gsa_host'],
        $search_query_data['gsa_query_params'],
        array(),
        $timeout
    );

    // check for handshake errors
    if ( $gsa_response['is_error'] == TRUE ) {  // cURL returned an error (can't connect)
        $response_data['error']['curl_error'] = $gsa_response['response'];
        // displaying useful error messages depends upon the use of the array key
        // 'curl_error' ... the actual error code/response is replaced by hook_help messages
        // @see google_appliance.theme.inc
        // @see google_appliance_help()
    }
    else {  // cURL gave us something back -> attempt to parse
        $response_data = google_appliance_parse_device_response_xml($gsa_response['response']);
    }

    // render results
    $search_query_data['gsa_query_params']['urlencoded_q'] = urlencode($query);
    $template_data = array(
        'search_query_data' => $search_query_data,
        'response_data' => $response_data,
    );


	// to pass the correct current search type to the views
	$current_params = $params;
	$current_params['search_type'] = 'entities';

	// foreach through types.
	// if a plugin returns FALSE for subtype ignore it.
	// if a plugin returns NULL or '' for subtype, pass to generic type search function.
	// if still NULL or '' or empty(array()) no results found. (== don't show??)
	foreach ($types as $type => $subtypes) {
		if ($search_type != 'all' && $entity_type != $type) {
			continue;
		}

		if (is_array($subtypes) && count($subtypes)) {
			foreach ($subtypes as $subtype) {
				// no need to search if we're not interested in these results
				// @todo when using index table, allow search to get full count.
				if ($search_type != 'all' && $entity_subtype != $subtype) {
					continue;
				}
				$current_params['subtype'] = $subtype;
				$current_params['type'] = $type;

                $results = '';
                foreach ($response_data['entry'] as $res_entities) {
                    if (isset($res_entities['entity_type']) && $res_entities['entity_type'] == $type &&
                        isset($res_entities['sub_type']) && $res_entities['sub_type'] == $subtype){
                        $entity['title'] = $res_entities['title'];
                        $entity['description'] = $res_entities['snippet'];
                        $entity['url'] = $res_entities['abs_url'];
                        $entity['crawldate'] = $res_entities['crawldate'];
                        $results['entities'][] = $entity;
                        $results['count'] += 1;
                        if ($results['count'] > 4) {
                            break;
                        }
                    }
                }


//				$results = elgg_trigger_plugin_hook('gsa', "$type:$subtype", $current_params, NULL);
//				if ($results === FALSE) {
//					// someone is saying not to display these types in searches.
//					continue;
//				} elseif (is_array($results) && !count($results)) {
//					// no results, but results searched in hook.
//				} elseif (!$results) {
//					// no results and not hooked.  use default type search.
//					// don't change the params here, since it's really a different subtype.
//					// Will be passed to elgg_get_entities().
//					$results = elgg_trigger_plugin_hook('gsa', $type, $current_params, array());
//				}

				if (is_array($results['entities']) && $results['count']) {
					if ($view = search_get_search_view($current_params, 'list')) {
						$results_html .= elgg_view($view, array(
							'results' => $results,
							'params' => $current_params,
						));
					}
				}
			}
		}

		// pull in default type entities with no subtypes
		$current_params['type'] = $type;
		$current_params['subtype'] = ELGG_ENTITIES_NO_VALUE;

		$results = elgg_trigger_plugin_hook('gsa', $type, $current_params, array());
		if ($results === FALSE) {
			// someone is saying not to display these types in searches.
			continue;
		}

		if (is_array($results['entities']) && $results['count']) {
			if ($view = search_get_search_view($current_params, 'list')) {
				$results_html .= elgg_view($view, array(
					'results' => $results,
					'params' => $current_params,
				));
			}
		}
	}
}

// call custom searches
if ($search_type != 'entities' || $search_type == 'all') {
	if (is_array($custom_types)) {
		foreach ($custom_types as $type) {
			if ($search_type != 'all' && $search_type != $type) {
				continue;
			}

			$current_params = $params;
			$current_params['search_type'] = $type;

			$results = elgg_trigger_plugin_hook('gsa', $type, $current_params, array());

			if ($results === FALSE) {
				// someone is saying not to display these types in searches.
				continue;
			}

			if (is_array($results['entities']) && $results['count']) {
				if ($view = search_get_search_view($current_params, 'list')) {
					$results_html .= elgg_view($view, array(
						'results' => $results,
						'params' => $current_params,
					));
				}
			}
		}
	}
}

// highlight search terms
if ($search_type == 'tags') {
	$searched_words = array($display_query);
} else {
	$searched_words = search_remove_ignored_words($display_query, 'array');
}
$highlighted_query = search_highlight_words($searched_words, $display_query);

$body = elgg_view_title(elgg_echo('gsa:results', array("\"$highlighted_query\"")));

if (!$results_html) {
	$body .= elgg_view('gsa/no_results');
} else {
	$body .= $results_html;
}

// this is passed the original params because we don't care what actually
// matched (which is out of date now anyway).
// we want to know what search type it is.
$layout_view = search_get_search_view($params, 'layout');
$layout = elgg_view($layout_view, array('params' => $params, 'body' => $body));

$title = elgg_echo('gsa:results', array("\"$display_query\""));

echo elgg_view_page($title, $layout);
