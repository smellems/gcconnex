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
elgg_load_css('jquery-colorpicker-css');
elgg_load_js('jquery-colorpicker-js');

$background_image = $vars['entity'];

if(!phloor_body_background_instanceof($background_image)) {
    $background_image = new PhloorBackgroundImage();
}

$action_buttons = '';

$save_button = elgg_view('input/submit', array(
	'value' => elgg_echo('save'),
	'name' => 'save',
));

$action_buttons = $save_button ;

$content = '';

$forms = array('background_image' => array());

// if background_image is set - offer the option to delete it
if ($background_image->hasImage()) {
	$forms['background_image']['delete_image'] =  elgg_view('phloor/input/enable', array(
		'name' => 'delete_image',
	));
}

// background image file input view
$forms['background_image']['image'] = elgg_view('input/file', array(
	'name'  => 'image',
	'value' => '', // no value
));

$forms['background_image']['color'] = elgg_view('input/text', array(
    'id'    => 'body-background-color',
	'name'  => 'color',
	'value' => $background_image->color,
    'class' => '',
));

$forms['background_image']['repeat'] = elgg_view('input/radio', array(
	'name'  => 'repeat',
	'value' => $background_image->repeat,
    'options' => array(
        'repeat'    => 'repeat',
        'repeat-x'  => 'repeat-x',
        'repeat-y'  => 'repeat-y',
        'no-repeat' => 'no-repeat',
    ),
    'class' => '',
    'align' => 'horizontal',
));

$forms['background_image']['position'] = elgg_view('input/radio', array(
	'name' => 'position',
	'value' => $background_image->position,
    'options' => array(
        'left top'      => 'left top',
        'left center'   => 'left center',
        'left bottom'   => 'left bottom',
        'right top'     => 'right top',
        'right center'  => 'right center',
        'right bottom'  => 'right bottom',
        'center top'    => 'center top',
        'center center' => 'center center',
        'center bottom' => 'center bottom',
    ),
    'class' => '',
    'align' => 'vertical',
));

$forms['background_image']['attachment'] = elgg_view('input/radio', array(
	'name'  => 'attachment',
	'value' => $background_image->attachment,
    'options' => array(
        'scroll' => 'scroll',
        'fixed'  => 'fixed',
    ),
    'class' => '',
    'align' => 'horizontal',
));

// hidden inputs
$container_guid_input = elgg_view('input/hidden', array(
	'name'  => 'container_guid',
	'value' => elgg_get_page_owner_guid(),
));
$guid_input = elgg_view('input/hidden', array(
	'name'  => 'guid',
	'value' => $background_image->guid,
));

// view each section
foreach($forms as $section_name => $section) {
	// display section title
	$content .= elgg_view_title(elgg_echo('phloor_body_background:form:section:'.$section_name));
	// view each form of a section
	foreach($section as $key => $view) {
		$label = elgg_echo('phloor_body_background:'.$key.':label');
		$description = elgg_echo('phloor_body_background:'.$key.':description');

		// append to content
		$content .= <<<____HTML
<div class="form-item">
 <label>{$label}</label> {$view}
 <div class="description">{$description}</div>
</div>
____HTML;
	}
}

// append form foot
$content .= <<<____HTML
<div class="elgg-foot">
    $guid_input
    $container_guid_input

	$action_buttons
</div>
____HTML;

echo $content;

?>
<script type="text/javascript">
	$(function(){
		$('#body-background-color').ColorPicker({
			onSubmit: function(hsb, hex, rgb) {
				$('#body-background-color').val(hex);
			},
			onBeforeShow: function () {
				$(this).ColorPickerSetColor(this.value);
			}
		})

		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		})
	});
</script>
<?php

