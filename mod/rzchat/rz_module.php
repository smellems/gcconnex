<?php 
/**
 * @version 1.0
 * @copyright Copyright (C) 2014 rayzzz.com. All rights reserved.
 * @license GNU/GPL2, see LICENSE.txt
 * @website http://rayzzz.com
 * @twitter @rayzzzcom
 * @email rayzexpert@gmail.com
 */
class rz_module extends rz_integration
{
	var $sModule = "rzchat";
	var $USERS_DB_TABLE;
	var $PROFILES_DB_TABLE;
	var $ROOMS_DB_TABLE;
	var $ROOMS_USERS_DB_TABLE;
	var $MESSAGES_DB_TABLE;
	var $MEMSETS_DB_TABLE;
	var $MEMS_DB_TABLE;
	var $BLOCKED_DB_TABLE;
	var $HISTORY_DB_TABLE;

	var $USER_STATUS_NEW = "new";
	var $USER_STATUS_OLD = "old";
	var $USER_STATUS_KICK = "kick";
	var $USER_STATUS_IDLE = "idle";
	var $USER_STATUS_TYPE = "type";
	var $USER_STATUS_ONLINE = "online";
	var $USER_STATUS_BUSY = "busy";
	var $USER_STATUS_AWAY = "away";
	var $ROOM_STATUS_NORMAL = "normal";
	var $ROOM_STATUS_DELETE = "delete";
	var $CHAT_TYPE_MODER = "moder";
	var $CHAT_TYPE_FULL = "full";
	var $CHAT_TYPE_ADMIN = "admin";

    function rz_module($sPath, $sUrl)
    {
		parent::__construct($sPath, $sUrl);
		$this->USERS_DB_TABLE = $this->DB_PREFIX . $this->sModule . "_current_users";
		$this->PROFILES_DB_TABLE = $this->DB_PREFIX . $this->sModule . "_profiles";
		$this->ROOMS_DB_TABLE = $this->DB_PREFIX . $this->sModule . "_rooms";
		$this->ROOMS_USERS_DB_TABLE = $this->DB_PREFIX . $this->sModule . "_rooms_users";
		$this->MESSAGES_DB_TABLE = $this->DB_PREFIX . $this->sModule . "_messages";
		$this->MEMSETS_DB_TABLE = $this->DB_PREFIX . $this->sModule . "_memberships_settings";
		$this->MEMS_DB_TABLE = $this->DB_PREFIX . $this->sModule . "_memberships";
		$this->BLOCKED_DB_TABLE = $this->DB_PREFIX . $this->sModule . "_blocked_users";
		$this->HISTORY_DB_TABLE = $this->DB_PREFIX . $this->sModule . "_history";
		
		$this->aXmlTemplates["user"] = array (
			2 => '<user id="#1#" status="#2#" />',
			3 => '<user id="#1#" status="#2#" type="#3#" />',
			4 => '<user id="#1#" status="#2#" type="#3#" online="#4#" />',
			8 => '<user id="#1#" sex="#3#" age="#4#" photo="#5#" profile="#6#" banned="#7#" type="#8#"><nick><![CDATA[#2#]]></nick></user>',
			10 => '<user id="#1#" status="#2#" sex="#4#" age="#5#" photo="#7#" profile="#8#" type="#9#" online="#10#"><nick><![CDATA[#3#]]></nick><desc><![CDATA[#6#]]></desc></user>',
			11 => '<user id="#1#" status="#2#" sex="#4#" age="#5#" photo="#7#" profile="#8#" type="#9#" online="#10#" time="#11#"><nick><![CDATA[#3#]]></nick><desc><![CDATA[#6#]]></desc></user>'
		);
		$this->aXmlTemplates["message"] = array (
			15 => '<message id="#1#" room="#3#" author="#4#" user="#5#" whisper="#6#" color="#7#" bold="#8#" underline="#9#" italic="#10#" size="#11#" font="#12#" smileset="#13#" date="#14#" count="#15#"><text><![CDATA[#2#]]></text></message>'
		);
		$this->aXmlTemplates["file"][4] = '<file user="#1#" file="#2#" count="#4#"><name><![CDATA[#3#]]></name></file>';
		$this->aXmlTemplates["room"] = array (
			2 => '<room id="#1#" status="#2#" />',
			3 => '<room id="#1#" in="#2#" out="#3#" />',
			6 => '<room id="#1#" status="#2#" owner="#3#" password="#4#"><title><![CDATA[#5#]]></title><desc><![CDATA[#6#]]></desc></room>',
			7 => '<room id="#1#" in="#6#" inTime="#7#" owner="#2#" password="#3#"><title><![CDATA[#4#]]></title><desc><![CDATA[#5#]]></desc></room>',
			8 => '<room id="#1#" status="#2#" in="#7#" out="#8#" owner="#3#" password="#4#"><title><![CDATA[#5#]]></title><desc><![CDATA[#6#]]></desc></room>'
		);
		$this->aXmlTemplates["smileset"] = array (
			2 => '<properties current="#1#" url="#2#" />',
			3 => '<smileset folder="#1#" config="#2#"><![CDATA[#3#]]></smileset>'
		);
		$this->aXmlTemplates["history"] = array (
			"user" => array(2 => '<user id="#1#"><![CDATA[#2#]]></user>'),
			"room" => array(3 => '<room id="#1#" title="#2#" count="#3#">'),
			"msg" => array(3 => '<msg id="#1#" sender="#2#"><![CDATA[#3#]]></msg>', 4 => '<msg id="#1#" sender="#2#" recipient="#3#"><![CDATA[#4#]]></msg>'),
			"private" => array(3 => '<private sender="#1#" recipient="#2#" count="#3#">')
		);
    }
	
	function actionConfig()	{
        $sContents = parent::actionConfig();
		$iFileSize = (int)$this->_getSettingValue("fileSize");
        $iMaxFileSize = min((ini_get('upload_max_filesize') + 0), (ini_get('post_max_size') + 0), $iFileSize);
        $sContents = str_replace("#fileMaxSize#", $iMaxFileSize, $sContents);		
		$sContents = str_replace("#soundsUrl#", $this->sUrl . "data/sounds/", $sContents);
		$sContents = str_replace("#smilesetsUrl#", $this->sUrl . "data/smilesets/", $sContents);
		$sContents = str_replace("#loginUrl#", $this->sLoginUrl, $sContents);
		return $sContents;
	}
	
	function actionGetPlugins(){
		$sContents = "";
        $sFolder = $this->_getRequestVar("app") == "admin" ? "pluginsAdmin/" : "plugins/";
		$sPluginsPath = $this->sPath . $sFolder;
        if(is_dir($sPluginsPath)) {
            if($rDirHandle = opendir($sPluginsPath))
                while(false !== ($sPlugin = readdir($rDirHandle)))
                    if(strpos($sPlugin, ".swf") === strlen($sPlugin)-4)
                        $sContents .= $this->_parseXml(array(1 => '<plugin><![CDATA[#1#]]></plugin>'), $this->sUrl . $sFolder . $sPlugin);
            closedir($rDirHandle);
        }
        return $this->_makeGroup($sContents, "plugins");
	}
	
	function actionRayzFontSet(){
		$sKey = $this->_getRequestVar("key");
		$sValue = $this->_getRequestVar("value");
        if(!empty($sKey) && !empty($sValue))
			setCookie("RayzFont" . $sKey, $sValue, time() + 31536000);
    }

    function actionRayzFontGet(){
        $aSettings = array (
            8 => '<settings bold="#1#" italic="#2#" underline="#3#" color="#4#" font="#5#" size="#6#" volume="#7#" muted="#8#" />'
        );
        return $this->_parseXml($aSettings, $this->_getFontSetting("bold"), $this->_getFontSetting("italic"), $this->_getFontSetting("underline"), $this->_getFontSetting("color"), $this->_getFontSetting("font"), $this->_getFontSetting("size"), $this->_getFontSetting("volume"), $this->_getFontSetting("muted"));
    }
	
	function _getFontSetting($sName){
		return $this->_getCookieVar($sName);
	}
		
	function actionRzGetBlockingUsers(){
		return $this->_getBlockUsers(true);
	}
	
	function actionRzGetBlockedUsers(){
		return $this->_getBlockUsers(false);
	}

	function _getBlockUsers($bBlocking){
	    $sSelectField = $bBlocking ? "User" : "Blocked";
        $sWhereField = $bBlocking ? "Blocked" : "User";
        
        $sType = $this->oDb->getValue("SELECT `Type` FROM `" . $this->PROFILES_DB_TABLE . "` WHERE `ID`='" . $this->sId . "' LIMIT 1");
        if(empty($sType))
			$sType = $this->CHAT_TYPE_FULL;
        $aAllTypes = array($this->CHAT_TYPE_FULL, $this->CHAT_TYPE_MODER, $this->CHAT_TYPE_ADMIN);
        $iTypeIndex = array_search($sType, $aAllTypes);
        if($bBlocking)
			array_splice($aAllTypes, 0, $iTypeIndex);
        else
			array_splice($aAllTypes, $iTypeIndex+1, count($aAllTypes)-$iTypeIndex-1);
        $sTypes = count($aAllTypes) > 0 ? " AND `profiles`.`Type` IN ('" . implode("','", $aAllTypes) . "')" : "";
        
        $sSql = "SELECT `blocked`.`" . $sSelectField . "` AS `Member` FROM `" . $this->BLOCKED_DB_TABLE . "` AS `blocked` LEFT JOIN `" . $this->PROFILES_DB_TABLE . "` AS `profiles` ON `blocked`.`" . $sSelectField . "`=`profiles`.`ID` WHERE `blocked`.`" . $sWhereField . "`='" . $this->sId . "'" . $sTypes;
        $rResult = $this->oDb->getResult($sSql);
        $aUsers = array();
        for($i=0; $i<$this->oDb->getNumRows($rResult); $i++)
        {
            $aBlocked = $this->oDb->fetch($rResult);
            $aUsers[] = $aBlocked["Member"];
        }
        return $this->_parseXml($this->aXmlTemplates['result'], implode(",", $aUsers));
	}
        
    function actionRzSetBlocked(){
		$sUser = $this->_getRequestVar("user");
		$bBlocked = $this->_getRequestVar("blocked", "boolean");
        if($bBlocked)
        {
            $sBlockedId = $this->oDb->getValue("SELECT `ID` FROM `" . $this->BLOCKED_DB_TABLE . "` WHERE `User`='" . $sId . "' AND `Blocked`='" . $sUser . "' LIMIT 1");
            if(empty($sBlockedId))
				$this->oDb->getResult("INSERT INTO `" . $this->BLOCKED_DB_TABLE . "`(`User`, `Blocked`) VALUES('" . $sId . "', '" . $sUser . "')");
        }
        else
            $this->oDb->getResult("DELETE FROM `" . $this->BLOCKED_DB_TABLE . "` WHERE `User`='" . $sId . "' AND `Blocked`='" . $sUser . "'");
	}

    function actionRayzGetMemberships(){
        $aMemberships = $this->_getMemberships();
        $sMemberships = "";
        foreach($aMemberships as $sId => $sName)
            $sMemberships .= $this->_getMembershipValues($sId, $sName);
        $sContents = $this->_getMembershipSettings(true);
        $sContents .= $this->_makeGroup($sMemberships, "memberships");
		return $sContents;
	}

    function actionRayzSetMembershipSetting(){
		$sKey = $this->_getRequestVar("key");
		$sValue = $this->_getRequestVar("value");
        $aKeys = $this->oDb->getArray("SELECT `keys`.`ID` AS `KeyID`, `values`.`ID` AS `ValueID` FROM `" . $this->MEMSETS_DB_TABLE . "` AS `keys` LEFT JOIN `" . $this->MEMS_DB_TABLE . "` AS `values` ON `keys`.`ID`=`values`.`Setting` AND `values`.`Membership`='" . $sId . "' WHERE `keys`.`Name`='" . $sKey . "' LIMIT 1");
        if(empty($aKeys['KeyID']))
            return $this->_parseXml($this->aXmlTemplates['result'], "Error saving setting.", $this->FAILED_VAL);
        else if(empty($aKeys['ValueID']))
            $this->oDb->getResult("INSERT INTO `" . $this->MEMS_DB_TABLE . "` (`Setting`, `Value`, `Membership`) VALUES('" . $aKeys['KeyID'] . "', '" . $sValue . "', '" . $sId . "')");
        else
            $this->oDb->getResult("UPDATE `" . $this->MEMS_DB_TABLE . "` SET `Value`='" . $sValue . "' WHERE `ID`='" . $aKeys['ValueID'] . "'");
    }

    function actionRayzGetMembership(){
        $sMembership = $this->_getMembershipId($this->sId);
        $sContents = $this->_getMembershipSettings(false);
        $sContents .= $this->_getMembershipValues($sMembership);
		return $sContents;
	}

	function actionRzGuestLogin(){
		$sNick = $this->_getRequestVar("nick");
        $sUserId = $this->_searchUser($sNick, "NickName");
        if(!empty($sUserId))
            return $this->_parseXml($this->aXmlTemplates['result'], "RayzGuestError", $this->FAILED_VAL);

        $this->oDb->getResult("DELETE FROM `" . $this->PROFILES_DB_TABLE . "` WHERE `ID`='" . $this->sId . "' LIMIT 1");
        $this->oDb->getResult("INSERT INTO `" . $this->PROFILES_DB_TABLE . "` SET `ID`='" . $this->sId . "', `Type`='" . $this->CHAT_TYPE_FULL . "', `Smileset`='default'");

        $iCurrentTime = time();
		$sSex = $this->_getRequestVar("sex");
		if(empty($sSex))
			$sSex = "M";
        $sDesc = $this->_getRequestVar("desc");
        $iAge = $this->_getRequestVar("age", "int");
        $sPhoto = $this->sUrl . "data/" . ($sSex == "F" ? "female.jpg" : "male.jpg");

		$this->oDb->getResult("REPLACE INTO `" . $this->USERS_DB_TABLE . "` SET `ID`='" . $this->sId . "', `Nick`='" . $sNick . "', `Sex`='" . $sSex . "', `Age`='" . $iAge . "', `Desc`='" . $sDesc . "', `Photo`='" . $sPhoto . "', `Profile`='', `Start`='" . $iCurrentTime . "', `When`='" . $iCurrentTime . "', `Status`='" . $this->USER_STATUS_NEW . "'");
		$this->oDb->getResult("DELETE FROM `" . $this->ROOMS_USERS_DB_TABLE . "` WHERE `User`='" . $this->sId . "'");
		
        $sContents = $this->_parseXml($this->aXmlTemplates['result'], "", $this->SUCCESS_VAL);
        $sContents .= $this->_parseXml(array(2 => '<user photo="#1#" profile="#2#" />'), $sPhoto, "");
		return $sContents;
	}

    function actionUserAuthorize(){
		$bBanned = false;
		$sPassword = $this->_getRequestVar("password");
        if($this->_loginAdmin($this->sId, $sPassword)) {
            $aUserInfo = $this->_getUserInfo($this->sId);
            $aUser = array('id' => $aUserInfo['id'], 'nick' => $aUserInfo['nick'], 'sex' => $aUserInfo['sex'], 'age' => $aUserInfo['age'], 'desc' => $aUserInfo['desc'], 'photo' => $aUserInfo['photo'], 'profile' => $aUserInfo['profile'], 'type' => $this->CHAT_TYPE_ADMIN);
        } elseif($this->_loginUser($this->sId, $sPassword) && ($bBanned = $this->_doBan("check", $this->sId)) != TRUE) {
            $aUser = $this->_getUserInfo($this->sId);
            $aUser['id'] = $this->sId;
            $aUser['sex'] = $aUser['sex'] == 'female' ? "F" : "M";
            $aUser['type'] = $this->CHAT_TYPE_FULL;
        } else {
            return $this->_parseXml($this->aXmlTemplates['result'], $bBanned ? "msgBanned" : "msgUserAuthenticationFailure", $this->FAILED_VAL);
        }
        $aUser = $this->_initUser($aUser);
        $sContents = $this->_parseXml($this->aXmlTemplates['result'], "", $this->SUCCESS_VAL);
        $sContents .= $this->_parseXml($this->aXmlTemplates['user'], $aUser['id'], $this->USER_STATUS_NEW, $aUser['nick'], $aUser['sex'], $aUser['age'], $aUser['desc'], $aUser['photo'], $aUser['profile'], $aUser['type'], $this->USER_STATUS_ONLINE);
		return $sContents;
    }

    function actionBanUser(){
		$sBanned = $this->_getRequestVar("banned", "strbool");
        $sUserId = $this->oDb->getValue("SELECT `ID` FROM `" . $this->PROFILES_DB_TABLE ."` WHERE `ID` = '" . $sId . "' LIMIT 1");
        $this->oDb->getResult(empty($sUserId)
            ? "INSERT INTO `" . $this->PROFILES_DB_TABLE . "`(`ID`, `Banned`) VALUES('" . $this->sId . "', '" . $sBanned . "')"
            : "UPDATE `" . $this->PROFILES_DB_TABLE . "` SET `Banned`='" . $sBanned . "' WHERE `ID`='" . $this->sId . "'");
    }

    function actionChangeUserType(){
		$sType = $this->_getRequestVar("type");
        $sUserId = $this->oDb->getValue("SELECT `ID` FROM `" . $this->PROFILES_DB_TABLE ."` WHERE `ID` = '" . $this->sId . "' LIMIT 1");
        $this->oDb->getResult(empty($sUserId)
            ? "INSERT INTO `" . $this->PROFILES_DB_TABLE . "`(`ID`, `Type`) VALUES('" . $this->sId . "', '" . $sType . "')"
            : "UPDATE `" . $this->PROFILES_DB_TABLE . "` SET `Type`='" . $sType . "' WHERE `ID`='" . $this->sId . "'");
    }

    function actionSearchUser(){
		$sParam = $this->_getRequestVar("param");
		$sValue = $this->_getRequestVar("value");
        $sUserId = $this->_searchUser($sValue, $sParam);
        if(empty($sUserId))
			return $this->_parseXml($this->aXmlTemplates['result'], "No User Found.", $this->FAILED_VAL);

        $aUser = $this->_getUserInfo($sUserId);
        $aUser['sex'] = $aUser['sex'] == "female" ? "F" : "M";
        $aProfile = $this->oDb->getArray("SELECT * FROM `" . $this->PROFILES_DB_TABLE ."` WHERE `ID` = '" . $sUserId . "' LIMIT 1");
        if(!is_array($aProfile) || count($aProfile) == 0)
			$aProfile = array("Banned" => $this->FALSE_VAL, "Type" => $this->CHAT_TYPE_FULL);

        $sContents = $this->_parseXml($this->aXmlTemplates['result'], "", $this->SUCCESS_VAL);
        $sContents .= $this->_parseXml($this->aXmlTemplates['user'], $sUserId, $aUser['nick'], $aUser['sex'], $aUser['age'], $aUser['photo'], $aUser['profile'], $aProfile['Banned'], $aProfile['Type']);
		return $sContents;
    }

    function actionGetSounds(){
        $sFileName = $this->sPath . "data/sounds.xml";
        if(file_exists($sFileName)) {
            $rHandle = fopen($sFileName, "rt");
            $sContents = fread($rHandle, filesize($sFileName));
            fclose($rHandle);
        }
		else 
			$sContents = $this->_makeGroup("", "items");
        return $sContents;
	}

    function actionGetSmilesets(){
        $sConfigFile = "config.xml";
		$sSmilesetsPath = $this->sPath . "data/smilesets/";
        $aSmilesets = array();
        if($rDirHandle = opendir($sSmilesetsPath))
            while(false !== ($sDir = readdir($rDirHandle)))
                if($sDir != "." && $sDir != ".." && is_dir($sSmilesetsPath . $sDir) && file_exists($sSmilesetsPath . $sDir . "/" . $sConfigFile))
                    $aSmilesets[] = $sDir;
        closedir($rDirHandle);
        if(count($aSmilesets) == 0)
			return $this->_parseXml($this->aXmlTemplates['smileset'], "", "") . $this->_makeGroup("", "smilesets");

		$sDefSmileset = "default";
		$sDefSmileset = $this->_getCookieVar("RayzFontsmileset", $sDefSmileset);
		$sDefSmileset = str_replace("/", "", $sDefSmileset);
        if(!in_array($sDefSmileset, $aSmilesets))
            $sDefSmileset = $aSmilesets[0];
        $sUserSmileset = $this->oDb->getValue("SELECT `Smileset` FROM `" . $this->PROFILES_DB_TABLE . "` WHERE `ID`='" . $this->sId . "'");
        if(empty($sUserSmileset) || !file_exists($sSmilesetsPath . $sUserSmileset))
			$sUserSmileset = $sDefSmileset;

        $sContents = $this->_parseXml($this->aXmlTemplates['smileset'], $sUserSmileset . "/", $this->sUrl . "data/smilesets/");
        $sData = "";
        for($i=0; $i<count($aSmilesets); $i++) {
            $sName = $this->_getSettingValue("name", $sSmilesetsPath . $aSmilesets[$i] . "/config.xml");
            $sData .= $this->_parseXml($this->aXmlTemplates['smileset'], $aSmilesets[$i] . "/", $sConfigFile, empty($sName) ? $aSmilesets[$i] : $sName);
        }
        $sContents .= $this->_makeGroup($sData, "smilesets");
        return $sContents;
	}

    function actionSetSmileset(){
        $this->oDb->getResult("UPDATE `" . $this->PROFILES_DB_TABLE . "` SET `Smileset`='" . $sSmileset . "' WHERE `ID`='" . $this->sId . "'");
    }
		
    function actionGetRooms(){
        $this->_doRoom('deleteTemp');
        return $this->_makeGroup($this->_getRooms("all", $this->sId), "rooms");
	}

    function actionCreateRoom(){
		$bTemp = $this->_getRequestVar("temp", "boolean");
		$sRoom = $this->_getRequestVar("room");
		$sPassword = $this->_getRequestVar("password");
		$sDesc = $this->_getRequestVar("desc");
        $iRoomId = $this->_doRoom('insert', $this->sId, 0, $sRoom, $sPassword, $sDesc, $bTemp);
        if(empty($iRoomId))
			return $this->_parseXml($this->aXmlTemplates['result'], "msgErrorCreatingRoom", $this->FAILED_VAL);
        else 
			return $this->_parseXml($this->aXmlTemplates['result'], $iRoomId, $this->SUCCESS_VAL);
	}

    function actionEditRoom(){
		$iRoomId = $this->_getRequestVar("roomId", "int");
		$sRoom = $this->_getRequestVar("room");
		$sPassword = $this->_getRequestVar("password");
		$sDesc = $this->_getRequestVar("desc");
        $this->_doRoom('update', 0, $iRoomId, $sRoom, $sPassword, $sDesc);
        return $this->_parseXml($this->aXmlTemplates['result'], "", $this->SUCCESS_VAL);
    }

    function actionDeleteRoom(){
		$iRoomId = $this->_getRequestVar("roomId", "int");
        $this->_doRoom('delete', 0, $iRoomId);
        return $this->_parseXml($this->aXmlTemplates['result'], $this->TRUE_VAL);
    }

    function actionEnterRoom(){
		$iRoomId = $this->_getRequestVar("roomId", "int");
        $this->_doRoom('enter', $this->sId, $iRoomId);
    }

    function actionExitRoom(){
		$iRoomId = $this->_getRequestVar("roomId", "int");
        $this->_doRoom('exit', $this->sId, $iRoomId);
    }

    function actionCheckRoomPassword(){
		$iRoomId = $this->_getRequestVar("roomId", "int");
		$sPassword = $this->_getRequestVar("password");
        $sId = $this->oDb->getValue("SELECT `ID` FROM `" . $this->ROOMS_DB_TABLE . "` WHERE `ID`='" . $iRoomId . "' AND `Password`='" . $sPassword . "' LIMIT 1");
        if(empty($sId))
			return $this->_parseXml($this->aXmlTemplates['result'], "msgWrongRoomPassword", $this->FAILED_VAL);
        else
			return $this->_parseXml($this->aXmlTemplates['result'], "", $this->SUCCESS_VAL);
    }

    function actionGetOnlineUsers(){
        $rResult = $this->oDb->getResult("SELECT `ID` FROM `" . $this->USERS_DB_TABLE . "`");
        if($this->oDb->getNumRows($rResult) == 0)
			$this->oDb->getResult("TRUNCATE TABLE `" . $this->USERS_DB_TABLE . "`");
        $rResult = $this->oDb->getResult("SELECT `ID` FROM `" . $this->MESSAGES_DB_TABLE . "`");
        if($this->oDb->getNumRows($rResult) == 0)
			$this->oDb->getResult("TRUNCATE TABLE `" . $this->MESSAGES_DB_TABLE . "`");
        return $this->_refreshUsersInfo($this->sId);
    }

    function actionSetOnline(){
        $this->oDb->getResult("UPDATE `" . $this->USERS_DB_TABLE . "` SET `Online`='" . $sOnline . "', `When`='" . time() . "', `Status`='" . $this->USER_STATUS_ONLINE . "' WHERE `ID`='" . $this->sId . "'");
    }

    function actionUpdate(){
        $sFiles = "";
		$iLastUpdate = $this->_getLastUpdate($this->sId);
        $res = $this->oDb->getResult("SELECT * FROM `" . $this->MESSAGES_DB_TABLE . "` WHERE `Type`='file' AND `Recipient`='" . $this->sId . "'");
        while($aFile = $this->oDb->fetch($res)) {
            $sFileName = $aFile['ID'] . ".file";
            if(!file_exists($this->sFilesPath . $sFileName))
				continue;
            $sFiles .= $this->_parseXml($this->aXmlTemplates['file'], $aFile['Sender'], $sFileName, $aFile['Message'], $aFile['Count']);
        }
        $this->oDb->getResult("DELETE FROM `" . $this->MESSAGES_DB_TABLE . "` WHERE `Type`='file' AND `Recipient`='" . $this->sId . "'");
        $sContents = $this->_makeGroup($sFiles, "files");
        $sContents .= $this->_refreshUsersInfo($this->sId, 'update', $iLastUpdate);
        $sContents .= $this->_makeGroup($this->_getRooms('update', $this->sId, $iLastUpdate), "rooms");
        $sContents .= $this->_makeGroup($this->_getRooms('updateUsers', $this->sId, $iLastUpdate), "roomsUsers");

        $sMsgs = "";
        $sRooms = $this->oDb->getValue("SELECT GROUP_CONCAT(DISTINCT `Room` SEPARATOR ',') FROM `" . $this->ROOMS_USERS_DB_TABLE . "` WHERE `User`='" . $this->sId . "' AND `Status`='" . $this->ROOM_STATUS_NORMAL ."'");
        if(empty($sRooms))
			$sRooms = "''";
        $sSql = "SELECT * FROM `" . $this->MESSAGES_DB_TABLE . "` WHERE `Type`='text' AND `Sender`<>'" . $this->sId . "' AND ((`Room` IN (" . $sRooms . ") AND `Whisper`='" . $this->FALSE_VAL . "') OR `Recipient`='" . $this->sId . "') AND `When`>='" . $iLastUpdate . "' ORDER BY `ID`";
        $res = $this->oDb->getResult($sSql);
        while($aMsg = $this->oDb->fetch($res)) {
            $aStyle = unserialize($aMsg['Style']);
            $sMsgs .= $this->_parseXml($this->aXmlTemplates['message'], $aMsg['ID'], stripslashes($aMsg['Message']), $aMsg['Room'], $aMsg['Sender'], $aMsg['Recipient'], $aMsg['Whisper'], $aStyle['color'], $aStyle['bold'], $aStyle['underline'], $aStyle['italic'], $aStyle['size'], $aStyle['font'], $aStyle['smileset'], $aMsg['When'], $aMsg['Count']);
        }
        $sContents .= $this->_makeGroup($sMsgs, "messages");
        return $sContents;
	}

    function actionNewMessage(){
		$sSender = $this->_getRequestVar("sender");
        if(empty($sSender))
			return;
		$sWhisper = $this->_getRequestVar("whisper", "strbool");
		$iRoomId = $this->_getRequestVar("roomId", "int");
		$iCount = $this->_getRequestVar("count", "int");
		$iColor = $this->_getRequestVar("color", "int");
		$sBold = $this->_getRequestVar("bold", "strbool");
		$sUnderline = $this->_getRequestVar("underline", "strbool");
		$sItalic = $this->_getRequestVar("italic", "strbool");
		$iSize = $this->_getRequestVar("size", "int");
		if(empty($iSize))
			$iSize = 12;
		$sFont = $this->_getRequestVar("font");
		if(empty($sFont))
			$sFont = "Arial";
		$sSmileset = $this->_getRequestVar("smileset");
		$sRcp = $this->_getRequestVar("recipient");
		$sMessage = $this->_getRequestVar("message");
        $sStyle = serialize(array('color' => $iColor, 'bold' => $sBold, 'underline' => $sUnderline, 'italic' => $sItalic, 'smileset' => $sSmileset, 'size' => $iSize, 'font' => $sFont));
		$iTime = time();
        $this->oDb->getResult("INSERT INTO `" . $this->MESSAGES_DB_TABLE . "`(`Room`, `Count`, `Sender`, `Recipient`, `Message`, `Whisper`, `Style`, `When`) VALUES('" . $iRoomId . "', '" . $iCount . "', '" . $sSender . "', '" . $sRcp . "', '" . $sMessage . "', '" . $sWhisper . "', '" . $sStyle . "', '" . $iTime . "')");
		if(empty($iRoomId))
			$sSndRcp = strcmp($sSender, $sRcp) < 0 ? $sSender . "." . $sRcp : $sRcp . "." . $sSender;
		else
			$sSndRcp = "";
		$this->oDb->getResult("INSERT INTO `" . $this->HISTORY_DB_TABLE . "`(`Room`, `SndRcp`, `Sender`, `Recipient`, `Message`, `When`) VALUES('" . $iRoomId . "', '" . $sSndRcp . "', '" . $sSender . "', '" . $sRcp . "', '" . $sMessage . "', '" . $iTime . "')");
    }
	
	function actionGetHistory(){
		$iDay = $this->_getRequestVar("day", "int");
		$iMonth = $this->_getRequestVar("month", "int");
		$iYear = $this->_getRequestVar("year", "int");
		$iStartDate = mktime(0, 0, 0, $iMonth, $iDay, $iYear);
		$iEndDate = mktime(0, 0, 0, $iMonth, ($iDay+1), $iYear);
		$aMessages = array();
		$aUsers = array();
		$rRes = $this->oDb->getResult("SELECT * FROM `" . $this->HISTORY_DB_TABLE . "` WHERE `When`>=" . $iStartDate . " AND `When`<" . $iEndDate . " ORDER BY `Room`, `Sender`, `Recipient` ASC");
		if($this->oDb->getNumRows($rRes) == 0)
			return $this->_makeGroup("", "users") . $this->_makeGroup("", "rooms") . $this->_makeGroup("", "privates");
		
		//users
		for($i=0; $i<$this->oDb->getNumRows($rRes); $i++)
		{
			$aMsg = $this->oDb->fetch($rRes);
			$aMessages[] = $aMsg;
			if(!empty($aMsg['Sender']))
				$aUsers[] = $aMsg['Sender'];
			if(!empty($aMsg['Recipient']))
				$aUsers[] = $aMsg['Recipient'];
		}		
		$sUsers = "";
		$aUsers = array_flip(array_unique($aUsers));
		foreach($aUsers as $iUserId => $sValue)
		{
			$aUser = $this->_getUserInfo($iUserId);
			$sUsers .= $this->_parseXml($this->aXmlTemplates['history']['user'], $iUserId, $aUser['nick']);
		}
		$sContents = $this->_makeGroup($sUsers, "users");
		
		//rooms dialogs
		$rResRooms = $this->oDb->getResult("SELECT `history`.*, `rooms`.`Name` AS `Title` FROM `" . $this->HISTORY_DB_TABLE . "` AS `history` INNER JOIN `" . $this->ROOMS_DB_TABLE . "` AS `rooms` ON `history`.`Room`=`rooms`.`ID` WHERE `history`.`Room`>0 AND `history`.`When`>=" . $iStartDate . " AND `history`.`When`<" . $iEndDate . " ORDER BY `Room`, `When` ASC");
		$sRooms = "";
		$sMsgs = "";
		$iRoom = 0;
		$iCount = 0;
		$sRoom = "";
		for($i=0; $i<$this->oDb->getNumRows($rResRooms); $i++)
		{
			$aMsg = $this->oDb->fetch($rResRooms);
			if($aMsg['Room'] != $iRoom)
			{
				if(!empty($sRoom) && !empty($sMsgs))
				{
					$sRooms .= $this->_parseXml($this->aXmlTemplates['history']['room'], $iRoom, $sRoom, $iCount) . $sMsgs . "</room>";
					$sMsgs = "";
					$iCount = 0;
				}
				$iRoom = $aMsg['Room'];
				$sRoom = $aMsg['Title'];				
			}
			$iCount++;
			$sMsgs .= $this->_parseXml($this->aXmlTemplates['history']['msg'], $aMsg['ID'], $aMsg['Sender'], $aMsg['Recipient'], $aMsg['Message']);
		}
		if(!empty($sRoom) && !empty($sMsgs))
			$sRooms .= $this->_parseXml($this->aXmlTemplates['history']['room'], $iRoom, $sRoom, $iCount) . $sMsgs . "</room>";
		$sContents .= $this->_makeGroup($sRooms, "rooms");
		
		//private dialogs
		$rResMsgs = $this->oDb->getResult("SELECT * FROM `" . $this->HISTORY_DB_TABLE . "` WHERE `Room`=0 AND `When`>=" . $iStartDate . " AND `When`<" . $iEndDate . " ORDER BY `SndRcp`, `When` ASC");
		$sPrivate = "";
		$sMsgs = "";
		$sSndRcp = "";
		$iCount = 0;
		for($i=0; $i<$this->oDb->getNumRows($rResMsgs); $i++)
		{
			$aMsg = $this->oDb->fetch($rResMsgs);
			if($aMsg['SndRcp'] != $sSndRcp)
			{
				if(!empty($sMsgs))
				{
					$sPrivate .= $this->_parseXml($this->aXmlTemplates['history']['private'], $aMsg['Sender'], $aMsg['Recipient'], $iCount) . $sMsgs . "</private>";
					$sMsgs = "";
					$iCount = 0;
				}
				$sSndRcp = $aMsg['SndRcp'];
			}
			$iCount++;
			$sMsgs .= $this->_parseXml($this->aXmlTemplates['history']['msg'], $aMsg['ID'], $aMsg['Sender'], $aMsg['Message']);
		}
		if(!empty($sMsgs))
			$sPrivate .= $this->_parseXml($this->aXmlTemplates['history']['private'], $aMsg['Sender'], $aMsg['Recipient'], $iCount) . $sMsgs . "</private>";
		$sContents .= $this->_makeGroup($sPrivate, "privates");
		return $sContents;
	}

    function actionUploadFile(){
		$sSender = $this->_getRequestVar("sender");
        if(empty($sSender))
			return;
        if(is_uploaded_file($_FILES['Filedata']['tmp_name'])) {
            $sFilePath = $this->sFilesPath . $sSender . ".temp";
            @unlink($sFilePath);
            move_uploaded_file($_FILES['Filedata']['tmp_name'], $sFilePath);
            @chmod($sFilePath, 0644);
        }
    }

    function actionInitFile(){
		$sSender = $this->_getRequestVar("sender");
        $sFilePath = $this->sFilesPath . $sSender . ".temp";
        $sContents = $this->_parseXml($this->aXmlTemplates['result'], "msgErrorUpload", $this->FAILED_VAL);
        if(empty($sSender) || !file_exists($sFilePath) || filesize($sFilePath) == 0)
			return $sContents;

		$iCount = $this->_getRequestVar("count", "int");
		$sRcp = $this->_getRequestVar("recipient");
		$sMessage = $this->_getRequestVar("message");
        $this->oDb->getResult("INSERT INTO `" . MESSAGES_DB_PREFIX . "`(`Count`, `Sender`, `Recipient`, `Message`, `Type`, `When`) VALUES('" . $iCount . "', '" . $sSender . "', '" . $sRcp . "', '" . $sMessage . "', 'file', '" . time() . "')");
        $sFileName = $this->oDb->getLastInsertId() . ".file";
        if(!@rename($sFilePath, $this->sFilesPath . $sFileName))
			return $sContents;

        return $this->_parseXml($this->aXmlTemplates['result'], $sFileName, $this->SUCCESS_VAL);
    }

    function actionRemoveFile(){
        $sId = str_replace(".file", "", $this->sId);
        $this->_removeFile($sId);
    }

    function actionHelp(){
        $sContents = $this->_makeGroup("", "topics");
        $sFileName = $this->sPath . "data/help.xml";
        if(file_exists($sFileName)) {
            $rHandle = @fopen($sFileName, "rt");
            $sContents = @fread($rHandle, filesize($sFileName)) ;
            fclose($rHandle);
        }
		return $sContents;
    }
	
	function actionGetPhrases(){
        $sContents = $this->_makeGroup("", "items");
        $sFileName = $this->sPath . "data/phrases.xml";
        if(file_exists($sFileName)) {
            $rHandle = @fopen($sFileName, "rt");
            $sContents = @fread($rHandle, filesize($sFileName)) ;
            fclose($rHandle);
        }
		return $sContents;
    }
		
	function actionUploadRoomImage(){
		@unlink($this->_getRoomImage($this->sId));
		$aSize = getimagesize($_FILES['Filedata']['tmp_name']);
		if(is_uploaded_file($_FILES['Filedata']['tmp_name']) && $aSize)
		{
			switch($aSize[2])
			{
				case 1:
					$sExt = "gif";
					break;
				case 2:
					$sExt = "jpg";
					break;
				case 3:
					$sExt = "png";
					break;
				default:
					$sExt = "";
					break;
			}
			if(empty($sExt))
				return;
			$sFilePath = $this->sFilesPath . "room_" . $this->sId . "." . $sExt;
			move_uploaded_file($_FILES['Filedata']['tmp_name'], $sFilePath);
			@chmod($sFilePath, 0644);
		}
	}
		
	function actionCheckRoomImage(){
		$sFilePath = $this->_getRoomImage($this->sId);
		if(file_exists($sFilePath) && filesize($sFilePath)>0)
			return $this->_parseXml($this->aXmlTemplates['result'], "", $this->SUCCESS_VAL);
		else
			return $this->_parseXml($this->aXmlTemplates['result'], "", $this->FAILED_VAL);
	}
	
	function actionRoomImage(){
		setlocale(LC_ALL, 'EN_US');
		header('Expires: ' . gmdate('D, d M Y H:i:s', time()) . ' GMT');
		$sFilePath = $this->_getRoomImage($this->sId);
		if(filesize($sFilePath)>0)
		{
			$sExt = substr($sFilePath, -3);
			if($sExt == "jpg")
				$sExt = "jpeg";
			header("Content-Type: image/" . $sExt);
			readfile($sFilePath);
			die();
		}
	}
	
	function actionPhrases(){
		$sFileName = $this->sPath . "data/phrases.xml";
		$sContents = "";
        @$rHandle = fopen($sFileName, "rt");
        @$sContents = fread($rHandle, filesize($sFileName)) ;
        @fclose($rHandle);
		return $sContents;
	}
	
	function _getRoomImage($sId)
	{
		$sFile = $this->sFilesPath . "room_" . $sId . ".";
		if(file_exists($sFile . "jpg")) return $sFile . "jpg";
		if(file_exists($sFile . "png")) return $sFile . "png";
		if(file_exists($sFile . "gif")) return $sFile . "gif";
		return "";
	}

	function _getMembershipValues($sMembership, $sName = "")
	{
		$rResult = $this->oDb->getResult("SELECT `keys`.`ID` AS `ID`, `keys`.`Default` AS `Default`, `values`.`Value` AS `Value` FROM `" . $this->MEMSETS_DB_TABLE . "` AS `keys` LEFT JOIN `" . $this->MEMS_DB_TABLE . "` AS `values` ON `keys`.`ID`=`values`.`Setting` AND `values`.`Membership`='" . $sMembership . "'");
		$sContents = '<membership id="' . $sMembership . '" ';
		for($i=0; $i<$this->oDb->getNumRows($rResult); $i++) {
			$aSetting = $this->oDb->fetch($rResult);
			$sValue = !isset($aSetting['Value']) || $aSetting['Value'] == "" ? $aSetting['Default'] : $aSetting['Value'];
			$sContents .= 'v' . $aSetting['ID'] . '="' . $sValue . '" ';
		}
		$sEnd = empty($sName) ? '/>' : '><![CDATA[' . $sName . ']]></membership>';
		$sContents .= $sEnd;
		return $sContents;
	}

	function _getMembershipSettings($bAdmin = false)
	{
		$aSettingTmpls = array(
			3 => '<setting id="#1#" name="#2#"><![CDATA[#3#]]></setting>',
			6 => '<setting id="#1#" name="#2#" type="#3#" default="#4#" range="#5#"><![CDATA[#6#]]></setting>'
		);

		$rResult = $this->oDb->getResult("SELECT * FROM `" . $this->MEMSETS_DB_TABLE . "`");
		$sSettings = "";
		for($i=0; $i<$this->oDb->getNumRows($rResult); $i++) {
			$aSetting = $this->oDb->fetch($rResult);
			if($bAdmin) 
				$sSettings .= $this->_parseXml($aSettingTmpls, $aSetting['ID'], $aSetting['Name'], $aSetting['Type'], $aSetting['Default'], $aSetting['Range'], $aSetting['Caption']);
			else
				$sSettings .= $this->_parseXml($aSettingTmpls, $aSetting['ID'], $aSetting['Name'], $aSetting['Error']);
		}
		return $this->_makeGroup($sSettings, "settings");
	}

	function _initUser($aUser)
	{
		$aProfile = $this->oDb->getArray("SELECT * FROM `" . $this->PROFILES_DB_TABLE . "` WHERE `ID`='" . $aUser['id'] . "'");
		if(!is_array($aProfile) || count($aProfile) == 0)
			$this->oDb->getResult("INSERT INTO `" . $this->PROFILES_DB_TABLE . "` SET `ID`='" . $aUser['id'] . "', `Type`='" . $aUser['type'] . "', `Smileset`='default'");
		else 
			$aUser['type'] = $aProfile["Type"];
		$iCurrentTime = time();
		$this->oDb->getResult("REPLACE `" . $this->USERS_DB_TABLE . "` SET `ID`='" . $aUser['id'] . "', `Nick`='" . $aUser['nick'] . "', `Sex`='" . $aUser['sex'] . "', `Age`='" . $aUser['age'] . "', `Desc`='" . addslashes($aUser['desc']) . "', `Photo`='" . $aUser['photo'] . "', `Profile`='" . $aUser['profile'] . "', `Start`='" . $iCurrentTime . "', `When`='" . $iCurrentTime . "', `Status`='" . $this->USER_STATUS_NEW . "'");
		$this->oDb->getResult("DELETE FROM `" . $this->ROOMS_USERS_DB_TABLE . "` WHERE `User`='" . $aUser['id'] . "'");
		$rFiles = $this->oDb->getResult("SELECT `ID` FROM `" . $this->MESSAGES_DB_TABLE . "` WHERE `Recipient`='" . $aUser['id'] . "' AND `Type`='file'");
		while($aFile = $this->oDb->fetch($rFiles))
			$this->_removeFile($aFile['ID']);
		return $aUser;
	}

	function _doBan($sSwitch, $sId = "0")
	{
		switch($sSwitch) {
			case 'check':
				return $this->oDb->getValue("SELECT `Banned` FROM `" . $this->PROFILES_DB_TABLE . "` WHERE `ID` = '" . $sId . "' LIMIT 1") == $this->TRUE_VAL;
			case 'ban':
				$sBan = $this->TRUE_VAL;
				//break shouldn't be here
			case 'unban':
				$sBan = $this->FALSE_VAL;
			default:
				$sUserId = $this->oDb->getValue("SELECT `ID` FROM `" . $this->PROFILES_DB_TABLE . "` WHERE `ID` = '" . $sId . "' LIMIT 1");
				$sSql = empty($sUserId)
					? "INSERT INTO `" . $this->PROFILES_DB_TABLE . "`(`ID`, `Banned`, `Type`) VALUES('" . $sId . "', '" . $sBan . "', '" . $this->CHAT_TYPE_FULL . "')"
					: "UPDATE `" . $this->PROFILES_DB_TABLE . "` SET `Banned`='" . $sBan . "' WHERE `ID`='" . $sId . "'";
				return $this->oDb->getResult($sSql);
		}
	}

	function _getRooms($sMode = "new", $sId = "", $iLastUpdate = 0)
	{
		$iCurrentTime = time();
		$iUpdateInterval = (int)$this->_getSettingValue("updateInterval");
		$sRooms = "";
		switch ($sMode) {
			case 'update':
				$rResult = $this->oDb->getResult("SELECT * FROM `" . $this->ROOMS_DB_TABLE . "` WHERE IF('" . $sId . "'='0', 1, `OwnerID`<>'" . $sId . "') AND (`When` >= " . $iLastUpdate . ") ORDER BY `When`");
				while($aRoom = $this->oDb->fetch($rResult))
					switch($aRoom['Status']) {
						case $this->ROOM_STATUS_DELETE:
							$sRooms .= $this->_parseXml($aXmlTemplates['room'], $aRoom['ID'], $this->ROOM_STATUS_DELETE);
							break;
						case $this->ROOM_STATUS_NORMAL:
						default:
							$sRooms .= $this->_parseXml($this->aXmlTemplates['room'], $aRoom['ID'], $this->ROOM_STATUS_NORMAL, $aRoom['OwnerID'], empty($aRoom['Password']) ? $this->FALSE_VAL : $this->TRUE_VAL, stripslashes($aRoom['Name']), stripslashes($aRoom['Desc']));
							break;
					}
				break;

			case 'updateUsers':
				$sSql = "SELECT `r`.`ID` AS `RoomID`, GROUP_CONCAT(DISTINCT IF(`ru`.`Status`='" . $this->ROOM_STATUS_NORMAL . "',`ru`.`User`,'') SEPARATOR ',') AS `In`, GROUP_CONCAT(DISTINCT IF(`ru`.`Status`='" . $this->ROOM_STATUS_DELETE . "',`ru`.`User`,'') SEPARATOR ',') AS `Out` FROM `" . $this->ROOMS_DB_TABLE . "` AS `r` INNER JOIN `" . $this->ROOMS_USERS_DB_TABLE . "` AS `ru` WHERE `r`.`ID`=`ru`.`Room` AND `r`.`Status`='" . $this->ROOM_STATUS_NORMAL . "' AND `ru`.`When`>=" . $iLastUpdate . " GROUP BY `r`.`ID`";
				$rResult = $this->oDb->getResult($sSql);
				while($aRoom = $this->oDb->fetch($rResult))
					$sRooms .= $this->_parseXml($this->aXmlTemplates['room'], $aRoom['RoomID'], $aRoom['In'], $aRoom['Out']);
				break;

			case 'all':
				$iRunTime = floor($this->_getRequestVar("_t", "int") / 1000);
				$iCurrentTime -= $iRunTime;
				$rResult = $this->oDb->getResult("SELECT `ID` FROM `" . $this->ROOMS_USERS_DB_TABLE . "`");
				if($this->oDb->getNumRows($rResult) == 0)
					$this->oDb->getResult("TRUNCATE TABLE `" . $this->ROOMS_USERS_DB_TABLE . "`");
				$iRoomsCount = $this->oDb->getValue("SELECT COUNT(`ID`) FROM `" . $this->ROOMS_DB_TABLE . "`");

				if(empty($iRoomsCount))
					$this->oDb->getResult("INSERT INTO `" . $this->ROOMS_DB_TABLE . "` (`Name`, `OwnerID`, `Desc`, `When`, `Status`) VALUES ('Lobby', '0', 'Welcome to our chat!', '0', '" . $this->ROOM_STATUS_NORMAL . "')");

				$sSql = "SELECT `r`.`ID` AS `RoomID`, `r`.*, GROUP_CONCAT(DISTINCT IF(`ru`.`Status`='" . $this->ROOM_STATUS_NORMAL . "' AND `ru`.`User`<>'" . $sId . "',`ru`.`User`,'') SEPARATOR ',') AS `In`, GROUP_CONCAT(DISTINCT IF(`ru`.`Status`='" . $this->ROOM_STATUS_NORMAL . "' AND `ru`.`User`<>'" . $sId . "',(" . $iCurrentTime . "-`ru`.`When`),'') SEPARATOR ',') AS `InTime` FROM `" . $this->ROOMS_DB_TABLE . "` AS `r` LEFT JOIN `" . $this->ROOMS_USERS_DB_TABLE . "` AS `ru` ON `r`.`ID`=`ru`.`Room` GROUP BY `r`.`ID` ORDER BY `r`.`ID` LIMIT " . max(2, (int)$this->_getSettingValue("maxRoomsNumber"));
				$rResult = $this->oDb->getResult($sSql);
				while($aRoom = $this->oDb->fetch($rResult))
					$sRooms .= $this->_parseXml($this->aXmlTemplates['room'], $aRoom['RoomID'], $aRoom['OwnerID'], empty($aRoom['Password']) ? $this->FALSE_VAL : $this->TRUE_VAL, stripslashes($aRoom['Name']), stripslashes($aRoom['Desc']), $aRoom['In'], $aRoom['InTime']);
				break;
		}
		return $sRooms;
	}

	function _doRoom($sSwitch, $sUserId = "", $iRoomId = 0, $sTitle = "", $sPassword = "", $sDesc = "", $bTemp = false)
	{
		$iCurrentTime = time();
		switch ($sSwitch) {
			case 'insert':
				$aCurRoom = $this->oDb->getArray("SELECT * FROM `" . $this->ROOMS_DB_TABLE . "` WHERE `Name`='" . $sTitle . "'");
				$sStatus = $bTemp ? $this->ROOM_STATUS_DELETE : $this->ROOM_STATUS_NORMAL;
				if(!empty($aCurRoom['ID']) && $sUserId == $aCurRoom['OwnerID']) {
					$this->oDb->getResult("UPDATE `" . $this->ROOMS_DB_TABLE . "` SET `Name`='" . $sTitle . "', `Password`='" . $sPassword . "', `Desc`='" . $sDesc . "', `OwnerID`='" . $sUserId . "', `When`='" . $iCurrentTime . "', `Status`='" . $sStatus . "' WHERE `ID`='" . $aCurRoom['ID'] . "'");
					return $aCurRoom['ID'];
				} else if(empty($aCurRoom['ID'])) {
					$this->oDb->getResult("INSERT INTO `" . $this->ROOMS_DB_TABLE . "` (`ID`, `Name`, `Password`, `Desc`, `OwnerID`, `When`, `Status`) VALUES ('" . $iRoomId . "', '" . $sTitle . "', '" . $sPassword . "', '" . $sDesc . "', '" . $sUserId . "', '" . $iCurrentTime . "', '" . $sStatus . "')");
					return $this->oDb->getLastInsertId();
				} else return 0;
				break;

			case 'update':
				$this->oDb->getResult("UPDATE `" . $this->ROOMS_DB_TABLE . "` SET `Name`='" . $sTitle . "', `Password`='" . $sPassword . "', `Desc`='" . $sDesc . "', `When`='" . $iCurrentTime . "', `Status`='" . $this->ROOM_STATUS_NORMAL . "' WHERE `ID`='" . $iRoomId . "'");
				break;

			case 'delete':
				$this->oDb->getResult("UPDATE `" . $this->ROOMS_DB_TABLE . "` SET `When`='" . $iCurrentTime . "', `Status`='" . $this->ROOM_STATUS_DELETE . "' WHERE `ID` = '" . $iRoomId . "'");
				break;

			case 'enter':
				$sId = $this->oDb->getValue("SELECT `ID` FROM `" . $this->ROOMS_USERS_DB_TABLE . "` WHERE `Room`='" . $iRoomId . "' AND `User`='" . $sUserId . "' LIMIT 1");
				if(empty($sId))
					$this->oDb->getResult("INSERT INTO `" . $this->ROOMS_USERS_DB_TABLE . "`(`Room`, `User`, `When`) VALUES('" . $iRoomId . "', '" . $sUserId . "', '" . $iCurrentTime . "')");
				else 
					$this->oDb->getResult("UPDATE `" . $this->ROOMS_USERS_DB_TABLE . "` SET `When`='" . $iCurrentTime . "', `Status`='" . $this->ROOM_STATUS_NORMAL . "' WHERE `ID`='" . $sId . "'");
				break;

			case 'exit':
				$this->oDb->getResult("UPDATE `" . $this->ROOMS_USERS_DB_TABLE . "` SET `When`='" . $iCurrentTime . "', `Status`='" . $this->ROOM_STATUS_DELETE . "' WHERE `Room`='" . $iRoomId . "' AND `User`='" . $sUserId . "' LIMIT 1");
				break;

			case 'deleteTemp':
				$this->oDb->getResult("DELETE FROM `" . $this->ROOMS_DB_TABLE . "` WHERE `Status`='" . $this->ROOM_STATUS_DELETE . "' AND `When`<" . ($iCurrentTime - 24*60*60));
				break;
		}
	}
	
	function _getLastUpdate($sId)
	{
		return (int)$this->oDb->getValue("SELECT `When` FROM `" . $this->USERS_DB_TABLE . "` WHERE `ID`='" . $sId . "' LIMIT 1");
	}

	function _refreshUsersInfo($sId = "", $sMode = 'all', $iLastUpdate = 0)
	{
		$iUpdateInterval = (int)$this->_getSettingValue("updateInterval");
		$iIdleTime = 300;
		$iDeleteTime = 500;
		$sContent = "";

		$iCurrentTime = time();
		if(!$iLastUpdate)
			$iLastUpdate = $iCurrentTime;
			
		$iUsersNotUpdated = (int)$this->oDb->getValue("SELECT COUNT(`ID`) FROM `" . $this->USERS_DB_TABLE . "` WHERE `Status` NOT IN('" . $this->USER_STATUS_KICK . "', '" . $this->USER_STATUS_IDLE . "') AND `When`<" . $iLastUpdate);
		$sSet = $iUsersNotUpdated > 0 ? "" : "`Status`='" . $this->USER_STATUS_OLD . "', ";
		
		$this->oDb->getResult("UPDATE `" . $this->USERS_DB_TABLE . "` SET " . $sSet . "`When`='" . $iCurrentTime . "' WHERE `ID`='" . $sId . "' AND `Status`<>'" . $this->USER_STATUS_KICK . "' AND (`Status` NOT IN('" . $this->USER_STATUS_NEW . "', '" . $this->USER_STATUS_TYPE . "', '" . $this->USER_STATUS_ONLINE . "') || (" . $iCurrentTime . "-`When`)>" . $iUpdateInterval . ") LIMIT 1");

		$this->oDb->getResult("UPDATE `" . $this->USERS_DB_TABLE . "` SET `When`=" . $iCurrentTime . ", `Status`='" . $this->USER_STATUS_IDLE . "' WHERE `Status`<>'" . $this->USER_STATUS_IDLE . "' AND `When`<=(" . ($iCurrentTime - $iIdleTime) . ")");
		$this->oDb->getResult("DELETE FROM `" . $this->ROOMS_USERS_DB_TABLE . "` WHERE `Status`='" . $this->ROOM_STATUS_DELETE . "' AND `When`<=(" . ($iCurrentTime - $iDeleteTime) . ")");
		$rFiles = $this->oDb->getResult("SELECT `files`.`ID` AS `FileID` FROM `" . $this->MESSAGES_DB_TABLE . "` AS `files` INNER JOIN `" . $this->USERS_DB_TABLE . "` AS `users` WHERE `files`.`Recipient`=`users`.`ID` AND `files`.`Type`='file' AND `users`.`Status`='" . $this->USER_STATUS_IDLE . "' AND `users`.`When`<=" . ($iCurrentTime - $iDeleteTime));
		while($aFile = $this->oDb->fetch($rFiles))
			$this->_removeFile($aFile['FileID']);
		$this->oDb->getResult("DELETE FROM `" . $this->USERS_DB_TABLE . "`, `" . $this->ROOMS_USERS_DB_TABLE . "` USING `" . $this->USERS_DB_TABLE . "`, `" . $this->ROOMS_USERS_DB_TABLE . "` WHERE `" . $this->USERS_DB_TABLE . "`.`ID`=`" . $this->ROOMS_USERS_DB_TABLE . "`.`User` AND `" . $this->USERS_DB_TABLE . "`.`Status`='" . $this->USER_STATUS_IDLE . "' AND `" . $this->USERS_DB_TABLE . "`.`When`<=" . ($iCurrentTime - $iDeleteTime));
		//--- delete old rooms ---//
		$this->oDb->getResult("DELETE FROM `" . $this->ROOMS_DB_TABLE . "`, `" . $this->ROOMS_USERS_DB_TABLE . "` USING `" . $this->ROOMS_DB_TABLE . "`,`" . $this->ROOMS_USERS_DB_TABLE . "` WHERE `" . $this->ROOMS_DB_TABLE . "`.`ID`=`" . $this->ROOMS_USERS_DB_TABLE . "`.`Room` AND `" . $this->ROOMS_DB_TABLE . "`.`Status`='" . $this->ROOM_STATUS_DELETE . "' AND `" . $this->ROOMS_DB_TABLE . "`.`When`<=(" . ($iCurrentTime - $iDeleteTime) . ")");
		//--- delete old messages ---//
		$this->oDb->getResult("DELETE FROM `" . $this->MESSAGES_DB_TABLE . "` WHERE `Type`='text' AND `When`<=(" . ($iCurrentTime - $iDeleteTime) . ")");
		//--- Get information about users in the chat ---//
		switch($sMode) {
			case 'update':
				$rRes = $this->oDb->getResult("SELECT ccu.`ID` AS `ID`, ccu.`Nick` AS `Nick`, ccu.`Sex` AS `Sex`, ccu.`Age` AS `Age`, ccu.`Desc` AS `Desc`, ccu.`Photo` AS `Photo`, ccu.`Profile` AS `Profile`, ccu.`Status` AS `Status`, ccu.`Online` AS `Online`, rp.`Type` AS `Type` FROM `" . $this->PROFILES_DB_TABLE . "` AS rp, `" . $this->USERS_DB_TABLE . "` AS ccu WHERE rp.`ID`=ccu.`ID` ORDER BY ccu.`When`");
				while($aUser = $this->oDb->fetch($rRes)) {
					if($aUser['ID'] == $sId && !($aUser['Status'] == $this->USER_STATUS_KICK || $aUser['Status'] == $this->USER_STATUS_TYPE))
						continue;
					switch($aUser['Status']) {
						case $this->USER_STATUS_NEW:
							$sContent .= $this->_parseXml($this->aXmlTemplates['user'], $aUser['ID'], $aUser['Status'], $aUser['Nick'], $aUser['Sex'], $aUser['Age'], stripslashes($aUser['Desc']), $aUser['Photo'], $aUser['Profile'], $aUser['Type'], $aUser['Online']);
							break;
						case $this->USER_STATUS_TYPE:
							$sContent .= $this->_parseXml($this->aXmlTemplates['user'], $aUser['ID'], $aUser['Status'], $aUser['Type']);
							break;
						case $this->USER_STATUS_ONLINE:
							$sContent .= $this->_parseXml($this->aXmlTemplates['user'], $aUser['ID'], $aUser['Status'], $aUser['Type'], $aUser['Online']);
							break;
						case $this->USER_STATUS_IDLE:
						case $this->USER_STATUS_KICK:
							$sContent .= $this->_parseXml($this->aXmlTemplates['user'], $aUser['ID'], $aUser['Status']);
							break;
					}
				}
				break;

			case 'all':
				$iRunTime = floor($this->_getRequestVar("_t", "int") / 1000);
				$iCurrentTime -= $iRunTime;
				$rRes = $this->oDb->getResult("SELECT ccu.`ID` AS `ID`, ccu.`Nick` AS `Nick`, ccu.`Sex` AS `Sex`, ccu.`Age` AS `Age`, ccu.`Desc` AS `Desc`, ccu.`Photo` AS `Photo`, ccu.`Profile` AS `Profile`, ccu.`Online` AS `Online`, rp.`Type` AS `Type`, (" . $iCurrentTime . "-`ccu`.`Start`) AS `Time` FROM `" . $this->PROFILES_DB_TABLE . "` AS rp, `" . $this->USERS_DB_TABLE . "` AS ccu WHERE rp.`ID`=ccu.`ID` AND ccu.`Status` NOT IN ('" . $this->USER_STATUS_IDLE . "', '" . $this->USER_STATUS_KICK . "') AND rp.`Banned`='" . $this->FALSE_VAL . "' ORDER BY ccu.`When`");
				while($aUser = $this->oDb->fetch($rRes))
					$sContent .= $this->_parseXml($this->aXmlTemplates['user'], $aUser['ID'], $this->USER_STATUS_NEW, $aUser['Nick'], $aUser['Sex'], $aUser['Age'], stripslashes($aUser['Desc']), $aUser['Photo'], $aUser['Profile'], $aUser['Type'], $aUser['Online'], $aUser['Time']);
				break;
		}
		return $this->_makeGroup($sContent, "users");
	}

	function _removeFile($sFileId)
	{
		$this->oDb->getResult("DELETE FROM `" . $this->MESSAGES_DB_TABLE . "` WHERE `ID`='" . $sFileId . "'");
		@unlink($this->sPath . "files/" . $sFileId . ".file");
	}
}
