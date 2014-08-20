<?php

if (elgg_is_xhr()) {
	$last = get_entity(get_input('guid'));
	$last_action = $last->last_action;

	$options = get_input('options');

	$defaults = array(
		'offset' => (int) max(get_input('offset', 0), 0),
		'limit' => (int) max(get_input('limit', 10), 0),
		'type' => 'object',
		'subtype' => 'hjforumtopic',
		'metadata_name_value_pairs' => array(
			array('name' => 'widget', 'value' => $options['widget_guid']),
			array('name' => 'sticky', 'value' => 'false')
		),
		'limit' => 5,
		'wheres' => array("e.last_action < $last_action"),
		'order_by' => 'e.last_action desc'
	);

	$items = elgg_get_entities_from_metadata($defaults);

	if (is_array($items) && count($items) > 0) {
		foreach ($items as $key => $item) {
			$id = "elgg-{$item->getType()}-{$item->guid}";
			$time = $item->time_created;

			$html = "<li id=\"$id\" class=\"elgg-item\" data-timestamp=\"$time\">";
			$html .= elgg_view_list_item($item, $vars);
			$html .= '</li>';

			$output[] = $html;
		}
	}
	print(json_encode($output));
	exit;
}

forward(REFERER);