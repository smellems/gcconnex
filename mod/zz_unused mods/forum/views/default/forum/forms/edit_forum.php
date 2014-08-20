<?php
	/**
	 * @file views/default/forum/forms/edit_forum.php
	 * @brief Displays the edit forum form
	 */

	// Getting the form input pre-filled values
	if ($vars['entity'] || $_SESSION['forum_edit_error']) {
		// If the user is not editing one pre-existing entity than try to get pre-filled values from $_SESSION
		if (!$vars['entity']) {
			$forum_name = $_SESSION['forum_name'];
			$forum_order = $_SESSION['forum_order'];
			$forum_description = $_SESSION['forum_description'];
			$main_forum = $_SESSION['main_forum'];
			$allowed_view = unserialize($_SESSION['allowed_view']);
			$allowed_post = unserialize($_SESSION['allowed_post']);
			$allowed_moderate = unserialize($_SESSION['allowed_moderate']);
		} else {
			$entity_guid = $vars['entity']->guid;
			$forum_name = $vars['entity']->title;
			$forum_order = $vars['entity']->order;
			$forum_description = $vars['entity']->description;
			$main_forum = ($vars['entity']->main_forum) ? 'yes' : 'no';
			
			// Getting the visualization groups GUID array
			if ($visualization_groups = $vars['entity']->visualization_groups) {
				if (is_array($visualization_groups)) {
					$allowed_view = $vars['entity']->visualization_groups;
				} else {
					$allowed_view = array($vars['entity']->visualization_groups);
				}
			}

			// Getting the posting groups GUID array
			if ($posting_groups = $vars['entity']->posting_groups) {
				if (is_array($posting_groups)) {
					$allowed_post = $posting_groups;
				} else {
					$allowed_post = array($posting_groups);
				}
			}
			
			// Getting the moderation groups GUID array
			if ($moderation_groups = $vars['entity']->moderation_groups) {
				if (is_array($moderation_groups)) {
					$allowed_moderate = $vars['entity']->moderation_groups;
				} else {
					$allowed_moderate = array($vars['entity']->moderation_groups);
				}
			}
		}
	}

	$action = $vars['url'].'action/forum/edit_forum';
	$form_body = '';
	
	// Setting the forum name input 
	$form_body .= '<label>';
	$form_body .= elgg_echo('forum:forum_name');
	$form_body .= elgg_view('input/text',array('internalname'=>'forum_name','value'=>$forum_name));
	$form_body .= '</label>';
	$form_body .= '<br /><br />';
	
	// Setting the forum order input 
	$form_body .= '<label>';
	$form_body .= elgg_echo('forum:forum_order');
	if (!$forum_order) {
		$forum_order = 10;
	}
	$form_body .= elgg_view('input/text',array('internalname'=>'forum_order','value'=>$forum_order));
	$form_body .= '</label>';
	$form_body .= '<br /><br />';
	
	// Setting the forum description input
	$form_body .= '<label>';
	$form_body .= elgg_echo('forum:forum_description');
	$form_body .= elgg_view('input/longtext',array('internalname'=>'forum_description','value'=>$forum_description));
	$form_body .= '</label>';
	$form_body .= '<br /><br />';

	// Setting the main forum option
	$main_forum_guid = get_main_forum_guid();
	$main_forum_entity = get_entity($main_forum_guid);

	// If no pre-filled value for the main forum input
	if (!$vars['entity'] && !$_SESSION['forum_edit_error']) {
		// If the site don't yet setted the main forum then suggest it now
		if (!$main_forum_guid) {
			$main_forum = 'yes';
		} else {
			$main_forum = 'no';
		}
	}
	$form_body .= '<label>';
	$form_body .= elgg_echo('forum:mark_as_main_forum');

	if ($main_forum_entity) {
		$form_body .= ' ('.sprintf(elgg_echo('forum:current_main_forum'),$main_forum_entity->title).')';
	}
	$form_body .= '<br />';
	$opt = array(
		elgg_echo('forum:yes')=>'yes',
		elgg_echo('forum:no')=>'no',
		);
	$form_body .= elgg_view('input/radio',array('internalname'=>'main_forum','options'=>$opt,'value'=>$main_forum));
	$form_body .= '</label>';
	
	$form_body .= '<br />';

	$form_body .= elgg_view('forum/forms/groups_permissions_table',array('entity'=>$vars['entity'],'allowed_view_values'=>$allowed_view,'allowed_post_values'=>$allowed_post,'allowed_moderate_values'=>$allowed_moderate));
	
	$form_body .= elgg_view('input/hidden',array('internalname'=>'entity_guid','value'=>$entity_guid));
	
	$container_forum_guid = get_input('container_forum_guid');
	$form_body .= elgg_view('input/hidden',array('internalname'=>'container_forum_guid','value'=>$container_forum_guid));
	
	// Setting the forum submit button
	$form_body .= elgg_view('input/submit',array('value'=>elgg_echo('forum:submit')));
	
	$form = elgg_view('input/form',array('body'=>$form_body,'action'=>$action));
?>

<div class='forum_wrapper'>
	<div class='new_forum_form forum_container'>
		<?php
			$guid = ($vars['entity']) ? ($vars['entity']->guid) : ($container_forum_guid);
		?>
		<div class='new_forum_form_header'><?php echo get_breadcrumbs($guid); ?></div>
		
		<div class='new_forum_form_body'>
			<?php	
				echo $form;
			?>
		</div>
	</div>
</div>

