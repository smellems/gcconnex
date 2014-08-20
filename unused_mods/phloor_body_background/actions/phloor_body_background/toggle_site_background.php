<?php
/*****************************************************************************
 * Phloor Plugin                                                            *
 *                                                                           *
 * Copyright (C) 2011 Alois Leitner                                          *
 *                                                                           *
 * This program is free software: you can redistribute it and/or modify      *
 * it under the terms of the GNU General Public License as published by      *
 * the Free Software Foundation, either version 2 of the License, or         *
 * (at your option) any later version.                                       *
 *                                                                           *
 * This program is distributed in the hope that it will be useful,           *
 * but WITHOUT ANY WARRANTY; without even the implied warranty of            *
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             *
 * GNU General Public License for more details.                              *
 *                                                                           *
 * You should have received a copy of the GNU General Public License         *
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.     *
 *                                                                           *
 * "When code and comments disagree both are probably wrong." (Norm Schryer) *
 *****************************************************************************/
?>
<?php

action_gatekeeper();
admin_gatekeeper();

$background_guid = get_input('guid', 0, true);
$background      = get_entity($background_guid);

if(!phloor_body_background_instanceof($background) || !$background->canEdit()) {
	return false;
}

$site = elgg_get_site_entity();

$message = "";
if($background->container_guid != $site->guid) {
    $background->container_guid = $site->guid;

    $message = elgg_echo("phloor_body_background:set_site_background:successful");
} else {
    $background->container_guid = $background->owner_guid;

    $message = elgg_echo("phloor_body_background:unset_site_background:successful");
}

if(!$background->save()) {
	register_error(elgg_echo("phloor_body_background:toggle_site_background:error"));
	forward(REFERER);
	exit();
}

system_message($message);

forward(REFERER);