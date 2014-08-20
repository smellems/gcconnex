<script>

	function validateEmail(email) { 
	    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		var email_is_valid = re.test(email);
	    
	    // check further (ie only let in gc.ca)
	    if (email_is_valid)
	    {
	    	email_is_valid = endsWith(email, 'gc.ca');
	    }
	    return email_is_valid;
	}

	function endsWith(str, suffix) {
    	return str.indexOf(suffix, str.length - suffix.length) !== -1;
	}

	$('input').on("focus", function() {
	    $('#email').on("keyup", function() {
	    	var val = $(this).attr('value');
	        if ( val === '' ) {
	        	var c_err_msg = "<?php echo elgg_echo('gcRegister:empty_field') ?>";
	            document.getElementById('email_error').innerHTML = c_err_msg;
	        }
	        else if ( val !== '' ) {
	            document.getElementById('email_error').innerHTML = '';

	            if (!validateEmail(val)) {
	            	var c_err_msg = "<?php echo elgg_echo('gcRegister:invalid_email') ?>";
	            	document.getElementById('email_error').innerHTML = c_err_msg;
	            }
	        }
	    });
	});
</script>



<?php
/**
 * Provide a way of setting your email
 *
 * @package Elgg
 * @subpackage Core
 */

$user = elgg_get_page_owner_entity();

if ($user) {
	$title = elgg_echo('email:settings');
	$content = elgg_echo('email:address:label') . ': ';
	$content .= '<font id="email_error" color="red"></font><br />';
	$content .= elgg_view('input/text', array(
		'name' => 'email',
		'value' => $user->email,
		'id' => 'email',
	));



	echo elgg_view_module('info', $title, $content);
}
