<?php
/**
* Ssend a message action
* 
* @package ElggMessages
*/

$subject = strip_tags(get_input('subject'));
$body = get_input('body');

$recipient = get_input('to_recipients');

if (!$recipient)
{
	$recipient_guid = get_input('recipient_guid');
	//$recipient_user = get_user($recipient_guid);
	//$recipient = $recipient_user->email;
}

if (!$recipient) {
	$gc_member = get_user($recipient_guid);
	$recipient = $gc_member->email;
}



elgg_make_sticky_form('messages');

// $reply = get_input('reply',0); // this is the guid of the message replying to
// elgg_echo('cyu - reply:'.$reply, 'NOTICE');
// if ($reply > 0)
// {
// 	$recipient_guid = get_user($reply);
// 	$recipient = $recipient_guid->email;
// }

elgg_echo('cyu - recipient_guid:'.$recipient_guid, 'NOTICE');
elgg_echo('cyu - recipient:'.$recipient, 'NOTICE');

if (!$recipient) {
	register_error(elgg_echo("messages:user:blank"));
	forward("messages/compose");
}

$recipient_list = explode(';', $recipient);
foreach ($recipient_list as $user_email)
{
	$query = "SELECT guid FROM elggusers_entity WHERE email='".$user_email."'";
	$user = get_data_row($query);
	
	if (!$user) {
		register_error(elgg_echo("messages:user:nonexist"));
		forward("messages/compose");
	}

	// Make sure the message field, send to field and title are not blank
	if (!$body || !$subject) {
		register_error(elgg_echo("messages:blank"));
		forward("messages/compose");
	}

	// Otherwise, 'send' the message 
	$result = messages_send($subject, $body, $user->guid, 0, $reply);

	// Save 'send' the message
	if (!$result) {
		register_error(elgg_echo("messages:error"));
		forward("messages/compose");
	}
}

elgg_clear_sticky_form('messages');
system_message(elgg_echo("messages:posted"));
forward('messages/inbox/' . elgg_get_logged_in_user_entity()->username);
