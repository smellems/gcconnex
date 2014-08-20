<?php

/*

CometChat
Copyright (c) 2012 Inscripts

CometChat ('the Software') is a copyrighted work of authorship. Inscripts 
retains ownership of the Software and any copies of it, regardless of the 
form in which the copies may exist. This license is not a sale of the 
original Software or any copies.

By installing and using CometChat on your server, you agree to the following
terms and conditions. Such agreement is either on your own behalf or on behalf
of any corporate entity which employs you or which you represent
('Corporate Licensee'). In this Agreement, 'you' includes both the reader
and any Corporate Licensee and 'Inscripts' means Inscripts (I) Private Limited:

CometChat license grants you the right to run one instance (a single installation)
of the Software on one web server and one web site for each license purchased.
Each license may power one instance of the Software on one domain. For each 
installed instance of the Software, a separate license is required. 
The Software is licensed only to you. You may not rent, lease, sublicense, sell,
assign, pledge, transfer or otherwise dispose of the Software in any form, on
a temporary or permanent basis, without the prior written consent of Inscripts. 

The license is effective until terminated. You may terminate it
at any time by uninstalling the Software and destroying any copies in any form. 

The Software source code may be altered (at your risk) 

All Software copyright notices within the scripts must remain unchanged (and visible). 

The Software may not be used for anything that would represent or is associated
with an Intellectual Property violation, including, but not limited to, 
engaging in any activity that infringes or misappropriates the intellectual property
rights of others, including copyrights, trademarks, service marks, trade secrets, 
software piracy, and patents held by individuals, corporations, or other entities. 

If any of the terms of this Agreement are violated, Inscripts reserves the right 
to revoke the Software license at any time. 

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.

*/

include dirname(dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR."modules.php";
include dirname(__FILE__).DIRECTORY_SEPARATOR."config.php";
include dirname(__FILE__).DIRECTORY_SEPARATOR."lang".DIRECTORY_SEPARATOR."en.php";

if (file_exists(dirname(__FILE__).DIRECTORY_SEPARATOR."lang".DIRECTORY_SEPARATOR.$lang.".php")) {
	include dirname(__FILE__).DIRECTORY_SEPARATOR."lang".DIRECTORY_SEPARATOR.$lang.".php";
}

$embed = '';
$embedcss = '';
$close = "setTimeout('window.close()',2000);";
$response = array();
if (!empty($_GET['embed']) && $_GET['embed'] == 'web') { 
	$embed = 'web';
	$embedcss = 'embed';
	$close = "parent.closeCCPopup('invite');";
}

if (!empty($_GET['embed']) && $_GET['embed'] == 'desktop') { 
	$embed = 'desktop';
	$embedcss = 'embed';
	$close = "parentSandboxBridge.closeCCPopup('invite');";
}

if ($userid == 0 || in_array($userid,$bannedUserIDs)) {
	$response['logout'] = 1;
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($response);
	exit;	
}

function sendmessage() {
	global $userid;
	global $db;
	global $cookiePrefix;
	
	if (isset($_POST['message']) && isset($_POST['currentroom'])) {
		$to = $_POST['currentroom'];
		$message = $_POST['message'];

		$sql = ("update cometchat_chatrooms set lastactivity = '".getTimeStamp()."' where id = '".mysql_real_escape_string($to)."'");
		$query = mysql_query($sql);
		
		$styleStart = '';
		$styleEnd = '';

		if (!empty($_COOKIE[$cookiePrefix.'chatroomcolor']) && preg_match('/^[a-f0-9]{6}$/i', $_COOKIE[$cookiePrefix.'chatroomcolor'])) {
			$styleStart = '<span style="color:#'.$_COOKIE[$cookiePrefix.'chatroomcolor'].'">';
			$styleEnd = '</span>';
		}

		$message = str_ireplace('CC^CONTROL_','',$message); 
		
		if (USE_COMET == 1 && COMET_CHATROOMS == 1) {
			$comet = new Comet(KEY_A,KEY_B);
			if (empty($_SESSION['cometchat']['username'])) {
				$name = '';
				$sql = getUserDetails($userid);
				if($userid>10000000) $sql = getGuestDetails($userid);
				$result = mysql_query($sql);
				
				if($row = mysql_fetch_array($result)) {				
					if (function_exists('processName')) {
						$row['username'] = processName($row['username']);
					}
					$name = $row['username'];
				}

				$_SESSION['cometchat']['username'] = $name;
			} else {
				$name = $_SESSION['cometchat']['username'];
			}

			$insertedid = getTimeStamp().rand(100,999);

			if (!empty($name)) {
				$info = $comet->publish(array(
					'channel' => md5('chatroom_'.$to.KEY_A.KEY_B.KEY_C),
					'message' => array ( "from" => $name, "message" => $styleStart.sanitize($message).$styleEnd, "sent" => $insertedid)
				));

				if (defined('SAVE_LOGS') && SAVE_LOGS == 1) {
					$sql = ("insert into cometchat_chatroommessages (userid,chatroomid,message,sent) values ('".mysql_real_escape_string($userid)."', '".mysql_real_escape_string($to)."','".$styleStart.mysql_real_escape_string(sanitize($message)).$styleEnd."','".getTimeStamp()."')");
					$query = mysql_query($sql);				
				}
			}

		} else {
			$sql = ("insert into cometchat_chatroommessages (userid,chatroomid,message,sent) values ('".mysql_real_escape_string($userid)."', '".mysql_real_escape_string($to)."','".$styleStart.mysql_real_escape_string(sanitize($message)).$styleEnd."','".getTimeStamp()."')");
			$query = mysql_query($sql);
			$insertedid = mysql_insert_id();
		}
		echo $insertedid;
		exit();
	}
}

function heartbeat() {
	global $response;
	$messages = array();
	global $userid;
	global $db;
	global $chatrooms_language;
	global $chatroomTimeout;
	global $lastMessages;
	global $cookiePrefix;
	global $allowAvatar;
	global $moderatorUserIDs;
	global $guestsMode, $crguestsMode, $guestnamePrefix;

	$usertable = TABLE_PREFIX.DB_USERTABLE;
	$usertable_username = DB_USERTABLE_NAME;
	$usertable_userid = DB_USERTABLE_USERID;

	$time = getTimeStamp();
	$chatroomList = array();

	if (isset($_POST['popout']) && $_POST['popout'] == 0) {
		$_SESSION['cometchat']['cometchat_chatroomspopout'] = $time;
	}
	
	if (!empty($_POST['currentroom']) && $_POST['currentroom'] != 0) {
			$sql = ("insert into cometchat_chatrooms_users (userid,chatroomid,lastactivity,isbanned) values ('".mysql_real_escape_string($userid)."','".mysql_real_escape_string($_POST['currentroom'])."','".mysql_real_escape_string($time)."','0') on duplicate key update chatroomid = '".mysql_real_escape_string($_POST['currentroom'])."', lastactivity = '".mysql_real_escape_string($time)."'");
			$query = mysql_query($sql);
		}

	if ((empty($_SESSION['cometchat']['cometchat_chatroomslist'])) || (!empty($_POST['force'])) || (!empty($_SESSION['cometchat']['cometchat_chatroomslist']) && ($time-$_SESSION['cometchat']['cometchat_chatroomslist'] > REFRESH_BUDDYLIST))) {
		
		$sql = ("select DISTINCT cometchat_chatrooms.id, cometchat_chatrooms.name, cometchat_chatrooms.type, cometchat_chatrooms.password, cometchat_chatrooms.lastactivity, cometchat_chatrooms.createdby, (SELECT count(userid) online FROM cometchat_chatrooms_users where cometchat_chatrooms_users.chatroomid = cometchat_chatrooms.id and '$time'-lastactivity<".ONLINE_TIMEOUT." and isbanned<>'1') online from cometchat_chatrooms where (type <> 2 or type = 2 and createdby = '".mysql_real_escape_string($userid)."' )and (createdby = 0 OR (createdby <> 0 ))and (createdby = 0 OR (createdby <> 0 AND ('".mysql_real_escape_string($time)."'-lastactivity < $chatroomTimeout or createdby='".$userid."'))) order by name asc");
 		
		$query = mysql_query($sql);
 
		while ($chatroom = mysql_fetch_array($query)) {
			$s = 0;
			if ($chatroom['createdby'] != $userid) {
				if(!(in_array($userid,$moderatorUserIDs))){
						$chatroom['password'] = '';
				} else {
					$s = 2;
				}	
			} else {
				$s = 1;
			}

			$chatroomList[] = array('id' => $chatroom['id'], 'name' => $chatroom['name'], 'online' => $chatroom['online'], 'type' => $chatroom['type'], 'i' => $chatroom['password'], 's' => $s);
		}

		$_SESSION['cometchat']['cometchat_chatroomslist'] = $time;

		$ch = md5(serialize($chatroomList));

		if ((empty($_POST['clh'])) || (!empty($_POST['clh']) && $ch != $_POST['clh'])) {
			if (!empty($chatroomList)) {
				$response['chatrooms'] = $chatroomList;
			}
			$response['clh'] = $ch;
		}

	}

	if (!empty($_POST['currentroom']) && $_POST['currentroom'] != 0) {
		
		$sql = ("select DISTINCT ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." userid, ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_NAME." username, ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_LASTACTIVITY." lastactivity, ".DB_AVATARFIELD." avatar, cometchat_chatrooms_users.isbanned from ".TABLE_PREFIX.DB_USERTABLE." left join cometchat_status on ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." = cometchat_status.userid inner join cometchat_chatrooms_users on  ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." =  cometchat_chatrooms_users.userid ". DB_AVATARTABLE ." where chatroomid = '".mysql_real_escape_string($_POST['currentroom'])."' and ('".mysql_real_escape_string($time)."' - cometchat_chatrooms_users.lastactivity < ".ONLINE_TIMEOUT.") order by username asc");
		if($guestsMode && $crguestsMode){
			$sql = getChatroomGuests($_POST['currentroom'],$time,$sql);
		}		
		$query = mysql_query($sql);

		$users = array();

		while ($chat = mysql_fetch_array($query)) {

			if (function_exists('processName')) {
				$chat['username'] = processName($chat['username']);
			}
			$avatar = '';
			if($allowAvatar){
				$avatar = getAvatar($chat['avatar']);
			}
			if($chat['userid'] == $userid){
				$chat['userid'] = 0;
			}
			$users[] = array('id' => $chat['userid'], 'n' => $chat['username'], 'a' => $avatar, 'b' => $chat['isbanned']);
		}

		$uh = md5(serialize($users));

		if ((empty($_POST['ulh'])) || (!empty($_POST['ulh']) && $uh != $_POST['ulh'])) {
			$response['ulh'] = $uh;
			if (!empty($users)) {
				$response['users'] = $users;
			}
		}

		if (USE_COMET != 1 || COMET_CHATROOMS != 1) {
			$guestpart = "";
			if($guestsMode && $crguestsMode){
				$guestpart = " UNION select cometchat_guests.id $usertable_userid, concat('".$guestnamePrefix." ',cometchat_guests.name) $usertable_username from cometchat_guests ";
			}
			$reverse = 1;
			$sql = ("select DISTINCT cometchat_chatroommessages.id, cometchat_chatroommessages.message, cometchat_chatroommessages.sent, m.$usertable_username `from`, cometchat_chatroommessages.userid fromid, m.$usertable_userid userid from cometchat_chatroommessages, (select $usertable.$usertable_userid, $usertable.$usertable_username from $usertable ".$guestpart.") m where cometchat_chatroommessages.chatroomid = '".mysql_real_escape_string($_POST['currentroom'])."' and m.$usertable_userid = cometchat_chatroommessages.userid and cometchat_chatroommessages.message not like 'banned_%' and cometchat_chatroommessages.message not like 'kicked_%' order by cometchat_chatroommessages.id desc limit $lastMessages");

			if ($_POST['timestamp'] != 0) {
				$sql = ("select DISTINCT cometchat_chatroommessages.id, cometchat_chatroommessages.message, cometchat_chatroommessages.sent, m.$usertable_username `from`, cometchat_chatroommessages.userid fromid, m.$usertable_userid userid from cometchat_chatroommessages, (select $usertable.$usertable_userid, $usertable.$usertable_username from $usertable ".$guestpart.") m where cometchat_chatroommessages.chatroomid = '".mysql_real_escape_string($_POST['currentroom'])."' and m.$usertable_userid = cometchat_chatroommessages.userid and cometchat_chatroommessages.id > '".mysql_real_escape_string($_POST['timestamp'])."' order by cometchat_chatroommessages.id desc");
				$reverse = 0;
			}
			$query = mysql_query($sql);

			while ($chat = mysql_fetch_array($query)) {
				if (function_exists('processName')) {
					$chat['from'] = processName($chat['from']);
				}

				if ($userid == $chat['userid']) {
					$chat['from'] = $chatrooms_language[6];
					
				} else {
					
					if (!empty($_COOKIE[$cookiePrefix.'lang']) && !(strpos($chat['message'],"CC^CONTROL_")>-1)) {
						
						$translated = text_translate($chat['message'],'',$_COOKIE[$cookiePrefix.'lang']);
						
						if ($translated != '') {
							$chat['message'] = strip_tags($translated).' <span class="untranslatedtext">('.$chat['message'].')</span>';
						}
					} 
				}
				
				array_unshift($messages,array('id' => $chat['id'], 'from' => $chat['from'],'fromid' => $chat['fromid'], 'message' => $chat['message'],'sent' => ($chat['sent']+$_SESSION['cometchat']['timedifference'])));
			}

		} else {
			if ($_POST['timestamp'] == 0) {
				$comet = new Comet(KEY_A,KEY_B);
				$history = $comet->history(array(
				  'channel' => md5('chatroom_'.$_POST['currentroom'].KEY_A.KEY_B.KEY_C),
				  'limit'   => $lastMessages+5
				));

				$moremessages = array();
                $count_msg = 0;
				$i = 0;
				if (!empty($history)) {

					foreach ($history as $message) {
						if(strpos($message['message'],'CC^CONTROL_')>-1)
						 continue;
						$moremessages[] = array("id" => $message['sent'], "from" => $message['from'], "fromid" => "0", "message" => $message['message'], "old" => 1, 'sent' => (($message['sent']/1000)+$_SESSION['cometchat']['timedifference']));
						$count_msg++;
					}

					$messages = array_merge($messages,$moremessages);
					if($count_msg>$lastMessages){
						$extra_msg = $count_msg-$lastMessages;
                        while($i<$extra_msg){
                          unset($messages[$i]);
                          $i++;
						}
					}
					usort($messages, 'comparetime');
				}
			}
		}

		if (isset($messages)) {
			$response['messages'] = $messages;
		}

		$sql = ("select password from cometchat_chatrooms where id = '".mysql_real_escape_string($_POST['currentroom'])."' limit 1");

		$query = mysql_query($sql);
		$room = mysql_fetch_array($query);

		if (!empty($room['password']) && (empty($_POST['currentp']) || ($room['password'] != $_POST['currentp']))) {
			$response['users'] = array();
			$response['messages'] = array();
		}
	}
	
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($response);
	exit;
}

function createchatroom() {

	global $userid;
	$name = $_POST['name'];
	$password = $_POST['password'];
	$type = $_POST['type'];

	$sql = ("select name from cometchat_chatrooms where name = '".$name."'");
	$query = mysql_query($sql);
	if(mysql_num_rows($query) == 0) {
		if ($userid != '') {
			$time = getTimeStamp();
			if (!empty($password)) {
				$password = sha1($password);
			} else {
				$password = '';
			}

			$sql = ("insert into cometchat_chatrooms (name,createdby,lastactivity,password,type) values ('".mysql_real_escape_string(sanitize_core($name))."', '".mysql_real_escape_string($userid)."','".getTimeStamp()."','".mysql_real_escape_string(sanitize_core($password))."','".mysql_real_escape_string(sanitize_core($type))."')");
			$query = mysql_query($sql);
			$currentroom = mysql_insert_id();

			$sql = ("insert into cometchat_chatrooms_users (userid,chatroomid,lastactivity) values ('".mysql_real_escape_string($userid)."','".mysql_real_escape_string($currentroom)."','".mysql_real_escape_string($time)."') on duplicate key update chatroomid = '".mysql_real_escape_string($currentroom)."', lastactivity = '".mysql_real_escape_string($time)."'");
			$query = mysql_query($sql);
			
			echo $currentroom;
			exit(0);
		}
	} else {
		echo "0";
		exit;
	}
}

function checkpassword() {

	global $userid;
	global $moderatorUserIDs;
	$isModerator = 0;
	if(in_array($userid,$moderatorUserIDs)) {
		$isModerator = 1;
	}
	$id = $_POST['id'];
	if(!empty($_POST['password'])) {
		$password = $_POST['password'];
	}
	$sql = ("select * from cometchat_chatrooms_users where userid ='".mysql_real_escape_string($userid)."' and chatroomid = '".mysql_real_escape_string($id)."' and isbanned = '1'");
	$query = mysql_query($sql);
	if(mysql_num_rows($query) == 1){
		echo 2;
		exit;
	}
	if ($userid != '') {
		$sql = ("select * from cometchat_chatrooms where id = '".mysql_real_escape_string($_POST['id'])."' limit 1");
		$query = mysql_query($sql);
		$room = mysql_fetch_array($query);
		if (!empty($room['password']) && (empty($_POST['password']) || ($room['password'] != $_POST['password']))) {
			echo "0";
		} else {
			echo md5('chatroom_'.$id.KEY_A.KEY_B.KEY_C)."^".($room['createdby'] == $userid?"1":"0")."^".$userid."^".$isModerator;
		}
	}
}

function invite() {
	global $userid;
	global $chatrooms_language;
	global $language;
	global $embed;
	global $embedcss;
		
	$status['available'] = $language[30];
	$status['busy'] = $language[31];
	$status['offline'] = $language[32];
	$status['invisible'] = $language[33];
	$status['away'] = $language[34];

	$id = $_GET['roomid'];
	$inviteid = $_GET['inviteid'];
	$roomname = $_GET['roomname'];

	$time = getTimeStamp();
	$buddyList = array();

	$sql = ("select GROUP_CONCAT(userid) bannedusers from cometchat_chatrooms_users where isbanned=1 and chatroomid='".$id."'");
	$query = mysql_query($sql);

	if (defined('DEV_MODE') && DEV_MODE == '1') { echo mysql_error(); }

	$result = mysql_fetch_array($query);
	$bannedUsers = explode(',',$result['bannedusers']);

	$sql = getFriendsList($userid,$time);
	$query = mysql_query($sql);

	if (defined('DEV_MODE') && DEV_MODE == '1') { echo mysql_error(); }

	while ($chat = mysql_fetch_array($query)) {

		if ((($time-processTime($chat['lastactivity'])) < ONLINE_TIMEOUT) && $chat['status'] != 'invisible' && $chat['status'] != 'offline') {
			if ($chat['status'] != 'busy' && $chat['status'] != 'away') {
				$chat['status'] = 'available';
			}
		} else {
			$chat['status'] = 'offline';
		}
	
		$avatar = getAvatar($chat['avatar']);

		if (!empty($chat['username'])) {
			if (function_exists('processName')) {
				$chat['username'] = processName($chat['username']);
			}

			if (!(in_array($chat['userid'],$bannedUsers))) {
				$buddyList[] = array('id' => $chat['userid'], 'n' => $chat['username'], 's' => $chat['status'], 'a' => $avatar);
			}
		}
	}

	if (function_exists('hooks_forcefriends') && is_array(hooks_forcefriends())) {
		$buddyList = array_merge(hooks_forcefriends(),$buddyList);
	}

	$number = 0;

	$s['available'] = '';
	$s['away'] = '';
	$s['busy'] = '';
	$s['offline'] = '';

	foreach ($buddyList as $buddy) {

		++$number;

		$s[$buddy['s']] .= '<div class="invite_1"><div class="invite_2" onclick="javascript:document.getElementById(\'check_'.$buddy['id'].'\').checked = document.getElementById(\'check_'.$buddy['id'].'\').checked?false:true;"><img height=30 width=30 src="'.$buddy['a'].'"></div><div class="invite_3" onclick="javascript:document.getElementById(\'check_'.$buddy['id'].'\').checked = document.getElementById(\'check_'.$buddy['id'].'\').checked?false:true;"><span class="invite_name">'.$buddy['n'].'</span><br/><span class="invite_5">'.$status[$buddy['s']].'</span></div><input type="checkbox" name="invite[]" value="'.$buddy['id'].'" id="check_'.$buddy['id'].'" class="invite_4"></div>';
		if ($number%2 == 0) {
			echo '<div style="clear:both"></div>';
			$number = 0;
		}
	}

	echo <<<EOD
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>{$chatrooms_language[22]}</title> 
<meta http-equiv="content-type" content="text/html; charset=utf-8"/> 
<link type="text/css" rel="stylesheet" media="all" href="../../css.php?type=module&name=chatrooms" /> 
</head>
<body>
<form method="post" action="chatrooms.php?action=inviteusers&embed={$embed}">
<div class="container">
	<div class="container_title {$embedcss}">{$chatrooms_language[21]}</div>
	<div class="container_body {$embedcss}">
		{$s['available']}{$s['away']}{$s['offline']}
		<div style="clear:both"></div>
	</div>
	<div class="container_sub {$embedcss}">
		<input type=submit value="{$chatrooms_language[20]}" class="invitebutton">
	</div>
</div>	
<input type="hidden" name="roomid" value="$id">
<input type="hidden" name="inviteid" value="$inviteid">
<input type="hidden" name="roomname" value="$roomname"></form>
</body>
</html>
EOD;

}

function inviteusers() {
	global $chatrooms_language;
	global $close;
	global $embed;
	global $embedcss;
	
	if(!empty($_POST['invite'])){
		foreach ($_POST['invite'] as $user) {
			sendMessageTo($user,"{$chatrooms_language[18]}<a href=\"javascript:jqcc.cometchat.joinChatroom('{$_POST['roomid']}','{$_POST['inviteid']}','{$_POST['roomname']}')\">{$chatrooms_language[19]}</a>");
		}
	}

	echo <<<EOD
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>{$chatrooms_language[18]}</title> 
<meta http-equiv="content-type" content="text/html; charset=utf-8"/> 
<link type="text/css" rel="stylesheet" media="all" href="../../css.php?type=module&name=chatrooms" /> 
</head>
<body onload="{$close}">
<div class="container">
	<div class="container_title {$embedcss}">{$chatrooms_language[21]}</div>
	<div class="container_body {$embedcss}">
		{$chatrooms_language[16]}</span>
		<div style="clear:both"></div>
	</div>
</div>	
</body>
</html>
EOD;

}

function unban() {
	global $userid;
	global $chatrooms_language;
	global $language;
	global $embed;
	global $embedcss;
		
	$status['available'] = $language[30];
	$status['busy'] = $language[31];
	$status['offline'] = $language[32];
	$status['invisible'] = $language[33];
	$status['away'] = $language[34];

	$id = $_GET['roomid'];
	$inviteid = $_GET['inviteid'];
	$roomname = $_GET['roomname'];

	$time = getTimeStamp();
	$buddyList = array();
	$sql = ("select DISTINCT ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." userid, ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_NAME." username, ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_LASTACTIVITY." lastactivity, ".DB_AVATARFIELD." avatar, ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_NAME." link,  cometchat_status.message, cometchat_status.status from ".TABLE_PREFIX.DB_USERTABLE." left join cometchat_status on ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." = cometchat_status.userid right join cometchat_chatrooms_users on ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." =cometchat_chatrooms_users.userid ".DB_AVATARTABLE." where ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." <> '".mysql_real_escape_string($userid)."' and cometchat_chatrooms_users.chatroomid = '".mysql_real_escape_string($id)."' and cometchat_chatrooms_users.isbanned ='1' order by username asc");
	$query = mysql_query($sql);

	if (defined('DEV_MODE') && DEV_MODE == '1') { echo mysql_error(); }

	while ($chat = mysql_fetch_array($query)) {

		if ((($time-processTime($chat['lastactivity'])) < ONLINE_TIMEOUT) && $chat['status'] != 'invisible' && $chat['status'] != 'offline') {
			if ($chat['status'] != 'busy' && $chat['status'] != 'away') {
				$chat['status'] = 'available';
			}
		}	else {
				$chat['status'] = 'offline';
			}
	
		$avatar = getAvatar($chat['avatar']);

		if (!empty($chat['username'])) {
			if (function_exists('processName')) {
				$chat['username'] = processName($chat['username']);
			}

			$buddyList[] = array('id' => $chat['userid'], 'n' => $chat['username'], 's' => $chat['status'], 'a' => $avatar);
		}
	}

	if (function_exists('hooks_forcefriends') && is_array(hooks_forcefriends())) {
		$buddyList = array_merge(hooks_forcefriends(),$buddyList);
	}

	$number = 0;

	$s['available'] = '';
	$s['away'] = '';
	$s['busy'] = '';
	$s['offline'] = '';

	foreach ($buddyList as $buddy) {
		++$number;

		$s[$buddy['s']] .= '<div class="invite_1"><div class="invite_2" onclick="javascript:document.getElementById(\'check_'.$buddy['id'].'\').checked = document.getElementById(\'check_'.$buddy['id'].'\').checked?false:true;"><img height=30 width=30 src="'.$buddy['a'].'"></div><div class="invite_3" onclick="javascript:document.getElementById(\'check_'.$buddy['id'].'\').checked = document.getElementById(\'check_'.$buddy['id'].'\').checked?false:true;"><span class="invite_name">'.$buddy['n'].'</span><br/><span class="invite_5">'.$status[$buddy['s']].'</span></div><input type="checkbox" name="unban[]" value="'.$buddy['id'].'" id="check_'.$buddy['id'].'" class="invite_4"></div>';
		if ($number%2 == 0) {
			echo '<div style="clear:both"></div>';
			$number = 0;
		}
	}

	if($s['available'] == '' && $s['busy'] == '' && $s['away'] == '' && $s['offline'] == ''){
		$s['available'] = $chatrooms_language[44];
	}
	echo <<<EOD
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>{$chatrooms_language[21]}</title> 
<meta http-equiv="content-type" content="text/html; charset=utf-8"/> 
<link type="text/css" rel="stylesheet" media="all" href="../../css.php?type=module&name=chatrooms" /> 
</head>
<body>
<form method="post" action="chatrooms.php?action=unbanusers&embed={$embed}">
<div class="container">
	<div class="container_title {$embedcss}">{$chatrooms_language[21]}</div>
	<div class="container_body {$embedcss}">
		{$s['available']}{$s['busy']}{$s['away']}{$s['offline']}
		<div style="clear:both"></div>
	</div>
	<div class="container_sub {$embedcss}">
		<input type=submit value="Unban Users" class="invitebutton">
	</div>
</div>	
<input type="hidden" name="roomid" value="$id">
<input type="hidden" name="inviteid" value="$inviteid">
<input type="hidden" name="roomname" value="$roomname"></form>
</body>
</html>
EOD;

}

function unbanusers() {

	global $chatrooms_language;
	global $close;
	global $embed;
	global $embedcss;

	if(!empty($_POST['unban'])){
		foreach ($_POST['unban'] as $user) {
			$sql = ("delete from cometchat_chatrooms_users where userid = '".mysql_real_escape_string($user)."' and chatroomid = '".mysql_real_escape_string($_POST['roomid'])."'");		
			$query = mysql_query($sql);

			sendMessageTo($user,"{$chatrooms_language[18]}<a href=\"javascript:jqcc.cometchat.joinChatroom('{$_POST['roomid']}','{$_POST['inviteid']}','{$_POST['roomname']}')\">{$chatrooms_language[19]}</a>");
		}
	}

	echo <<<EOD
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>{$chatrooms_language[18]}</title> 
<meta http-equiv="content-type" content="text/html; charset=utf-8"/> 
<link type="text/css" rel="stylesheet" media="all" href="../../css.php?type=module&name=chatrooms" /> 
</head>
<body onload="{$close}">
<div class="container">
	<div class="container_title {$embedcss}">{$chatrooms_language[21]}</div>
	<div class="container_body {$embedcss}">
		{$chatrooms_language[16]}</span>
		<div style="clear:both"></div>
	</div>
</div>	
</body>
</html>
EOD;

}

function loadChatroomPro() {

	global $chatrooms_language;
	global $language;
	global $embed;
	global $embedcss;
	global $userid;
	global $moderatorUserIDs;
	global $lightboxWindows;

	$close = 'setTimeout("window.close()",2000);';
	if (!empty($_GET['embed']) && $_GET['embed'] == 'web') {
		$embed = 'web';
		$embedcss = 'embed';
		$close = 'parent.closeCCPopup("loadChatroomPro");';
	}

	$id = $_GET['roomid'];
	$uid = $_GET['inviteid'];
	$roomname = $_GET['roomname'];
	$owner = $_GET['owner'];
	$apiAccess = $_GET['apiAccess'];
	$options = "";
	$caller = "window.opener.";

	if($apiAccess) {
		$options=" <input type=button class='invitebutton' onclick=javascript:window.opener.parent.jqcc.cometchat.chatWith($uid);$close value='".$chatrooms_language[43]."'>";

		if($lightboxWindows) {
			$options=" <input type=button class='invitebutton' onclick=javascript:parent.jqcc.cometchat.chatWith($uid);$close value='".$chatrooms_language[43]."'>";
			$caller="$('#cometchat_trayicon_chatrooms_iframe,.cometchat_embed_chatrooms',parent.document)[0].contentWindow.";
		}
	}

	if($owner == 1 || in_array($userid,$moderatorUserIDs)) {

		$sql = ("select createdby from cometchat_chatrooms where id = '".mysql_real_escape_string($id)."' limit 1");
		$query = mysql_query($sql);
		$room = mysql_fetch_array($query);

		if(!in_array($uid,$moderatorUserIDs) && $uid != $room['createdby']) {
			$options = "<input type=button value='".$chatrooms_language[40]."' onClick=javascript:".$caller."kickUser($uid,0);$close class='invitebutton'>
			<input type=button value='".$chatrooms_language[41]."' onClick=javascript:".$caller."banUser($uid,0);$close class='invitebutton'>".$options;
		}
	}

	if (defined('DEV_MODE') && DEV_MODE == '1') { echo mysql_error(); }

	$sql = getUserDetails($uid);

	if($uid>10000000) {
		$sql = getGuestDetails($uid);
	}

	$res = mysql_query($sql);
	$result = mysql_fetch_array($res);
	$link = getLink($result['link']);
	$avatar = getAvatar($result['avatar']);

	if($link != '' && $uid < 10000000) {
		$options .= " <input type=button class='invitebutton' onClick=javascript:window.open('".$link."');".$close." value='".$chatrooms_language[42]."' >";
	}

echo <<<EOD
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>{$result['username']}</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<link type="text/css" rel="stylesheet" media="all" href="../../css.php?type=module&name=chatrooms" />
</head>
<body >
<form method="post">
<div class="container">
<div class="container_title {$embedcss}">{$result['username']}</div>	
<div class="chatroom_avatar"><img src="$avatar" height="50px" width="50px" /></div>
<div class="control_buttons">{$options}</div>	
</div>
</body>
</html>
EOD;
}


function leavechatroom() {
	global $userid;
	if($_POST['flag'] == 0){
		$sql = ("delete from cometchat_chatrooms_users where userid = '".mysql_real_escape_string($userid)."' and chatroomid = '".mysql_real_escape_string($_POST['currentroom'])."'");
		$query = mysql_query($sql);
	} else {
		$sql = ("update cometchat_chatrooms_users set isbanned = '1' where userid = '".mysql_real_escape_string($userid)."' and chatroomid = '".mysql_real_escape_string($_POST['currentroom'])."'");
		$query = mysql_query($sql);
	}

	unset($_SESSION['cometchat']['cometchat_chatroomslist']);

	echo "1";
	exit();
}

function kickUser() {
	$kickid = $_REQUEST['kickid'];
	$id = $_REQUEST['currentroom'];

	if($_REQUEST['kick']<>'0') {
		$sql = ("delete from cometchat_chatroommessages where id='".mysql_real_escape_string($_REQUEST['kick'])."'");
		$query = mysql_query($sql);		
		exit;
	}	
	sendChatroomMessage($id,'CC^CONTROL_kicked_'.$kickid);	
	echo 1;
	exit();
}

function banUser() {
	$banid = $_REQUEST['banid'];
	$id = $_REQUEST['currentroom'];

	if($_REQUEST['ban']<>'0'){
		$sql = ("delete from cometchat_chatroommessages where id='".mysql_real_escape_string($_REQUEST['ban'])."'");
		$query = mysql_query($sql);
		exit;
	}	
	sendChatroomMessage($id,'CC^CONTROL_banned_'.$banid);
	$sql = ("update cometchat_chatrooms_users set isbanned=1 where userid = '".mysql_real_escape_string($banid)."' and chatroomid = '".mysql_real_escape_string($id)."'");
	$query = mysql_query($sql);	
	echo 1;
	exit();
}

$allowedActions = array('sendmessage','heartbeat','createchatroom','checkpassword','invite','inviteusers','unban','unbanusers','loadChatroomPro','leavechatroom','kickUser','banUser');

if (!empty($_GET['action']) && function_exists($_GET['action']) && in_array($_GET['action'],$allowedActions)) {
	call_user_func($_GET['action']);
}