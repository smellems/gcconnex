<?php
	/**
	 * @file views/default/post/forms/edit_post.php
	 * @brief Displays the edit post form
	 */

	$forum_guid = ($vars['forum_guid']) ? ($vars['forum_guid']) : get_input('forum_guid');

	// Getting the post input pre-filled values
	if ($vars['entity'] || $_SESSION['post_edit_error']) {
		if (!$vars['entity']) {
			$post_title = $_SESSION['post_title'];
			$post_message = $_SESSION['post_message'];
			$post_tags = $_SESSION['post_tags'];
			$post_status = $_SESSION['post_status'];
		} else {
			$entity_guid = $vars['entity']->guid;
			$post_title = $vars['entity']->title;
			$post_message = $vars['entity']->description;
			$post_status = $vars['entity']->status;
			$important_topic = ($vars['entity']->important_topic) ? ($vars['entity']->important_topic) : 'no';
			$tags_array = $vars['entity']->tags;
			if (!is_array($tags_array) && $tags_array) {
				$tags_array = array($tags_array);
			}
			
			foreach ($tags_array as $tag) {
				if ($post_tags) {
					$post_tags .= ', ';
				}
				
				$post_tags .= $tag;
			}
		}
	}

	$action = $vars['url'].'action/forum/edit_post';
	$form_body = '';
	
	// Setting the forum name input 
	$form_body .= '<label>';
	$form_body .= elgg_echo('forum:title');
	$form_body .= elgg_view('input/text',array('internalname'=>'post_title','value'=>$post_title));
	$form_body .= '</label>';
	$form_body .= '<br /><br />';
	
	// Setting the forum description input
	$form_body .= '<label>';
	$form_body .= elgg_echo('forum:message');
	$form_body .= elgg_view('input/longtext',array('internalname'=>'post_message','value'=>$post_message));
	$form_body .= '</label>';
	$form_body .= '<br /><br />';

	// Setting the forum tags input
	$form_body .= '<label>';
	$form_body .= elgg_echo('forum:tags');
	$form_body .= elgg_view('input/text',array('internalname'=>'post_tags','value'=>$post_tags));
	$form_body .= '</label>';
	$form_body .= '<br /><br />';
		
	$form_body .= elgg_view('input/hidden',array('internalname'=>'entity_guid','value'=>$entity_guid));
	$form_body .= elgg_view('input/hidden',array('internalname'=>'forum_guid','value'=>$forum_guid));
	
	// Setting the forum submit button
	$form_body .= elgg_view('input/submit',array('value'=>elgg_echo('forum:submit')));
	
	$form = elgg_view('input/form',array('body'=>$form_body,'action'=>$action));
?>

<div class='forum_wrapper'>
	<div class='new_post_form forum_container'>
		<div class='new_post_form_header'>
			<?php
				$guid = ($vars['entity']) ? ($vars['entity']->guid) : $forum_guid;
				echo get_breadcrumbs($guid);
			?>
		</div>
		
		<div class='new_post_form_body'><?php echo $form; ?></div>
	</div>
</div>