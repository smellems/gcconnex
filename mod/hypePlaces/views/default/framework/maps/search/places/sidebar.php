<?php

namespace hypeJunction\Places;

echo elgg_view_form('maps/filter/places', array(
	'action' => current_page_url(),
	'method' => 'GET',
	'disable_security' => true,
	'class' => 'maps-filter'
		), $vars);