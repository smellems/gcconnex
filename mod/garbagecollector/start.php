<?php
/**
 * Elgg garbage collector.
 *
 * @package ElggGarbageCollector
 */

elgg_register_event_handler('init', 'system', 'garbagecollector_init');

function garbagecollector_init() {
	$period = elgg_get_plugin_setting('period', 'garbagecollector');
	switch ($period) {
		case 'weekly':
		case 'monthly':
		case 'yearly':
			break;
		default:
			$period = 'monthly';
	}

	// Register cron hook
	elgg_register_plugin_hook_handler('cron', $period, 'garbagecollector_cron');
}

/**
 * Cron job
 */

// cyu - [TODO the cron that will access this]
function garbagecollector_cron($hook, $entity_type, $returnvalue, $params) {

	echo elgg_echo('garbagecollector');

	// Garbage collect metastrings
	echo elgg_echo('garbagecollector:gc:metastrings');

	if (delete_orphaned_metastrings() !== false) {
		echo elgg_echo('garbagecollector:ok');
	} else {
		echo elgg_echo('garbagecollector:error');
	}

	echo "\n";

	// Now, because we are nice, trigger a plugin hook to let other plugins do some GC
	$rv = true;
	$period = elgg_get_plugin_setting('period','garbagecollector');
	elgg_trigger_plugin_hook('gc', 'system', array('period' => $period));


	global $CONFIG;

	$connection = mysqli_connect($CONFIG->dbhost, $CONFIG->dbuser, $CONFIG->dbpass, $CONFIG->dbname);
	if (mysqli_connect_errno($connection)) elgg_log("cyu - Failed to connect to MySQL: ".mysqli_connect_errno(), 'NOTICE');
	$result = mysqli_query($connection,$query);
	//mysqli_free_result($result);


	// cyu - [TODO we gotta wait for all the select statements to finish or something]
	// Now we optimize all tables
	$tables = get_db_tables();
	foreach ($tables as $table) {
		elgg_log('cyu - optimizing...'.$table, 'NOTICE');




		//echo elgg_echo('garbagecollector:optimize', array($table));

		// if (optimize_table($table) !== false) {
		// 	echo elgg_echo('garbagecollector:ok');
		// } else {
		// 	echo elgg_echo('garbagecollector:error');
		// }

		//echo "\n";
	}

	mysqli_close($connection);

	echo elgg_echo('garbagecollector:done');
}
