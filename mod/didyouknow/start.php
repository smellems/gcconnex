
<?php
	function didyouknow_init(){
		elgg_extend_view('js/elgg', 'didyouknow/js');
		elgg_extend_view('css', 'didyouknow/css');
		elgg_extend_view('css/admin', 'didyouknow/admin-css');

		if(elgg_get_context() == 'event_calendar' && elgg_get_plugin_setting('event_calendar_state', 'didyouknow') == 1){
			elgg_extend_view('page/elements/sidebar', 'didyouknow/module');
		}

		if(elgg_get_context() == 'groups' && elgg_get_plugin_setting('groups_state', 'didyouknow') == 1){
			elgg_extend_view('groups/sidebar/find', 'didyouknow/module', 1);
		}
	}
	elgg_register_event_handler('init', 'system', 'didyouknow_init');
?>
