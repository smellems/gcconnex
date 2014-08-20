<?php
/*
 *	DELETE A REQUEST FROM USER (DELETE APPLICATION) 
 *
 */

$user_guid = get_input('user_guid', elgg_get_logged_in_user_guid());
$group_guid = get_input('group_guid');

$user = get_entity($user_guid);
$group = get_entity($group_guid);

// If join request made
if (check_entity_relationship($user->guid, 'membership_request', $group->guid)) 
{

	$sInfo = $user->username.';'.$user->guid.';'.$group->guid;

	$resultset = elgg_get_entities(array(
		'type' => 'object',
		'subtype' => 'c_group_reason'));


	if (count($resultset) > 0)
	{
		foreach($resultset as $result)
		{
			$info = explode(';', $result->title);
			$uId = $info[1];
			$gId = $info[2];

			if ($user->guid == $uId && $group->guid == $gId)
			{
				$result->delete();
			}
		}
	}

	remove_entity_relationship($user->guid, 'membership_request', $group->guid);
	system_message(elgg_echo("groups:joinrequestkilled"));
}

forward(REFERER);
