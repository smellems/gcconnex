<?php
/*****************************************************************************
 * Phloor Body Background                                                    *
 *                                                                           *
 * Copyright (C) 2012 Alois Leitner                                          *
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

gatekeeper();

// check if upload failed
if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] != 0) {
	register_error(elgg_echo('phloor_body_background:error:cannotloadimage'));
	forward(REFERER);
}

// store errors to pass along
$error = FALSE;
$error_forward_url = REFERER;
$user = elgg_get_logged_in_user_entity();

$delete_files = array();

$new_background_image = false;

$background_image = null;
$guid = get_input('guid');

if ($guid) {
    $background_image = get_entity($guid);

	if (!phloor_body_background_instanceof($background_image) || !$background_image->canEdit()) {
		register_error(elgg_echo('phloor_body_background:error:background_image_not_found'));
		forward(get_input('forward', REFERER));
		exit();
	}

	// determine files to delete (old images and thumbnails)
	if (isset ($_FILES['image']['name']) &&
		!empty($_FILES['image']['name']) &&
		$_FILES['image']['error'] == 0 ) {
		$delete_files = array_merge(array('image' => $background_image->getImage()), $background_image->getThumbnails());
	}

} else {
    $background_image = new PhloorBackgroundImage();
    $background_image->owner_guid = $user->guid;
    // set new unique title
    $background_image->title      = elgg_echo("phloor_body_background:background") . " " . uniqid("#");

    $new_background_image = true;
}

$params = phloor_body_background_get_input_vars();

if (phloor_body_background_save_vars($background_image, $params)) {
    // delete former image if new image was uploaded
	if (isset ($_FILES['image']['name']) &&
		!empty($_FILES['image']['name']) &&
		$_FILES['image']['error'] == 0 ) {
		foreach($delete_files as $file) {
			if(!empty($file) && file_exists($file) && is_file($file)) {
				// delete file
				if(@unlink($file)) {
				}
			}
		}

		// recreate thumbnails
		$background_image->recreateThumbnails();
	}

	system_message(elgg_echo('phloor_body_background:save:success'));
	forward($background_image->getURL());
}
// ... or display an error message on failure
else {
	register_error(elgg_echo('phloor_body_background:save:failure'));
	forward($error_forward_url);
}

// back o da bus
forward($_SERVER['HTTP_REFERER']);
exit();

