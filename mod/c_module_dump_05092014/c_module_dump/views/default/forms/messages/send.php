<?php
/**
 * Compose message form
 *
 * @package ElggMessages
 * @uses $vars['friends']
 */

$recipient_guid = elgg_extract('recipient_guid', $vars, 0);
$subject = elgg_extract('subject', $vars, '');
$body = elgg_extract('body', $vars, '');

$recipients_options = array();
foreach ($vars['friends'] as $friend) {
	$recipients_options[$friend->email] = $friend->name;
}

if (!array_key_exists($recipient_guid, $recipients_options)) {
	$recipient = get_entity($recipient_guid);
	if (elgg_instanceof($recipient, 'user')) {
		$recipients_options[$recipient_guid] = $recipient->name;
	}
}

$recipient_drop_down = elgg_view('input/dropdown', array(
	'name' => 'recipient_guid',
	'id' => 'recipient_guid',
	'value' => $recipients_options[$recipient_guid] ,
	'options_values' => $recipients_options,
));

?>

<style> 
td {
	vertical-align:middle;
}

.tag {
    color: #3E6D8E;
    background-color: #E0EAF1;
    border-bottom: 1px solid #b3cee1;
    border-right: 1px solid #b3cee1;
    padding: 3px 4px 3px 4px;
    margin: 2px 2px 2px 0;
    text-decoration: none;
    font-size: 90%;
    line-height: 2.4;
    white-space: pre-wrap;
}
.tag:hover {
    background-color: #c4dae9;
    border-bottom: 1px solid #c4dae9;
    border-right: 1px solid #c4dae9;
    text-decoration: none;
}

.watermark {
	position: absolute;
	opacity: 0.25;
	font-size: medium;
	width: 100%;
	text-align: left;
	z-index:100;
}

</style>

<script>
var arr = [];
	$(function() {
		$('#add').bind('click', function() {
			var recipients = $('#recipient_guid').val();
			var textValue = $('#to_recipients').val();
			
			if ((document.getElementById('target').innerHTML).indexOf(recipients) < 0)
			{
				if (textValue !== '')
				{
					arr = textValue.split(';');
				}
				$('#to_recipients').val(arr.join(';'));
				$('.target').append('<a class="tag">' + recipients + '</a>');

			} else { /* do nothing */ }
		});
	});


	$('.tag').live("click", function(e) {
		$(this).remove();
	});

function get_Emails() {

	var all = document.getElementById('target').childNodes;
	var listEmail = '';

	for (var i = 0; i < all.length; i++)
	{
		if (listEmail !== '')
			listEmail = listEmail + ';'+all[i].innerHTML;
		else
			listEmail = listEmail + all[i].innerHTML;
	}
	document.getElementById('to_recipients').value = listEmail;
}

$(document).ready(function() {
	document.getElementById('left_dropdown').style.visibility = 'hidden';
	document.getElementById('left_dropdown').style.display = 'none';
});

</script>
<noscript>
	<!-- <font style="color:red;">Warning: Your javascript is disabled</font> -->
	<style>
		#right_dropdown {
			display:none;
		}
		#left_dropdown {
			visibility:visible;
		}
	</style>
</noscript>


<table>
	<tr><td></td><td><span id="right_dropdown" style="float:right;"><?php echo $recipient_drop_down ?> <font style="color:blue" id='add'>add recipient</font> </span></td></tr>
<tr>
 	
	<td style="padding-right:10px;">To...</td><td style="width:100%;">

	<div id="right_dropdown">
			<?php 
				echo elgg_view('input/hidden', array('id' => 'to_recipients', 'name' => 'to_recipients', 'value' => $to_recipients, ));
			?>
		</div>
		<div id="target" class="target" contenteditable="false"></div>
	

	<div id="left_dropdown">
		<?php echo $recipient_drop_down; ?>
	</div>


		</td>
	</tr>
	<tr>
		<td style="padding-right:10px;">Subject: </td><td style="width:100%;">
		<?php 
			echo elgg_view('input/text', array('name' => 'subject', 'value' => $subject));
		?>
		</td>
	</tr>
</table>

<br/>
<div>
	<label><?php echo elgg_echo("messages:message"); ?>:</label>
	<?php echo elgg_view("input/longtext", array(
		'name' => 'body',
		'value' => $body,
	));
	?>
</div>
<div class="elgg-foot">
	<?php echo elgg_view('input/submit', array('value' => elgg_echo('messages:send'), 'onClick' => 'get_Emails();')); ?>
</div>
