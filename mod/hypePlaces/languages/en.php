<?php

namespace hypeJunction\Places;

$english = array(
	/**
	 * Core
	 */
	'item:object:hjplace' => 'Places',
	'tag_names:specialties' => 'Specialties',
	/**
	 * Pages
	 */
	'places' => 'Places',
	'places:all' => 'All Places',
	'places:featured' => 'Featured Places',
	'places:owner' => '%s\'s Places',
	'places:mine' => 'My Places',
	'places:bookmarked:owner' => '%s\'s Stars',
	'places:bookmarked:mine' => 'My Stars',
	'places:group' => 'Group places',
	'places:search' => 'Find places',
	'places:list:empty' => 'There are no places to display',
	'places:filter:featured' => 'Featured',
	'places:filter:all' => 'All Places',
	'places:filter:mine' => 'My Places',
	'places:filter:owner' => '%s\'s Places',
	'places:filter:bookmarked' => 'My Stars',
	'places:feature' => 'Feature',
	'places:unfeature' => 'Unfeature',
	'places:featured' => 'Featured',
	'places:checkin' => 'Check-In',
	'places:checkout' => 'Check-Out',
	'places:bookmark' => 'Star',
	'places:unbookmark' => 'Unstar',
	/**
	 * EDIT FORM
	 */
	'places:required' => 'Required field',
	'places:create' => 'Add place',
	'places:edit' => 'Edit place: %s',
	'places:place:about' => 'About',
	'places:place:title' => 'Title',
	'places:place:address' => 'Address',
	'places:place:description' => 'Description',
	'places:place:tags' => 'Tags',
	'places:place:access_id' => 'Access',
	'places:place:category' => 'Category',
	'places:place:icon' => 'Icon',
	'places:place:markertype' => 'Map Marker',
	'places:place:contact' => 'Contact Details',
	'places:place:phone' => 'Phone',
	'places:place:website' => 'Website',
	'places:place:twitter' => 'Twitter',
	'places:place:tools' => 'Tools',
	'places:place:tools:checkins' => 'Enable checkins',
	/**
	 * POSTAL ADDRESS FORM
	 */
	'places:postal_address:street_address' => 'Street address',
	'places:postal_address:extended_address' => 'Street address 2',
	'places:postal_address:locality' => 'City',
	'places:postal_address:postal_code' => 'Postal code',
	'places:postal_address:region' => 'State',
	'places:postal_address:country' => 'Country',
	/**
	 * ACTIONS
	 */
	'places:error:permissions' => 'You do not have sufficient permissions to perform this action',
	'places:error:not_found' => 'Place could not be found or accessed',
	'places:edit:error:required_field_empty' => 'One or more required fields are missing',
	'places:edit:success' => 'Place %s has been successfully saved',
	'places:edit:error' => 'An unknown error has occurred when saving a place',
	'places:delete:success' => '%s has been deleted',
	'places:delete:error' => '%s could not be deleted',
	'places:feature:success' => '%s has been featured',
	'places:unfeature:success' => '%s has been featured',
	'places:bookmark:create:success' => 'Place has been starred successfully',
	'places:bookmark:create:error' => 'Place could not be starred',
	'places:bookmark:remove:success' => 'Place has been unstarred successfully',
	'places:bookmark:remove:error' => 'Place could not be unstarred',
	'places:checkin:success' => 'You were checked in at %s',
	'places:checkin:error' => 'Checkin at %s failed',
	'places:checkout:success' => 'You were checked out from %s. Note that you do not have to checkout unless you want to remove the traces. Checkins expire automatically',
	'places:checkout:error' => 'Checkin at %s failed',
	/**
	 * WIDGETS
	 */
	'places:widgets:about' => 'About',
	'places:widgets:about:desc' => 'Widget containing information about the place',
	'places:widgets:activity' => 'Activity',
	'places:widgets:activity:desc' => 'Latest activity',

	/**
	 * SETTINGS
	 */
	'places:settings:params[checkin_duration]' => 'Check-in Duration',
	'places:settings:hint:checkin_duration' => 'How long in minutes should the user be considered as checked in?',
	'places:groupoption:enable' => 'Enable group places',
	/**
	 * RIVER
	 */
	'river:create:object:hjplace' => '%s added a new place %s',
	'river:stream:places:bookmark:object:default' => '%s starred %s',
	'river:stream:places:checkin:object:default' => '%s checked in at %s',
);

add_translation('en', $english);
