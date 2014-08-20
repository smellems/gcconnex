<?php
/**
 * View for phloor_backgrond_image objects
 *
 */

$full = elgg_extract('full_view', $vars, FALSE);
$background_image = elgg_extract('entity', $vars, FALSE);

if (!$background_image) {
    return TRUE;
}

$owner      = $background_image->getOwnerEntity();
$container  = $background_image->getContainerEntity();

$owner_icon = elgg_view_entity_icon($owner, 'tiny');
$owner_link = elgg_view('output/url', array(
	'href' => "phloor_news/owner/$owner->username",
	'text' => $owner->name,
	'is_trusted' => true,
));
$author_text = elgg_echo('byline', array($owner_link));
$date = elgg_view_friendly_time($background_image->time_created);

$metadata = elgg_view_menu('entity', array(
	'entity' => $vars['entity'],
	'handler' => 'phloor_body_background',
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
));

$subtitle = "$author_text $date $categories";

if ($full) {
    $body = "";

    // append image if existing
    if($background_image->hasImage()) {
        $image = elgg_view('output/img', array(
 			'title' => "{$owner->username} #{$background_image->guid}",
	        'alt'   => "image:{$owner->username}:{$background_image->guid}",
	        'class' => 'elgg-photo',
	        'src'   => $background_image->getThumbnailURL('master'),
        ));

        $image_view = <<<HTML
<div class="phloor-body-background-image">
	$image
</div>
HTML;

        $body .= $image_view;
    }

    $display_attributes = array(
        'color', 'repeat', 'attachment', 'position'
    );

    foreach($display_attributes as $attribute) {
        $label = elgg_echo("phloor_body_background:$attribute:label");
        $value = $background_image->$attribute;

        if (!empty($value)) {
            $body .= "<p><div class=\"phloor-background-image-label\">$label: </div> $value</p>";
        }
    }

    $params = array(
		'entity' => $background_image,
		'title' => false,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
    );
    $params = $params + $vars;
    $summary = elgg_view('object/elements/summary', $params);

    echo elgg_view('object/elements/full', array(
		'summary' => $summary,
		'icon'    => $owner_icon,
		'body'    => $body,
    ));


} else {

    $display_attributes = array(
        'color', 'repeat', 'attachment', 'position'
    );

    $attribute_list = "";

    foreach($display_attributes as $attribute) {
        $label = elgg_echo("phloor_body_background:$attribute:label");
        $value = $background_image->$attribute;

        if (!empty($value)) {
            $attribute_list .= " $value";
        }
    }

    $subtitle .= "<br /> $attribute_list";

    $params = array(
		'entity'    => $background_image,
		'metadata'  => $metadata,
		'subtitle'  => $subtitle,
       // 'title'    => "{$owner->username} #{$background_image->guid}",
		'content'   => $content,
    );
    $params = $params + $vars;
    $list_body = elgg_view('object/elements/summary', $params);

    // check if image exists
    if($background_image->hasImage()) {
        $size = 'small';
        $background_image_image_url = elgg_format_url($background_image->getImageURL($size));

        $image_alt = elgg_view('phloor/output/avatar', array(
			'src'      => $background_image_image_url,
            'link_url' => $background_image->getURL(),
			'size'     => $size,
        	'title'    => "{$owner->username} #{$background_image->guid}",
        ));

        // add to params to display it in image block
        $params['image_alt'] = $image_alt;
    }

    echo elgg_view_image_block($owner_icon, $list_body, $params);
}
