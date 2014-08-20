<?php

	/* AJAX plugin for ELGG
	* 
	*/
	
	/* Initialise the theme */
	//function gcAJAX_init(){
		global $AJAXfunctions;		// array of AJAX function names
		
		require_once( elgg_get_plugins_path() . "gcAJAX/gcAJAX.php" );
		
		//elgg_register_js( elgg_get_plugins_path() . "gcAJAX/AJAXscript.js", 'text/javascript' );
		elgg_register_js( 'GC.AJAX', "mod/gcAJAX/AJAXscript.js" );
		elgg_load_js('GC.AJAX');
	
	//}
	
	// Initialise log browser
	//register_elgg_event_handler('init','system','gcAJAX_init');
	
?>