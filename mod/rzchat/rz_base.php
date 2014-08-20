<?php 
/**
 * @version 1.0
 * @copyright Copyright (C) 2014 rayzzz.com. All rights reserved.
 * @license GNU/GPL2, see LICENSE.txt
 * @website http://rayzzz.com
 * @twitter @rayzzzcom
 * @email rayzexpert@gmail.com
 */
require_once("include/db.inc.php");
require_once("include/xml.inc.php");

class rz_base
{
	var $sModule = "";
	var $TRUE_VAL = "true";
	var $FALSE_VAL = "false";
	var $SUCCESS_VAL = "success";
	var $FAILED_VAL = "failed";
	var $aXmlTemplates = array (
		"item" => array (
			2 => '<item key="#1#"><![CDATA[#2#]]></item>'
		),
		"result" => array (
			1 => '<result value="#1#" />',
			2 => '<result value="#1#" status="#2#" />'                
		),
		"current" => array (
			2 => '<current name="#1#" url="#2#" />'
		),
		"file" => array (
			2 => '<file name="#1#"><![CDATA[#2#]]></file>'
		)
	);
	var $sUrl;
	var $sPath;
	var $sFilesPath;
	var $oDb;
	var $oXml;
	var $sId;
	
    function rz_base($sPath, $sUrl)
    {
		$this->sPath = $sPath;
		$this->sFilesPath = $this->sPath . "files/";
		$this->sUrl = $sUrl;
		$this->sId = isset($_REQUEST['id']) ? $_REQUEST['id'] : "";
		$this->oXml = new RzXml();
    }
	
	function actionConfig()
	{
		$sFileName = $this->sPath . "data/config.xml";
        $rHandle = fopen($sFileName, "rt");
        $sContents = fread($rHandle, filesize($sFileName)) ;
        fclose($rHandle);
		
		if(is_dir($this->sFilesPath))
			$sContents = str_replace("#filesUrl#", $this->sUrl . "files/", $sContents);
		return $sContents;
	}
	
	function actionSetSetting()
	{
		$sKey = $this->_getRequestVar("key");
		$sValue = $this->_getRequestVar("value");
		$sPassword = $this->_getRequestVar("password");
		if($this->_loginAdmin($this->sId, $sPassword))
		{
			$aResult = $this->_setSettingValue($sKey, $sValue);
			return $this->_parseXml($this->aXmlTemplates['result'], $aResult['value'], $aResult['status']);
		}
		else
			return $this->_parseXml($this->aXmlTemplates['result'], "msgUserAuthenticationFailure", FAILED_VAL);
	}
	
	function actionGetLanguages()
	{
		return $this->_printFiles($this->sId);
	}
	
    function _getSettingValue($sSettingKey, $sFilePath = "", $bFullReturn = false)
	{
		if(empty($sFilePath))
			$sFilePath = $this->sPath . "data/config.xml";
		if(!file_exists($sFilePath)) {
			if($bFullReturn)
				return array('value' => "Cannot open file", 'status' => FAILED_VAL);
			else
				return "";
		}
		$sConfigContents = $this->_makeGroup("", "items");
		if(($rHandle = @fopen($sFilePath, "rt")) !== false && filesize($sFilePath) > 0) {
			$sConfigContents = fread($rHandle, filesize($sFilePath));
			fclose($rHandle);
		}

		//--- Update info ---//
		$sValue = $this->oXml->getValue($sConfigContents, "item", $sSettingKey);
		if($bFullReturn)
			return array('value' => $sValue, 'status' => SUCCESS_VAL);
		else
			return $sValue;
	}

	function _setSettingValue($sSettingKey, $sSettingValue, $sFilePath = "")
	{
		if(empty($sFilePath))
			$sFilePath = $this->sPath . "data/config.xml";
		if(!file_exists($sFilePath))
			return $this->_parseXml($this->aXmlTemplates['result'], "Cannot open file " . $sFilePath, FAILED_VAL);
		$sConfigContents = "";
		if(($rHandle = @fopen($sFilePath, "rt")) !== false && filesize($sFilePath) > 0) {
			$sConfigContents = fread($rHandle, filesize($sFilePath)) ;
			fclose($rHandle);
		}

		//--- Update info ---//
		if(is_array($sSettingKey) && is_array($sSettingValue)) {
			for($i=0; $i<count($sSettingKey); $i++)
				$sConfigContents = $this->oXml->setValue($sConfigContents, "item", $sSettingKey[$i], $sSettingValue[$i]);
		} else
			$sConfigContents = $this->oXml->setValue($sConfigContents, "item", $sSettingKey, $sSettingValue);

		//--- Save changes in the file---//
		$bResult = true;
		if(($rHandle = @fopen($sFilePath, "wt")) !== false) {
			$bResult = (fwrite($rHandle, $sConfigContents) !== false);
			fclose($rHandle);
		}
		$bResult = $bResult && $rHandle;
		$sValue = $bResult ? "" : "Cannot write to file " . $sFilePath;

		return array('value' => $sValue, 'status' => $bResult ? SUCCESS_VAL : FAILED_VAL);
	}

	function _parseXml($aXmlTemplates)
	{
		$iNumArgs = func_num_args();
		$sContent = $aXmlTemplates[$iNumArgs - 1];

		for($i=1; $i<$iNumArgs; $i++) {
			$sValue = func_get_arg($i);
			$sContent = str_replace("#" . $i. "#", $sValue, $sContent);
		}
		return $sContent;
	}

	function _makeGroup($sXmlContent, $sXmlGroup = "rz")
	{
		return "<" . $sXmlGroup . ">" . $sXmlContent . "</" . $sXmlGroup . ">";
	}

	function _getExtraFiles($sUserId = "")
	{
		$sFiles = $this->sPath . "langs/";
		$aFiles = array();
		$sExtension = "xml";

		if($rDirHandle = opendir($sFiles))
			while (false !== ($sFile = readdir($rDirHandle)))
				if(is_file($sFiles . $sFile) && $sFile != "." && $sFile != ".." && $sExtension == substr($sFile, strpos($sFile, ".") + 1)) {
					$aFiles[] = substr($sFile, 0, strpos($sFile, "."));
				}
		closedir($rDirHandle);
		$sDefaultFile = $this->_getCurrentLang($sUserId);

		$sCurrentFile = (in_array($sDefaultFile, $aFiles)) ? $sDefaultFile : $aFiles[0];
		return array('files' => $aFiles, 'current' => $sCurrentFile, 'extension' => $sExtension);
	}

	function _printFiles($sUserId = "")
	{
		$aResult = $this->_getExtraFiles($sUserId);
		$sCurrent = $aResult['current'];
		$sCurrentFile = $sCurrent . "." . $aResult['extension'];

		$sContents = "";

		for($i=0; $i<count($aResult['files']); $i++)
		{
			$sFile = $aResult['files'][$i];
			$sContents .= $this->_parseXml($this->aXmlTemplates['file'], $sFile, $sFile);
		}

		$sContents = $this->_makeGroup($sContents, "files");
		$sContents .= $this->_parseXml($this->aXmlTemplates['current'], $sCurrent, $this->sUrl . "langs/" . $sCurrentFile);

		return $sContents;
	}
	
	function _getCurrentLang($sUserId = "")
	{
		return "en";
	}
	
	function _getRequestVar($sKey, $sType = "string")
	{
		$sValue = isset($_REQUEST[$sKey]) ? $_REQUEST[$sKey] : "";
		switch($sType){
			case "int":
				return (int)$sValue;
			case "boolean":
				return $sValue == $this->TRUE_VAL;
			case "strbool":
				return $sValue == $this->TRUE_VAL ? $this->TRUE_VAL : $this->FALSE_VAL;
			case "string":
			default:
				return $sValue;
		}
	}
	
	function _getCookieVar($sKey, $sDefault = "")
	{
		return isset($_COOKIE[$sKey]) ? $_COOKIE[$sKey] : $sDefault;
	}
	
	/*
	* dump functions for integration
	*/
	function _loginUser($sName, $sPassword, $bLogin = false){
		return true;
	}
	
	function _loginAdmin($sId, $sPassword){
		return true;
	}
	
	function _getUserInfo($sId, $bNick = false){
		return array("id" => 0, "nick" => "no name", "sex" => "male", "age" => 25, "desc" => "no desc", "photo" => "", "profile" => "");
	}
	
	function _searchUser($sValue, $sField = "ID"){
		return $sValue;
	}
	
	function _getMembershipId($sUserId){
		return 0;
	}

	function _getMemberships(){
		return array();
	}
}
