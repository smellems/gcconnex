<?php
	/**
	 * @file views/default/post/handle_post_links.php
	 * @brief Displays the links for handle posts: edit, delete, close, stick, important  -->
	 */

	// If the loggedin user can edit the entity then show the edit and delete button
	if ($vars['entity'] && $vars['user']) {
?>
		<div class="handle_post_links">
			<?php
				if ($vars['entity']->canEdit($vars['user']->guid) || can_moderate_forum($vars['entity']->container_guid)) {
			?>
					<a href="<?php echo $vars['url']; ?>pg/post/edit/<?php echo $vars['entity']->guid; ?>"><?php echo elgg_echo('forum:edit'); ?></a>
					-
			<?php
					echo elgg_view('output/confirmlink',array('text'=>elgg_echo('forum:delete'),'href'=>$vars['url'].'action/forum/delete_entity?entity_guid='.$vars['entity']->guid));

					// Making close/open link
					$action = $vars['url'].'action/post/close_topic?entity_guid='.$vars['entity']->guid;
					$action = elgg_add_action_tokens_to_url($action);
					$close = ($vars['entity']->status!='closed') ? (elgg_echo('forum:close')) : (elgg_echo('forum:open'));
				?>
					-
					<a href="<?php echo $action;?>"><?php echo $close; ?></a>
			<?php
				}
				
				if (can_moderate_forum($vars['entity']->container_guid)) {
					// Making stick/unstick link
					$action = $vars['url'].'action/post/stick?entity_guid='.$vars['entity']->guid;
					$action = elgg_add_action_tokens_to_url($action);
					$stick = ($vars['entity']->stick) ? (elgg_echo('forum:unstick')) : (elgg_echo('forum:stick')); 
			?>
					-
					<a href="<?php echo $action; ?>"><?php echo $stick; ?></a>
			<?php
					$action = $vars['url'].'action/post/important?entity_guid='.$vars['entity']->guid;
					$action = elgg_add_action_tokens_to_url($action);
					$important = ($vars['entity']->important_topic=='yes') ? elgg_echo('forum:not_important') : elgg_echo('forum:important');
			?>
					-
					<a href="<?php echo $action; ?>"><?php echo $important; ?></a>
					
			<?php
				}
			?>
		</div>
<?php
	}
?>