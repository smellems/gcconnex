<?php

elgg_register_event_handler('init','system','c_notice_banner_init'); 

function c_notice_banner_init()
{ 
	global $CONFIG;

	$c_connex = mysqli_connect($CONFIG->dbhost, $CONFIG->dbuser, $CONFIG->dbpass, 'c_mdb');

	//elgg_register_page_handler('c_notice_banner_init', 'c_notice_banner_page_handler');

	$query = "CREATE TABLE IF NOT EXISTS c_notice_message (
		msg_id INT NOT NULL AUTO_INCREMENT, 
		en MEDIUMTEXT, 
		fr MEDIUMTEXT, 
		beg_style VARCHAR(20), 
		end_style VARCHAR(20), 
		is_enabled INT,
		PRIMARY KEY(msg_id)) 
		COLLATE utf8_bin;";

	mysqli_query($c_connex, $query);

	mysqli_close($c_connex);

	// register actions
	 $action_base = elgg_get_plugins_path() . 'c_notice_banner/actions/c_notice_banner';
	// elgg_register_action('c_notice_banner/settings', "$action_base/settings.php", 'admin');

	elgg_register_action('c_notice_banner/save', false, $CONFIG->pluginspath . "c_notice_banner/actions/settings.php", 'admin');

}
