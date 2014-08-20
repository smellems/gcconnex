<?php
/**
 * A standard postal address form
 *
 * @uses $vars['prefix'] A string to prefix input names with, defaults to 'address'
 * @uses $vars['value'] An array of values to prepopulate the form with
 * @uses $vars['required'] Make required
 */

namespace hypeJunction\Places;

$prefix = elgg_extract('prefix', $vars, 'address');
$required = elgg_extract('required', $vars, false);
$value = elgg_extract('value', $vars);

if ($required) {
	$label_attrs = elgg_format_attributes(array(
		'title' => elgg_echo('places:required'),
		'class' => 'required',
	));
}
$street_address = elgg_view('input/text', array(
	'name' => "{$prefix}[street_address]",
	'value' => elgg_extract('street_address', $value),
	'class' => 'places-input-street-address',
	'placeholder' => elgg_echo('places:postal_address:street_address'),
	'required' => $required
		));

$extended_address = elgg_view('input/text', array(
	'name' => "{$prefix}[extended_address]",
	'value' => elgg_extract('extended_address', $value),
	'class' => 'places-input-extended-address',
	'placeholder' => elgg_echo('places:postal_address:extended_address')
		));

$locality = elgg_view('input/text', array(
	'name' => "{$prefix}[locality]",
	'value' => elgg_extract('locality', $value),
	'class' => 'places-input-locality',
	'placeholder' => elgg_echo('places:postal_address:locality'),
	'required' => $required
		));

$region = elgg_view('input/text', array(
	'name' => "{$prefix}[region]",
	'value' => elgg_extract('region', $value),
	'class' => 'places-input-region',
	'placeholder' => elgg_echo('places:postal_address:region'),
	//'required' => $required
		));

$postal_code = elgg_view('input/text', array(
	'name' => "{$prefix}[postal_code]",
	'value' => elgg_extract('postal_code', $value),
	'class' => 'places-input-postal-code',
	'placeholder' => elgg_echo('places:postal_address:postal_code'),
	'required' => $required
		));

if (elgg_view_exists('input/geo/country')) {
	$country = elgg_view('input/geo/country', array(
		'name' => "{$prefix}[country_code]",
		'value' => elgg_extract('country_code', $value),
		'class' => 'places-input-country-code',
		'required' => $required
	));
} else {
	$country = elgg_view('input/text', array(
		'name' => "{$prefix}[country]",
		'value' => elgg_extract('country', $value),
		'class' => 'places-input-country-code',
		'required' => $required
	));
}
?>

<fieldset class="places-postal-address" data-postal-address>
	<div data-street-address>
		<label <?php echo $label_attrs ?>><?php echo elgg_echo('places:postal_address:street_address') ?></label>
		<?php echo $street_address ?>
	</div>
	<div data-extended-address>
		<label><?php echo elgg_echo('places:postal_address:extended_address') ?></label>
		<?php echo $extended_address ?>
	</div>
	<div data-locality>
		<label <?php echo $label_attrs ?>><?php echo elgg_echo('places:postal_address:locality') ?></label>
		<?php echo $locality ?>
	</div>
	<div data-region>
		<label><?php echo elgg_echo('places:postal_address:region') ?></label>
		<?php echo $region ?>
	</div>
	<div data-postal-code>
		<label <?php echo $label_attrs ?>><?php echo elgg_echo('places:postal_address:postal_code') ?></label>
		<?php echo $postal_code ?>
	</div>
	<div data-country>
		<label <?php echo $label_attrs ?>><?php echo elgg_echo('places:postal_address:country') ?></label>
		<?php echo $country ?>
	</div>
</fieldset>