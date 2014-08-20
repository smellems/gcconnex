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
{
	$oDb->getResult("DROP TABLE IF EXISTS `" . $CONFIG->dbprefix . $sName . "`;");
	$sql_main = "CREATE TABLE IF NOT EXISTS `" . $CONFIG->dbprefix . $sName . "` (";
	foreach($aTable['fields'] as $sField => $aField)
	{
		$sql_main .= "`" . $sField . "` " . $aField['type'] . (isset($aField['length']) ? "(" . $aField['length'] . ") " : " ") . ($aField['not null'] ? "NOT NULL " : " ") . (isset($aField['auto_increment']) && $aField['auto_increment'] ? "auto_increment " : " ");
		if(isset($aField['default']))
		{
			if(is_int($aField['default']))
				$sql_main .= "default " . $aField['default'];
			else
				$sql_main .= "default '" . $aField['default'] . "'";
		}
		$sql_main .= ",";
	}
	$sql_main .= "PRIMARY KEY (`" . implode("`,`", $aTable['primary key']) . "`)) ENGINE=MyISAM ROW_FORMAT=DEFAULT";
	$oDb->getResult($sql_main);
}
for($i=0; $i<count($oInit->aDBInserts); $i++)
	$oDb->getResult("INSERT INTO `" . $CONFIG->dbprefix . $oInit->aDBInserts[$i]['table'] . "`(`" . implode("`,`", $oInit->aDBInserts[$i]['columns']) . "`) VALUES('" . implode("','", $oInit->aDBInserts[$i]['values']) . "');");
