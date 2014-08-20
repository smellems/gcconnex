
<div id='justification_panel' style='height:400px; width:500px;'>
<div style='height:400px; width:500px;'>

<div>
	<u><h1><?php echo elgg_echo('grp_just:justification'); ?></h1></u>
	<br/>
</div>

<?php 

$resultset = elgg_get_entities(array(
	'type' => 'object',
	'subtype' => 'c_group_reason'));

if (count($resultset) > 0)
{
	foreach($resultset as $result)
	{
		$user_group_info = explode(';',$result->title);
		if ($user_group_info[1] == $_GET['userid'] && $user_group_info[2] == $_GET['groupid'])
			echo '<div>'.$result->description.'</div>';
	}
}

echo '</div>';
echo '</div>';
