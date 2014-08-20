<div id='justification_panel' style='height:400px; width:825px;'>
<div style='height:400px; width:800px;'>

<div>
	<u><h1> <?php echo elgg_echo('grp_just:justification'); ?> </h1></u>
	<br/>
	<?php echo utf8_encode(htmlentities(elgg_echo('grp_just:notice'))); ?>
	<br/><br/>
</div>

<?php 
	$url = elgg_get_site_url() . "action/groups/{$_GET['grp_id']}";
	$url = elgg_add_action_tokens_to_url($url);
?>

<form name="input" action="<?php echo $url; ?>" method="post">
<div>
	<?php
	echo elgg_view('input/hidden', array(
		'name' => 'member_info',
		'id' => 'member_info',
		'readonly' => 'readonly',
		'value' => get_loggedin_user()->username.';'.get_loggedin_userid(),
	));
	?>
</div>

<div>
	<?php
		$group_id = explode('=',$_GET['grp_id']);
		echo elgg_view('input/hidden', array(
		'name' => 'group_info',
		'id' => 'group_info',
		'readonly' => 'readonly',
		'value' => $group_id[1],
	));
	?>
</div>

<div>
	<font id="justification_err" color="red"></font><br />
	<textarea style="resize:none;" name="justification" id="justification" rows="4" cols="5"></textarea>

	<noscript>
		<style>textarea#justification {width:500px; height:500px;}</style>
	</noscript>
</div>

<?php

echo '<div class="elgg-foot">';
echo elgg_view('input/submit', array(
	'name' => 'submit', 
	'value' => utf8_encode(htmlentities(elgg_echo('grp_just:submit_app'))),
	'id' => 'submit',
	));
echo '</form>';

echo '</div>';
echo '</div>';
echo '</div>';
