
<?php
	$settings = $vars['entity'];
?>
<table>
	<tr>
		<td>
			<label>Event Calendar</label>
		</td>
		<td>
			<?php
				echo elgg_view('input/dropdown', array(
					'name' => 'params[event_calendar_state]',
					'value' => $settings->event_calendar_state,
					'options_values' => array(
						1 => 'Enabled',
						0 => 'Disabled',
					),
				));
			?>
		</td>
	</tr>
	<tr>
		<td>
			<label>Groups</label>
		</td>
		<td>
			<?php
				echo elgg_view('input/dropdown', array(
					'name' => 'params[groups_state]',
					'value' => $settings->groups_state,
					'options_values' => array(
						1 => 'Enabled',
						0 => 'Disabled',
					),
				));
			?>
		</td>
	</tr>
</table>
