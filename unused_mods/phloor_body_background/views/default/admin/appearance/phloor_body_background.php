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

// only admins are allowed to see the page
admin_gatekeeper();

$site     = elgg_get_site_entity();
$site_url = elgg_get_site_url();
$time     = time();

$title = elgg_view_title(elgg_echo('phloor_body_background:title'));
$description = elgg_echo('phloor_body_background:description');

$count = phloor_body_background_get_background_image_entities(array(
    'count' => true,
    'container_guid' => $site->guid,
));
$entity_count = elgg_echo('phloor_body_background:admin:appearance:entity_count', array($count));

$site_backgrounds_entities = phloor_body_background_get_background_image_entities(array(
    'count' => false,
    'container_guid' => $site->guid,
));

$background_list = elgg_view_entity_list($site_backgrounds_entities, array(
	'limit'     => 0,
    'full_view' => false,
));

// create a new entity for the form
$new_entity =  new PhloorBackgroundImage();
$new_entity->container_guid = $site->guid;

$form_title = elgg_view_title(elgg_echo("phloor_body_background:add"));
$form = elgg_view('input/form',array(
	'action' => "{$site_url}action/phloor_body_background/save",
	'body' => elgg_view('forms/phloor_body_background/save', array(
        'entity' => $new_entity,
    )),
	'method' => 'post',
	'enctype' => 'multipart/form-data',
));

$preview_title = elgg_view_title(elgg_echo("phloor_body_background:preview"));

echo <<<___HTML
{$title}
<p>{$description}</p>
<div class="phloor-body-background-site-list-admin">
{$background_list}
<p>{$entity_count}</p>
</div>

{$preview_title}
<div id="admin-body-background-preview"><div class="phloor-inner"></div></div>

{$form_title}
<div id="phloor-custom-background-form">
{$form}
</div>
___HTML;

