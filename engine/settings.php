<?php

	/**
	 * Elgg settings
	 * 
	 * Elgg manages most of its configuration from the admin panel. However, we need you to
	 * include your database settings below.
	 * 
	 * @todo Turn this into something we handle more automatically. 
	 */

		global $CONFIG;
		if (!isset($CONFIG))
			$CONFIG = new stdClass;
	/* Commente si tu veux le bouton de registration */
	$CONFIG->disable_registration=false;
	/*
	 * Standard configuration
	 * 
	 * You will use the same database connection for reads and writes.
	 * This is the easiest configuration, and will suit 99.99% of setups. However, if you're
	 * running a really popular site, you'll probably want to spread out your database connections
	 * and implement database replication.  That's beyond the scope of this configuration file
	 * to explain, but if you know you need it, skip past this section. 
	 */
	
		// Database username
			$CONFIG->dbuser = 'root';
			
		// Database password
			$CONFIG->dbpass = '8ryl3x!';

		// Database name
			$CONFIG->dbname = 'elggprod2';
			
		// Database server
		// (For most configurations, you can leave this as 'localhost')
			$CONFIG->dbhost = 'localhost';
			
		// Database table prefix
		// If you're sharing a database with other applications, you will want to use this
		// to differentiate Elgg's tables.
			$CONFIG->dbprefix = 'elgg';


	/*
	 * Multiple database connections
	 * 
	 * Here you can set up multiple connections for reads and writes. To do this, uncomment out
	 * the lines below. 
	 */
			
	/*
	 * For extra connections for both reads and writes, you can turn both
	 * $CONFIG->db['read'] and $CONFIG->db['write'] into an array, eg:
	 * 
	 * 	$CONFIG->db['read'][0]->dbhost = "localhost";
	 * 
	 * Note that the array keys must be numeric and consecutive, i.e., they start
	 * at 0, the next one must be at 1, etc.
	 */
	 
	
	/**
	  * Url - I am not sure if this will be here ?
	 **/
	 
	 // URL
	    $CONFIG->url = "";

	$CONFIG->memcache = true;
 
	$CONFIG->memcache_servers = array (
        array('server1', 11211),
        array('server2', 11211)
	);
			
?>
