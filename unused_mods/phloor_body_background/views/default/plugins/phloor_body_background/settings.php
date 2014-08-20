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

$enable_user_profile_background = $vars['entity']->enable_user_profile_background;

if (strcmp('true', $enable_user_profile_background) != 0) {
	$enable_user_profile_background = 'false';
}

?>
<?php

//  checkbox for enabling custom user background images on profiles
echo '<div style="margin:30px;">';
echo elgg_view('phloor/input/vendors/prettycheckboxes/checklist', array(
	'options' => array(
    	'enable_user_profile_background'  => array(
        	'name'  => 'params[enable_user_profile_background]',
        	'value' => $enable_user_profile_background,
            'label' => elgg_echo('phloor_body_background:enable_user_profile_background'),
            'description' => elgg_echo('phloor_body_background:enable_user_profile_background:description'),
        ),
    ),
));
echo '</div>';


