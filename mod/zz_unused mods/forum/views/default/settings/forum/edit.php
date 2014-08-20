<?php
	/**
	 * @file views/default/settings/forum/edit.php
	 * @brief Include in the elgg system the settings for the forum plugin
	 */

	$options = array(elgg_echo('forum:yes')=>'yes',elgg_echo('forum:no')=>'no');
?>

<h3><?php echo elgg_echo('forum:enable_main_forum_concept'); ?></h3>
<span class="reduced_text"><?php echo elgg_echo('forum:enable_main_forum_concept_explanation'); ?></span>
<br />
<?php 
	if (!$value = get_plugin_setting('enable_main_forum_concept','forum')) {
		$value = 'no';
		set_plugin_setting('enable_main_forum_concept','no','forum');
	}
	echo elgg_view('input/radio',array('internalname'=>'params[enable_main_forum_concept]','value'=>$value,'options'=>$options));
?>
<br />
<br />

<h3><?php echo elgg_echo('forum:add_rating_system'); ?></h3>
<?php
	if (!$value = get_plugin_setting('add_rating_system','forum')) {
		$value = 'yes';
		set_plugin_setting('add_rating_system','yes','forum');
	}
	
	echo elgg_view('input/radio',array('internalname'=>'params[add_rating_system]','value'=>$value,'options'=>$options));
?>
<br />

<h3><?php echo elgg_echo('forum:add_view_counting_system'); ?></h3>
<?php 
	if(!$value = get_plugin_setting('add_view_counting_system')) {
		$value = 'yes';
		set_plugin_setting('add_view_counting_system','yes','forum');
	}
	echo elgg_view('input/radio',array('internalname'=>'params[add_view_counting_system]','value'=>$value,'options'=>$options));
?>