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

$english = array(
	"phloor_body_background" => "Background Image",
	'admin:appearance:phloor_body_background' => 'Background image',

	'phloor_body_background:title' => "Upload background image",

	'phloor_body_background:description' => "Upload a custom background image for your site. Allowed mimetypes are 'image/gif', 'image/jpg', 'image/jpeg', 'image/pjpeg' and 'image/png'. ",

	'phloor_body_background:save:success' => 'Settings successfully saved.',
	'phloor_body_background:save:failure' => 'Settings could not be saved.',

	'phloor_body_background:form:section:background_image' => 'Background image',

	'phloor_body_background:image:label' => 'Upload the background image',
	'phloor_body_background:image:description' => 'Select the file you would like to set as background image. ',

	'phloor_body_background:delete_image:label' => 'Remove current background image',
	'phloor_body_background:delete_image:description' => 'If you tick this box the image will be removed. ',


	'phloor_body_background:admin:appearance:entity_count' => 'Count: %s',
	'phloor_body_background:title:all_phloor_body_backgrounds' => 'All backgrounds',
	'phloor_body_background:title:user_phloor_body_backgrounds' => '%s\'s backgrounds',
	'phloor_body_background:phloor_body_backgrounds' => 'Body backgrounds',

	'phloor_body_background:menu:set_site_background'   => 'Add to main background',
	'phloor_body_background:menu:unset_site_background' => 'Remove from main background',

	'phloor_body_background:add'  => 'Add background image',
	'phloor_body_background:edit' => 'Edit background image',
	'phloor_body_background:none' => 'No background images yet.',

	'phloor_body_background:background_image:limit_reached' => 'You have reached the maximum number of background images. ',

	'phloor_body_background:breadcrumb:all' => 'Body background',
	'phloor_body_background:usersettings:menu:linktext' => 'Profile background',
	'phloor_body_background:profile_background:edit' => 'Edit profile background',

	'phloor_body_background:background' => 'Background',
	'phloor_body_background:preview' => 'Preview',


	'phloor_body_background:enable_user_profile_background' => 'Enable User Profile Backgrounds? ',
	'phloor_body_background:enable_user_profile_background:description' => 'Users can upload background images for their profile.',

	'phloor_body_background:repeat:label'           => "Repeat",
	'phloor_body_background:repeat:description'     => "The background-repeat property sets if/how a background image will be repeated. By default, a background-image is repeated both vertically and horizontally. ",
	'phloor_body_background:position:label'         => "Position",
	'phloor_body_background:position:description'   => "The background-position property sets the starting position of a background image. ",
	'phloor_body_background:attachment:label'       => "Attachment",
	'phloor_body_background:attachment:description' => "The background-attachment property sets whether a background image is fixed or scrolls with the rest of the page. ",
	'phloor_body_background:color:label'            => "Color",
	'phloor_body_background:color:description'      => "The background-color property sets the background color of the body.",

);

add_translation("en", $english);
