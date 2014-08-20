<?php
	/**
	 * @file views/default/forum/forms/groups_permissions_table.php
	 * @brief Displays the grousp permission table for editing forums forms
	 */
?>

<table class='groups_permission_table'>
	<tr>
		<th class="group_guid"><h3><?php echo elgg_echo('forum:guid'); ?></h3></th>
		<th class="group_name"><h3><?php echo elgg_echo('forum:group_name'); ?></h3></th>
		<th class="view_option"><h3><?php echo elgg_echo('forum:view'); ?></h3></th>
		<th class="post_option"><h3><?php echo elgg_echo('forum:post'); ?></h3></th>
		<th class="moderate_option"><h3><?php echo elgg_echo('forum:moderate'); ?></h3></th>
	</tr>
	<tr>
		<td class="group_guid">-</td>
		<td class="group_name"><?php echo elgg_echo('forum:public_forum'); ?></td>
		<?php
			if (in_array(2,$vars['allowed_view_values'])) {
				$public_view = ' checked="checked" ';
			}
		?>
		<td class="view_option"><input type="checkbox" <?php echo $public_view; ?> name="allowed_view[]" value="2" /></td>
		<td class="post_option"><input type="checkbox" name="allowed_view[]" disabled="disabled" /></td>
		<td class="moderate_option"><input type="checkbox" name="allowed_view[]" disabled="disabled" /></td>
	</tr>
	<tr>
		<td class="group_guid">-</td>
		<td class="group_name"><?php echo elgg_echo('forum:loggedin_users'); ?></td>
		<?php
			if ((in_array(1,$vars['allowed_view_values'])) || $public_view) {
				$loggedin_view = ' checked="checked" ';
			} 
		?>
		<td class="view_option"><input type="checkbox" <?php echo $loggedin_view; ?> name="allowed_view[]" value="1" /></td>
		<?php
			if (in_array(1,$vars['allowed_post_values'])) {
				$loggedin_post = ' checked="checked" ';
			} 
		?>
		<td class="post_option"><input type="checkbox" <?php echo $loggedin_post; ?> name="allowed_post[]" value="1" /></td>
		<?php
			if (in_array(1,$vars['allowed_moderate_values'])) {
				$loggedin_moderate = ' checked="checked" ';
			} 
		?>
		<td class="moderate_option"><input type="checkbox" <?php echo $loggedin_moderate; ?> name="allowed_moderate[]" value="1" /></td>
	</tr>
	<?php 
		$options = array(
			'types'=>'group',
			'limit'=>999999,
			); 
		
		if ($groups = elgg_get_entities($options)) {
	?>
			<?php 
				foreach($groups as $group)
				{
			?>
					<tr>
						<td class="group_guid"><?php echo $group->guid; ?></td>
						<td class="group_name"><?php echo $group->name; ?></td>
						<td class="view_option">
							<?php
								if (!$vars['entity']) {
									if (in_array($group->guid,$vars['allowed_view_values'])) {
										$checked = 'checked="checked"';
									} else {
										$checked = '';
									}
								} else {
									if (group_can_see_forum($vars['entity']->guid,$group->guid)) {
										$checked = 'checked="checked"';
									} else {
										$checked = '';
									}
								}
							?>
							<input type="checkbox" name="allowed_view[]" <?php echo $checked; ?> value="<?php echo $group->guid;?>" />
						</td>
						<td class="post_option">
							<?php
								if (!$vars['entity']) {
									if (in_array($group->guid,$vars['allowed_post_values'])) {
										$checked = 'checked="checked"';
									} else {
										$checked = '';
									}
								} else {
									if (group_can_post_in_forum($vars['entity']->guid,$group->guid)) {
										$checked = 'checked="checked"';
									} else {
										$checked = '';
									}
								}
							?>
							<input type="checkbox" name="allowed_post[]" <?php echo $checked; ?> value="<?php echo $group->guid;?>" />
						</td>
						<td class="moderate_option">
							<?php
								if (!$vars['entity']) {
									if (in_array($group->guid,$vars['allowed_post_values'])) {
										$checked = 'checked="checked"';
									} else {
										$checked = '';
									}
								} else {
									if (group_can_moderate_forum($vars['entity']->guid,$group->guid)) {
										$checked = 'checked="checked"';
									} else {
										$checked = '';
									}
								}
							?>
							<input type="checkbox" name="allowed_moderate[]" <?php echo $checked; ?> value="<?php echo $group->guid;?>" />
						</td>
					</tr>
			<?php
				}
			?>
	<?php
		} else {
	?>
			<tr>
				<td class="group_guid">-</td>
				<td class="group_name"><b><?php echo elgg_echo('forum:create_new_elgg_group'); ?></b></td>
				<td class="view_option"><input type="checkbox" name="allowed_view[]" value="public" disabled="disabled" /></td>
				<td class="post_option"><input type="checkbox" name="allowed_view[]" value="public" disabled="disabled" /></td>
				<td class="moderate_option"><input type="checkbox" name="allowed_view[]" value="public" disabled="disabled" /></td>
			</tr>
	<?php					
		}
	?>
</table>