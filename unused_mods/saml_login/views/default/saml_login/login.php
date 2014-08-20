<?php
/**
 *  View to include the SAML logo button
 */

$url = 	elgg_get_site_url() . 'saml_login?saml_login=true';
$img_url = elgg_get_site_url() . 'mod/saml_login/graphics/logo.gif';

$login = <<<__HTML
<div id="login_with_saml">
	<a href="$url"><img height="50" width="210" src="$img_url" alt="SAML Login" title="SAML Login" /></a>
</div>
__HTML;

echo $login;
