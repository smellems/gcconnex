<?php
	/**
	 * @file views/default/post/list_comments.php
	 * @brief Displays the list of comments for a post
	 */

	if ($vars['entity']) {
		$counter = count_annotations($vars['entity']->guid,'object','post','comment');
?>
		<div class='list_comments'>
			<div class='list_comments_title'>
				<h4>
					<?php
						echo $counter.' '.elgg_echo('forum:comments');
						
						if ($vars['entity']->status == 'closed') {
							echo ' ('.elgg_view('post/lock',array('entity'=>$vars['entity'],'class'=>''));
							echo elgg_echo('forum:closed').')';
						}
		 			?>
				</h4>
				
			</div>
			
			<?php echo list_annotations($vars['entity']->guid,'comment',10); ?>
		</div>
<?php
	}
?>