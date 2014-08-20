<?php

namespace hypeJunction\Places;

require_once __DIR__ . '/vendors/autoload.php';

$subtypes = array(
	Place::SUBTYPE => get_class(new Place),
);

foreach ($subtypes as $subtype => $class) {
	if (get_subtype_id('object', $subtype)) {
		update_subtype('object', $subtype, $class);
	} else {
		add_subtype('object', $subtype, $class);
	}
}