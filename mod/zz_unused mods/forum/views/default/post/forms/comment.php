<?php
	/**
	 * @file views/default/post/forms/comment.php
	 * @brief Display the comment creation form
	 */

	if (($vars['entity']->status!='closed') && ($vars['user'])) {
		// This input may be setted up into the post_page_handler when the user is editing some comment
		if ($comment_id = get_input('comment_id')) {
			$comment = get_annotation($comment_id);
			if (can_edit_extender($comment->id,'annotation',$vars['user']->guid)) {
				$text_value = $comment->value;
				$comment_id = $comment->id;
			}
		}
?>
		<div class='comment_wrapper'>
			<div class='comment_container'>
				<h4><?php echo elgg_echo('forum:comment'); ?></h4>
				<?php
					$action = $vars['url'].'action/forum/edit_comment';
					$form_body = '';
					
					// Remove tinymce if the tinymce plugin is enabled
					$longtext = (is_plugin_enabled('tinymce')) ? ('post/forms/longtext_without_tinymce') : ('input/longtext');
					$form_body .= elgg_view($longtext,array('internalname'=>'comment_text', 'internalid'=>'c','value'=>$text_value));

					$form_body .= elgg_view('input/hidden',array('internalname'=>'post_guid','value'=>$vars['entity']->guid));
					$form_body .= elgg_view('input/hidden',array('internalname'=>'comment_id','value'=>$comment_id));
					$form_body .= elgg_view('input/submit',array('value'=>elgg_echo('forum:send')));

					$form = elgg_view('input/form',array('body'=>$form_body,'action'=>$action));
					echo $form;
				?>
			</div>
		</div>
<?php
	}
?>