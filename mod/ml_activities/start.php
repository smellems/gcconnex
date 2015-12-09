<?php

elgg_register_event_handler('init', 'system', 'ml_init');

// cyu - modified 02-13-2015: issues with table naming convention resolved
function ml_init() {
	elgg_register_page_handler('ml', 'ml_page_handler');
}

function ml_page_handler () {
    //echo elgg_view_resource('ml');
    echo elgg_view('ml');
}