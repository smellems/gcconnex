<?php
// get the form inputs

gatekeeper();
$user_guid = elgg_get_logged_in_user_guid();
$url = get_input('url');
$objetive = get_input('objetive');
$access_id = get_input('access_id');
$guid = get_input('guid');
$group_guid = get_input('group_guid');

$container_guid = get_input('container_guid', $user_guid);

elgg_make_sticky_form('etherpad');

if ( !$url || !$objetive ) {
        register_error(elgg_echo('etherpad:save:failed'));
        forward(REFERER);
}

if ($guid == 0) {
	// create a new etherpad object
	$pad = new ElggObject();
	$pad->subtype = "etherpad";
	$pad->url = $url;
	$pad->objetive = $objetive;
	$pad->container_guid = (int)get_input('container_guid', $user_guid);
	$pad->group_guid = $group_guid;
	$new = true;
} else {
        $pad = get_entity($guid);
        if (!$pad->canEdit()) {
        	system_message(elgg_echo('etherpad:save:failed'));
                forward(REFERRER);
        }
	$new = false;
}
// for now make all etherpad posts public
$pad->access_id = $access_id;
$pad->objetive = $objetive;

// owner is logged in user
$pad->owner_guid = $user_guid;

// save to database and get id of the new etherpad
$pad_guid = $pad->save();

// if the etherpad was saved, we want to display the new post
// otherwise, we want to register an error and forward back to the form
if ($pad_guid) {
   elgg_clear_sticky_form('etherpad');
   system_message(elgg_echo('etherpad:save:success'));
   //add to river only if new

   if ($new) {
       elgg_create_river_item(array(
		'view' => 'river/object/etherpad/create',
		'action_type' => 'create', 
		'subject_guid' => $user_guid,
		'object_guid' => $pad->getGUID(),
       ));
   }

   forward($pad->getURL());
} else {
   register_error( elgg_echo('etherpad:register:no:saved'));
   forward(REFERER); // REFERER is a global variable that defines the previous page
}
