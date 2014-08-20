<?php

namespace hypeJunction\Places;

$subtypes = array(
	Place::SUBTYPE,
);

foreach ($subtypes as $subtype) {
	update_subtype('object', $subtype);
}
