<?php
	/**
	 * @file views/default/post/list_posts.php
	 * @brief Displays a list of posts
	 */
?>

<div class="forum_container">
	<?php
		if (!$vars['hidden_new_post_button']) {
			// Button for create a new post
			echo elgg_view('post/new_post_button',$vars);
		}
		
		$sort_by = (get_input('sort_by')) ? (get_input('sort_by')) : 'most_recent_desc';
		if ($posts = list_posts($vars['entity']->guid,array('pagination'=>true,'full_view'=>false,'sort_by'=>$sort_by,'remove_important_topics'=>true))) {
			echo elgg_view('post/listing_posts_header',$vars);
			echo $posts;
		}
	?>
</div>