<?php
	/**
	 * @file views/default/post/full_view.php
	 * @brief Display the forum full view 
	 */
?>

<div class='forum_wrapper'>
	<div class='forum_container'>
		<div class='post_header'>
			<h4 class='float_left'><?php echo get_breadcrumbs($vars['entity']->guid); ?></h4>

			<div class='float_right'><?php
				$vars['full'] = true;
				$vars['full_view'] = true;
				$vars['fullview'] = true;
				echo elgg_view('rating',$vars); ?>
			</div>

			<?php echo elgg_view('post/post_edit_button',$vars); ?>
			<div class='clearfloat'></div>		
		</div>
		
		<div class='post_body'>
			<div class='post_description'><?php echo $vars['entity']->description; ?></div>
			
			<div class='post_info'>
				<!-- Post owner information -->
				<?php echo elgg_view('post/post_owner_info',array('entity'=>$vars['entity'],'class'=>'post_owner_info float_right')); ?>
			
				<!-- Comments counter -->	
				<b><?php echo get_comments($vars['entity']->guid,true); ?></b>
				<span><?php echo elgg_echo('forum:comments'); ?></span>

				<?php
					if (trigger_plugin_hook('views_counting_system','plugin')) {
						if (get_plugin_setting('add_views_counting_system','forum') != 'no') {
				?>
							<!-- Views counter -->
							<?php $views = trigger_plugin_hook('get_views_counter_hook','plugin',array('entity'=>$vars['entity'])); ?>
							<b><span class='margin_left'><?php echo $views; ?></span></b>
							<span><?php echo elgg_echo('forum:views'); ?></span>
				<?php
						}
					}
				?>
				<div class='clearfloat'></div>
			</div>
			<div class='clearfloat'></div>
		</div>
	</div>
</div>