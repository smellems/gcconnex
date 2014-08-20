<?php

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* ADVANCED */

define('SET_SESSION_NAME','');			// Session name
define('DO_NOT_START_SESSION','0');		// Set to 1 if you have already started the session
define('DO_NOT_DESTROY_SESSION','0');	// Set to 1 if you do not want to destroy session on logout
define('SWITCH_ENABLED','1');		
define('INCLUDE_JQUERY','1');	
define('FORCE_MAGIC_QUOTES','0');

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* DATABASE */

include(dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR."engine".DIRECTORY_SEPARATOR."settings.php";

define('DB_SERVER',					$CONFIG->dbhost					);
define('DB_PORT',					"3306"							);
define('DB_USERNAME',				$CONFIG->dbuser					);
define('DB_PASSWORD',				$CONFIG->dbpass					);
define('DB_NAME',					$CONFIG->dbname					);
define('TABLE_PREFIX',				$CONFIG->dbprefix				);
define('DB_USERTABLE',				"users_entity"					);
define('DB_USERTABLE_USERID',		"guid"							);
define('DB_USERTABLE_NAME',			"username"						);
define('DB_AVATARTABLE',		    "left join ".TABLE_PREFIX."entities on ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." = ".TABLE_PREFIX."entities.".DB_USERTABLE_USERID."");
define('DB_AVATARFIELD',		    "concat(".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID.",'^',".TABLE_PREFIX."entities.time_created)");
define('DB_USERTABLE_LASTACTIVITY',	"last_action"					);

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* FUNCTIONS */

 function getUserID() {

	$userid = 0;
	if (!empty($_SESSION['basedata']) && $_SESSION['basedata'] != 'null') {
		$_REQUEST['basedata'] = $_SESSION['basedata'];
	}

	if (!empty($_REQUEST['basedata']) && isset($_REQUEST['callbackfn']) && in_array($_REQUEST['callbackfn'],array('desktop','mobileapp'))) {
		if (function_exists('mcrypt_encrypt')) {
			$key = KEY_A.KEY_B.KEY_C;
			$uid = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($_REQUEST['basedata']), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
			if (intval($uid) > 0) {
				$userid = $uid;
			}
		} else {
			$userid = $_REQUEST['basedata'];
		}
	}

	if (!empty($_COOKIE['Elgg'])) {
		$sql = ("SELECT `data` FROM `".TABLE_PREFIX."users_sessions` WHERE `session` = '".mysql_real_escape_string($_COOKIE['Elgg'])."'");
		$result = mysql_query($sql);
		if($row = mysql_fetch_array($result)){
			$data = explode('attributes";',$row[0]);
			if(!empty($data)){
				$session = unserialize($data[1]);
				$userid = $session['guid'];
			}
		}
	}
	return $userid;
}

function chatLogin($username,$password){
	$userid = 0;
	include_once(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR."engine".DIRECTORY_SEPARATOR."start.php");
	$result = authenticate($userName, $userPass);
	$result1 = mysql_query("SELECT * FROM ".TABLE_PREFIX.DB_USERTABLE." WHERE `username`='".$userName."'") or die(mysql_error());		
	$row = mysql_fetch_array($result1);
	if($result != false){
		$user = get_user_by_username($userName);
		try {
			login($user, FALSE);
		} catch (LoginException $e) {}	
		$userid = $row['guid'];
	}
	if($userid && function_exists('mcrypt_encrypt')){
		$key = KEY_A.KEY_B.KEY_C;
		$userid = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $userid, MCRYPT_MODE_CBC, md5(md5($key))));
	}
	return $userid;
}

function getFriendsList($userid,$time) {
	if (defined('DISPLAY_ALL_USERS') && DISPLAY_ALL_USERS == 1)	{
		 $sql = ("select DISTINCT ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." userid, ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_NAME." username, ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_LASTACTIVITY." lastactivity, ".DB_AVATARFIELD." avatar, ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_NAME." link, cometchat_status.message, cometchat_status.status from ".TABLE_PREFIX.DB_USERTABLE." left join cometchat_status on ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." = cometchat_status.userid ".DB_AVATARTABLE." where ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." <> '".mysql_real_escape_string($userid)."' and ('".mysql_real_escape_string($time)."'-".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_LASTACTIVITY." < '".((ONLINE_TIMEOUT)*2)."') and (cometchat_status.status IS NULL OR cometchat_status.status <> 'invisible' OR cometchat_status.status <> 'offline') order by username asc");		 
	} else {
		$sql = "select DISTINCT ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." userid, ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_NAME." username, ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_LASTACTIVITY." lastactivity, ".DB_AVATARFIELD." avatar, ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_NAME." link, cometchat_status.message, cometchat_status.status from (SELECT guid_one, guid_two  FROM ".TABLE_PREFIX."entity_relationships WHERE relationship = 'friend' UNION SELECT guid_two, guid_one FROM ".TABLE_PREFIX."entity_relationships WHERE relationship = 'friend') friends join ".TABLE_PREFIX.DB_USERTABLE." on  friends.guid_two = ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." left join cometchat_status on ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." = cometchat_status.userid ".DB_AVATARTABLE." where friends.guid_one = '".mysql_real_escape_string($userid)."' order by username asc";
	}
	return $sql;
}

function getUserDetails($userid) {
	$sql = ("select ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." userid, ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_NAME." username, ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_LASTACTIVITY." lastactivity,  ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_NAME." link, ".DB_AVATARFIELD." avatar, cometchat_status.message, cometchat_status.status from ".TABLE_PREFIX.DB_USERTABLE." left join cometchat_status on ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." = cometchat_status.userid ".DB_AVATARTABLE." where ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." = '".mysql_real_escape_string($userid)."'");
	return $sql;
}

function updateLastActivity($userid) {
	$sql = ("update `".TABLE_PREFIX.DB_USERTABLE."` set ".DB_USERTABLE_LASTACTIVITY." = '".getTimeStamp()."' where ".DB_USERTABLE_USERID." = '".mysql_real_escape_string($userid)."'");
	return $sql;
}

function getUserStatus($userid) {
	 $sql = ("select cometchat_status.message, cometchat_status.status from cometchat_status where userid = '".mysql_real_escape_string($userid)."'");
	 return $sql;
}

function getLink($link) {
	$url = BASE_URL."../pg/profile/".$link;
    return $url;
}

function getAvatar($image) {
	$img= explode ('^',$image);
	$str = BASE_URL."../mod/profile/icondirect.php?guid=".$img[0]."&joindate=".$img[1]."&size=small";
	return $str;
}


function getTimeStamp() {
	return time();
}

function processTime($time) {
	return $time;
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* HOOKS */

function hooks_statusupdate($userid,$statusmessage) {
	
}

function hooks_forcefriends() {
	
}

function hooks_activityupdate($userid,$status) {

}

function hooks_message($userid,$unsanitizedmessage) {
	
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* LICENSE */

include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'license.php');
$x="\x62a\x73\x656\x34\x5fd\x65c\157\144\x65";
eval($x('JHI9ZXhwbG9kZSgnLScsJGxpY2Vuc2VrZXkpOyRwXz0wO2lmKCFlbXB0eSgkclsyXSkpJHBfPWludHZhbChwcmVnX3JlcGxhY2UoIi9bXjAtOV0vIiwnJywkclsyXSkpOw'));

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 