<?php
$user_id = elgg_get_logged_in_user_guid();
$facebook_id = elgg_get_plugin_user_setting('uid', $user_id, 'facebook_connect');
$site_name = elgg_get_site_entity()->name;
$access_token = elgg_get_plugin_user_setting('access_token', $fbuser_id, 'facebook_connect');

echo '<div>' . elgg_echo('facebook_connect:usersettings:description', array($site_name)) . '</div>';

if (!$facebook_id) {
	// send user off to validate account
	echo '<div>' .  elgg_echo('facebook_connect:usersettings:logout_required', array($site_name)) . '</div>';
} else {
	elgg_load_library('facebook');
	$facebook = facebookservice_api();
	try{
		$fbuser = $facebook->get('/me?fields=id,name,email',$access_token);
	} catch(Facebook\Exceptions\FacebookResponseException $e) {
  echo '1. Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  echo '1. Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}
	$fbuserlink = "https://www.facebook.com/".$facebook_id;
	$fbusername = json_decode(file_get_contents("http://graph.facebook.com/$facebook_id"))->name;
	if(isset($fbusername)) {
		echo '<p>' . sprintf(elgg_echo('facebook_connect:usersettings:authorized'), $fbusername, $fbuserlink) . '</p>';
	}

	$url = elgg_get_site_url() . "facebook_connect/revoke";
	echo '<div>' . sprintf(elgg_echo('facebook_connect:usersettings:revoke'), $url) . '</div>';
}