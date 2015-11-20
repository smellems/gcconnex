<?php
$user_id = elgg_get_logged_in_user_guid();
$facebook_id = elgg_get_plugin_user_setting('uid', $user_id, 'facebook_connect');
$site_name = elgg_get_site_entity()->name;
$access_token = elgg_get_plugin_user_setting('access_token', $fbuser_id, 'facebook_connect');

echo '<div>' . elgg_echo('facebook_connect:usersettings:description', array($site_name)) . '</div>';

if (!$facebook_id) {
	// send user off to validate account
	$request_link = elgg_get_site_url() . 'facebook_connect/addFacebook' ;
	echo '<div>' . elgg_echo('facebook_connect:usersettings:request', array($request_link, $site_name)) . '</div>';
} else {
	elgg_load_library('facebook');
	$facebook = facebookservice_api();
	try{
		$fbuser = $facebook->api('/me', 'GET', array('access_token' => $access_token)); 
	} catch (FacebookApiException $e) {
        echo $e . "<br><br>";
	}
	$fbuserlink = "https://www.facebook.com/".$facebook_id;
	$fbusername = json_decode(file_get_contents("http://graph.facebook.com/$facebook_id"))->name;
	if(isset($fbusername)) {
		echo '<p>' . sprintf(elgg_echo('facebook_connect:usersettings:authorized'), $fbusername, $fbuserlink) . '</p>';
	}

	$url = elgg_get_site_url() . "facebook_connect/revoke";
	echo '<div>' . sprintf(elgg_echo('facebook_connect:usersettings:revoke'), $url) . '</div>';
}