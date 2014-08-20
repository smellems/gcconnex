<?php
/**
 * An english language definition file
 */

$english = array(
	'saml_login' => 'SAML Login',
	'saml_login:config:error' => 'Error in SAML plugin config',
	'saml_login:simplesamlphppath' => 'Path of the SimpleSAMLPHP environment. eg: /var/www/sp/simplesamlphp',
	'saml_login:saml_authsource' => 'The SP auth source you want to connect to elgg. (Sources are in SSP /config/authsources.php)',
	'saml_login:usernamefield' => 'The attribute whose value uniquely identifies a user object, such as uid or cn or eduPersonPrincipalName',
	'saml_login:login' => 'Allow users who have authenticated at the IdP to sign in?',
	'saml_login:login:disabled' => 'SAML log on is disabled',
	'saml_login:login:success' => 'You have been logged in. (SAML auth)',
	'saml_login:login:error' => 'Unable to login (SAML auth)',
	'saml_login:login:no_mail' => 'Not attribute email provided by the IdP and is a must',
	'saml_login:login:no_username' => 'Not username provided by the IdP and is a must',
	'saml_login:logout' => 'Enable SLO?',
	'saml_login:new_users' => 'Allow new users to sign up using their IdP accounts even if manual registration is disabled?',
	'saml_login:new_user:disabled' => 'Registration of new users is disabled. Your IdP was authenticated sucessfully but it requires that there is an elgg account previously created',
	'saml_login:new_user:bad' => 'Failed to register new user (SAML enrol)',
	'saml_login:new_user:success' => 'New user created (SAML enrol)',
	'saml_login:update_userdata' => 'Update elgg user accounts with the data from the IdP accounts in each log in?',
);

add_translation('en', $english);
