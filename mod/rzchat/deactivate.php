<?php
/**
 * @version 1.0
 * @copyright Copyright (C) 2014 rayzzz.com. All rights reserved.
 * @license GNU/GPL2, see LICENSE.txt
 * @website http://rayzzz.com
 * @twitter @rayzzzcom
 * @email rayzexpert@gmail.com
 */
 
global $CONFIG;
require_once("include/db.inc.php");
require_once("include/init.inc.php");
$oDb = new RzDbConnect($CONFIG->dbhost, "", "", $CONFIG->dbname, $CONFIG->dbuser, $CONFIG->dbpass);
$oDb->connect();
$oInit = RzInit::getInstance("rzchat");

foreach($oInit->aDBTables as $sName => $aTable)
	$oDb->getResult("DROP TABLE IF EXISTS `" . $CONFIG->dbprefix . $sName . "`;");
