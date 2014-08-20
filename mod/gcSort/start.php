<?php

	/* 
	 *  sorting for entity lists
	*/
	
	/* Initialise the theme */
	function gcSort_init(){
		elgg_register_library('sort', elgg_get_plugins_path() . 'gcSort/lib/sort.php');
		elgg_load_library('sort');
		elgg_register_js( 'ui.gcsort', 'mod/gcSort/js/ui.gcsort.js' );
		elgg_load_js('ui.gcsort');
		//elgg_register_page_handler( 'sort', 'sort_page_handler' );
		//elgg_extend_view('page/components/list', elgg_get_plugins_path() .  "views/default/page/gcSort/list.php" );//'page/gcSort/list');
	}
	
	// Initialise log browser
	elgg_register_event_handler('init','system','gcSort_init');
	
	
	function sort_page_handler( $page ){
		elgg_load_library('sort');
	}
	
?>