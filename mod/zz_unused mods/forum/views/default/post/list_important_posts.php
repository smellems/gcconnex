<?php
	/**
	 * @file views/default/post/list_important_posts.php
	 * @brief Displays a list of posts marked as imported by some moderator
	 */

	if ($posts = list_posts($vars['entity']->guid,array('important_posts'=>true,'full_view'=>false,'offset'=>0))) {
?>
		<div class="important_topics_container">
			<?php 
				$vars['important_posts'] = true;
				$vars['pagination'] = false;
				$vars['full_view'] = false;
				echo elgg_view('post/listing_posts_header',$vars);
				echo $posts;
			?>
		</div>
<?php
	}
?>
