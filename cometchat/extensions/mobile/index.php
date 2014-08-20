<?php 
/*

CometChat
Copyright (c) 2013 Inscripts

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

include dirname(__FILE__).DIRECTORY_SEPARATOR."lang".DIRECTORY_SEPARATOR."en.php";
if (file_exists(dirname(__FILE__).DIRECTORY_SEPARATOR."lang".DIRECTORY_SEPARATOR.$lang.".php")) {
	include dirname(__FILE__).DIRECTORY_SEPARATOR."lang".DIRECTORY_SEPARATOR.$lang.".php";
}

include_once dirname(dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR."modules".DIRECTORY_SEPARATOR."chatrooms".DIRECTORY_SEPARATOR."lang".DIRECTORY_SEPARATOR."en.php";
if (file_exists (dirname(dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR."modules".DIRECTORY_SEPARATOR."chatrooms".DIRECTORY_SEPARATOR."lang".DIRECTORY_SEPARATOR.$lang.".php")) {
	include_once dirname(dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR."modules".DIRECTORY_SEPARATOR."chatrooms".DIRECTORY_SEPARATOR."lang".DIRECTORY_SEPARATOR.$lang.".php";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta name="viewport" content="user-scalable=0,width=device-width, minimum-scale=1.0, maximum-scale=1.0, initial-scale=1.0" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $mobile_language[0];?></title>
<link type="text/css" href="<?php echo BASE_URL; ?>css.php?type=extension&name=mobile" rel="stylesheet" charset="utf-8">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo BASE_URL; ?>js.php?type=extension&name=mobile&callbackfn=mobilewebapp"></script>
<script>

    $("#buddy").live('pageshow', function() {
		document.title = "<?php echo $mobile_language[20]?>";
	});  
	
	$("#lobby").live('pageshow', function() {
		document.title = "<?php echo $mobile_language[21]?>";
	});
	
	$("#createChatroom").live('pageshow', function() {
		document.title = "<?php echo $mobile_language[22]?>";
	});
</script>
</head>
<body style="background:#f1f1f1;">
	<div data-role="page" id="buddy" style="background:inherit;">
		<div class="pageHeader" data-role="header" data-position="fixed">
			<h1><?php echo $mobile_language[18];?></h1>
		</div>
		<div data-role="content" id="wocontent">
			<div id="woscroll">
				<ul id="wolist" data-role="listview" data-filter="true" data-filter-placeholder="<?php echo $mobile_language[15];?>">
				</ul>
				<div id="endoftext"></div>
			</div>
		</div>
		<div data-role="footer" data-position="fixed" id="buddyFooter">
			<div data-role="navbar" class="nav-glyphish-example">
				<ul>
					<li>
						<a data-transition="none" data-icon="custom" id="buddy_link" class="chatlink" href="#buddy"><?php echo $mobile_language[20];?></a>
					</li>
					<li>
						<a data-transition="none" data-icon="custom" class="chatroomlink" href="#lobby"><?php echo $mobile_language[21];?></a>
					</li>
				</ul>
			</div>
		</div>
	</div>
	
	
	<div data-role="page" id="chat" style="background:inherit;">
		<div id="chatheader" class="pageHeader" data-role="header" data-position="fixed">
			<a data-role="button" data-icon="back" data-iconpos="notext" onclick="javascript:loadChatboxReverse()"><?php echo $mobile_language[24]?></a>
			<h1></h1>
		</div>
		<div id="chatcontent" class="ui-content" style="">
			<div id="scroller">
			</div>
			<div id="endoftext"></div>
		</div>
		<div id="chatfooter" class="ui-footer ui-bar-d ui-footer-fixed slideup">
			<form id="chatmessageForm" onsubmit="#" data-ajax="false">
				<input id="chatmessage" type="text" name="chatmessage" placeholder="<?php echo $mobile_language[9];?>"/>
			</form>
		</div>
	</div>
	
	
	<div data-role="page" id="lobby" style="background:inherit;">
		<div class="pageHeader" data-role="header" data-position="fixed">
			<h1><?php echo $mobile_language[19];?></h1>
			<a href="javascript:void(0);" data-role="button" data-icon="plus" data-iconpos="notext" class="ui-btn-right" onclick="javascript:createChatroom()"></a>
		</div>
		<div data-role="content" id ="lobbycontent">
			<div id="lobbyscroller">
				<ul id="lobbylist" data-role="listview" data-filter="true" data-filter-placeholder="<?php echo $mobile_language[16];?>">
				</ul>
			</div>
		</div>
		<div data-role="footer" data-position="fixed" id="lobbyFooter">
			<div data-role="navbar" class="nav-glyphish-example">
				<ul>
					<li><a data-transition="none" data-direction="reverse" data-icon="custom" class="chatlink" href="#buddy"><?php echo $mobile_language[20];?></a></li>
					<li><a data-transition="none" data-icon="custom" id="lobby_link" class="chatroomlink" href="#lobby"><?php echo $mobile_language[21];?></a></li>
				</ul>
			</div>
		</div>
	</div>
	
	
	<div data-role="page" id="chatroom" style="background:inherit;">
		<div class="pageHeader" id="chatroomheader" data-role="header" data-position="fixed">
			<a data-role="button" data-icon="back" data-iconpos="notext" onclick="javascript:leaveChatroom();loadLobbyReverse();"><?php echo $mobile_language[24]?></a>
			<span id="chatroomName"></span>
			<a id="showUserButton" data-role="button" onclick="javascript:showChatroomUser();"><?php echo $mobile_language[23]?></a>
		</div>
		<div id="chatroomcontent" class="ui-content">
			<div id="crscroller">
			</div>
			<div id="endoftext"></div>
		</div>
		<div id="chatroomfooter" class="ui-footer ui-bar-d ui-footer-fixed slideup">
			<form id="chatroommessageForm" onsubmit="#" data-ajax="false">
				<input id="chatroommessage" type="text" name="chatmessage" placeholder="<?php echo $mobile_language[9];?>"/>
			</form>
		</div>
	</div>
	
	
	<div data-role="page" id="chatroomuser" style="background:inherit;">
		<div id="chatroomuserheader" class="pageHeader" data-role="header" data-position="fixed">
			<a data-role="button" data-icon="back" data-iconpos="notext" onclick="javascript:loadChatroomReverse();crscrollToBottom();"><?php echo $mobile_language[24]?></a>
			<span id="chatroomUserName" style="margin:0 auto;padding:0 10px;height:inherit;display:inline-block;"></span>
		</div>
		<div id="chatroomusercontent" data-role="content">
			<ul id="currentroom_users" data-role="listview">
			</ul>
		</div>
	</div>
	
	<div data-role="page" id="createChatroom" style="background:inherit;">
		<div class="pageHeader" data-role="header" data-position="fixed">
			<a data-role="button" data-icon="back" data-iconpos="notext" onclick="javascript:loadLobbyReverse()"><?php echo $mobile_language[24]?></a>
			<h1><?php echo $mobile_language[22];?></h1>
		</div>
		<div data-role="content" style="font-size:13px;">
			<form id="createChatroomForm"  onsubmit="return false" data-ajax="false">
				<div data-role="fieldcontain" style="padding-bottom:10px;">
					<label for="name"><?php echo $chatrooms_language[27];?></label>
					<input type="text" name="name" id="name" value="" />
				</div>
				<div data-role="fieldcontain" style="padding-bottom:10px;">
					<label for="type" class="select"><?php echo $chatrooms_language[28];?></label>
					<select name="type" id="type" data-mini="true" onchange="checkDropDown(this)">
					   <option value="0"><?php echo $chatrooms_language[29];?></option>
					   <option value="1"><?php echo $chatrooms_language[30];?></option>
					</select>
				</div>
				<div id="chatroomPassword" data-role="fieldcontain" style="padding-bottom:10px;">
					<label for="password"><?php echo $chatrooms_language[32];?></label>
					<input type="password" name="password" id="password" value="" />
				</div>
				<div id="createChatroomField" data-role="fieldcontain" style="padding-bottom:10px;">
					<button id="createChatroomButton" onclick="javascript:createChatroomSubmit()"><?php echo $chatrooms_language[33];?></button>
				</div>
			</form>
		</div>
	</div>
</body>
</html>