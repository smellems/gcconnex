<?php
    $characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
    $random_string_length = 10;

    $stringpad = '';
    for ($i = 0; $i < $random_string_length; $i++) {
      $stringpad .= $characters[rand(0, strlen($characters) - 1)];
    }
    
    $urlpad = elgg_extract('url', $vars,'');
    if (!$urlpad) {
    	$urlpad = elgg_get_plugin_setting('etherpad','etherpad')."/p/".$stringpad;
    }
    $objetive = elgg_extract('objetive', $vars,'');
    $access_id = elgg_extract('access_id', $vars, ACCESS_DEFAULT);
    $container_guid = elgg_extract('container_guid', $vars);
    $guid = elgg_extract('guid', $vars, null);
    $group_guid = elgg_get_page_owner_guid();
?>

<div>
    <label><?php echo elgg_echo("etherpad:url"); ?></label><br />
    <?php echo elgg_view('input/text',array('name' => 'url',
					    'value' => $urlpad,
					    'disabled' => false )); ?>
</div>

<div>
    <label><?php echo elgg_echo("etherpad:objetive"); ?></label><br />
    <?php echo elgg_view('input/longtext',array('name' => 'objetive', 'value' => $objetive)); ?>
</div>
<div>
        <label><?php echo elgg_echo('access'); ?></label><br />
        <?php echo elgg_view('input/access', array('name' => 'access_id', 'value' => $access_id)); ?>
</div>


<?php

echo elgg_view('input/hidden', array('name' => 'group_guid', 'value' => $group_guid)); 
echo elgg_view('input/hidden', array('name' => 'container_guid', 'value' => $container_guid));
if ($guid) {
        echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $guid));
}

?>

<div>
    <?php echo elgg_view('input/submit', array('value' => elgg_echo('save'))); ?>
</div>
