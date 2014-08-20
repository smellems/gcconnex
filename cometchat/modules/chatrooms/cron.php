<?php
include_once (dirname(__FILE__).DIRECTORY_SEPARATOR."config.php");

$sql = ("delete from cometchat_chatrooms where createdby <> 0 and ('".getTimeStamp()."'-lastactivity)> ".$chatroomTimeout * 100);
$query = mysql_query($sql);
if (defined('DEV_MODE') && DEV_MODE == '1') { echo mysql_error(); }
$sql = ("delete from cometchat_chatroommessages where ('".getTimeStamp()."'-sent)>10800");
$query = mysql_query($sql);
if (defined('DEV_MODE') && DEV_MODE == '1') { echo mysql_error(); }
$sql = ("delete from cometchat_chatrooms_users where ('".getTimeStamp()."'-lastactivity)>3600");
$query = mysql_query($sql);
if (defined('DEV_MODE') && DEV_MODE == '1') { echo mysql_error(); }