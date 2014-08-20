<?php
/**
 * Elgg memcache support.
 *
 * Requires php5-memcache to work.
 *
 * @package Elgg.Core
 * @subpackage Cache.Memcache
 */

/**
 * Return true if memcache is available and configured.
 *
 * @return bool
 */
function is_memcache_available() {
	global $CONFIG;

	static $memcache_available;

	// cyu - [TODO i think memcache_available is null]
	if ((!isset($CONFIG->memcache)) || (!$CONFIG->memcache) || (!$CONFIG->memcache == NULL)) {
		//elgg_log('cyu - memcache.php: setting memcache to false','NOTICE');
		return false;
	}

	// If we haven't set variable to something
	// cyu - this condition is never met (not sure why)
	if (($memcache_available !== true) && ($memcache_available !== false)) {
		//elgg_log('cyu - memcache.php: memcache is neither true or false','NOTICE');
		try {
			$tmp = new ElggMemcache();
			// No exception thrown so we have memcache available
			$memcache_available = true;
			//elgg_log('cyu - memcache.php: memcache is set to true; tmp is created','NOTICE');
		} catch (Exception $e) {
			$memcache_available = false;
			//elgg_log('cyu - memcache.php: memcache is set to false (exception)','NOTICE');
		}
	}

	//elgg_log('cyu - memcache.php: memcache is...'.$memcache_available,'NOTICE');

	return $memcache_available;
}
