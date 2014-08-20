<?php

if (!defined('CCADMIN')) { echo "NO DICE"; exit; }

if (empty($_GET['process'])) {
	global $getstylesheet;
	require dirname(__FILE__).DIRECTORY_SEPARATOR.'config.php';

echo <<<EOD
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

$getstylesheet
<form action="?module=dashboard&action=loadexternal&type=module&name=twitter&process=true" method="post">
<div id="content">
		<h2>Settings</h2>
		<h3>If you are unsure about any value, please skip them</h3>
		<div>
			<div id="centernav" style="width:380px">
				<div class="title">Twitter Username:</div><div class="element"><input type="text" class="inputbox" name="twitteruser" value="$twitteruser"></div>
				<div style="clear:both;padding:5px;"></div>

				<div class="title">Number of Tweets:</div><div class="element"><input type="text" class="inputbox" name="notweets" value="$notweets"></div>
				<div style="clear:both;padding:5px;"></div>

				<div class="title">Consumer key:</div><div class="element"><input type="text" class="inputbox" name="consumerkey" value="$consumerkey"></div>
				<div style="clear:both;padding:5px;"></div>

				<div class="title">Consumer Secret:</div><div class="element"><input type="text" class="inputbox" name="consumersecret" value="$consumersecret"></div>
				<div style="clear:both;padding:5px;"></div>

				<div class="title">Access token:</div><div class="element"><input type="text" class="inputbox" name="accesstoken" value="$accesstoken"></div>
				<div style="clear:both;padding:5px;"></div>

				<div class="title">Access token secret:</div><div class="element"><input type="text" class="inputbox" name="accesstokensecret" value="$accesstokensecret"></div>
				<div style="clear:both;padding:5px;"></div>

			</div>
		</div>

		<div style="clear:both;padding:7.5px;"></div>
		<input type="submit" value="Update Settings" class="button">&nbsp;&nbsp;or <a href="javascript:window.close();">cancel or close</a>
</div>
</form>
EOD;
} else {
	$data = '';
	foreach ($_POST as $field => $value) {
		$data .= '$'.$field.' = \''.$value.'\';'."\r\n";
	}
	configeditor('SETTINGS',$data,0,dirname(__FILE__).DIRECTORY_SEPARATOR.'config.php');	
	header("Location:?module=dashboard&action=loadexternal&type=module&name=twitter");
}