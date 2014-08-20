<?php
/**
 * Elgg gsa plugin settings.
 *
 * @package gsa
 */

$hostname = $vars['entity']->hostname;
$collection = $vars['entity']->collection;
$frontend = $vars['entity']->frontend;

if (!$hostname) {
    $hostname = 'gsa.yournetwork.internal';
}
if (!$collection) {
    $collection = 'elgg';
}
if (!$frontend) {
    $frontend = 'default_frontend';
}
?>
<div>
    <label>Hostname</label>
    <?php echo elgg_view("input/text",
                        array("name" => "params[hostname]",
                            "value" => $vars['entity']->hostname)); ?>
</div>
<div>
    <label>Collection</label>
    <?php echo elgg_view("input/text",
        array("name" => "params[collection]",
            "value" => $vars['entity']->collection)); ?>
</div>
<div>
    <label>Frontend</label>
    <?php echo elgg_view("input/text",
        array("name" => "params[frontend]",
            "value" => $vars['entity']->frontend)); ?>
</div>
