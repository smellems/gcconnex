<?php 
/**
 * @version 1.0
 * @copyright Copyright (C) 2014 rayzzz.com. All rights reserved.
 * @license GNU/GPL2, see LICENSE.txt
 * @website http://rayzzz.com
 * @twitter @rayzzzcom
 * @email rayzexpert@gmail.com
 */
$sFile = realpath(dirname(__FILE__) . '/../../engine/settings.php');
if(file_exists($sFile))
	require_once($sFile);
else
	die("Init file is not found");
	
class rz_integration extends rz_base
{
	var $DB_PREFIX;
	var $sSiteUrl;
	var $sLoginUrl;
	
    function rz_integration($sPath, $sUrl){
		parent::__construct($sPath, $sUrl);
		global $CONFIG;
		$this->oDb = new RzDbConnect($CONFIG->dbhost, "", "", $CONFIG->dbname, $CONFIG->dbuser, $CONFIG->dbpass);
		$this->oDb->connect();
		$this->DB_PREFIX = $CONFIG->dbprefix;
		
		$aUrl = explode("/", $this->sUrl);
		array_pop($aUrl);
		array_pop($aUrl);
		array_pop($aUrl);
		$this->sLoginUrl = $this->sSiteUrl = implode("/", $aUrl) . "/";
    }
	
	function _loginUser($sName, $sPassword, $bLogin = false){
		$sField = $bLogin ? "username" : "guid";
		$iId = (int)$this->oDb->getValue("SELECT `guid` FROM `" . $this->DB_PREFIX . "users_entity` WHERE `" . $sField . "`='" . $sName . "' AND `password`='" . $sPassword . "' LIMIT 1");
		return $iId > 0;
	}
	
	function _loginAdmin($sId, $sPassword){
		$iId = (int)$this->oDb->getValue("SELECT `guid` FROM `" . $this->DB_PREFIX . "users_entity` WHERE `admin`='yes' AND `guid`='" . $sId . "' AND `password`='" . $sPassword . "' LIMIT 1");
		return $iId > 0;
	}
	
	function _getUserInfo($sId, $bNick = false){
		$sWherePart = ($bNick ? "`username`" : "`guid`") . " = '" . $sId . "'";
		$aUser = $this->oDb->getArray("SELECT * FROM `" . $this->DB_PREFIX . "users_entity` AS `users` JOIN `" . $this->DB_PREFIX . "entities` AS `ents` ON `users`.`guid`=`ents`.`guid` WHERE `users`." . $sWherePart . " LIMIT 1");
		$sProfile = $this->sSiteUrl . "profile/" . $aUser["username"];
		$sPhoto = $this->sSiteUrl . "mod/profile/icondirect.php?joindate=" . $aUser["time_created"] . "&guid=" . $aUser["guid"] . "&size=medium";
		return array("id" => (int)$aUser["guid"], "nick" => $aUser['username'], "sex" => "M", "age" => "25", "desc" => "", "photo" => $sPhoto, "profile" => $sProfile);
	}
	
	function _searchUser($sValue, $sField = "ID"){
		if($sField == "ID")
		   $sField = "guid";
		else
		   $sField = "username";
		$sId = $this->oDb->getValue("SELECT `guid` FROM `" . $this->DB_PREFIX . "users_entity` WHERE `" . $sField . "` = '" . $sValue . "' LIMIT 1");
		return $sId;
	}
	
	function _getCurrentLang($sUserId = ""){
		$sLang = $this->oDb->getValue("SELECT `language` FROM `" . $this->DB_PREFIX . "users_entity` WHERE `guid`='" . $sUserId . "' LIMIT 1");
		if(!empty($sLang))
			return $sLang;
		
		return parent::_getCurrentLang($sUserId);
	}

	function _getMembershipId($sUserId){
		return $this->oDb->getValue("SELECT `admin` FROM `" . $this->DB_PREFIX . "users_entity` WHERE `guid`='" . $sUserId . "' LIMIT 1") == 'yes' ? 2 : 1;
	}

	function _getMemberships(){
		return array(
			1 => "Users",
			2 => "Administrators"
		);
	}
}
