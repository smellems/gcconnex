<?php
/**
 * An german language definition file
 */

$german = array(
	'facebook_connect' => 'Facebook Services',

	'facebook_connect:requires_oauth' => 'Facebook Services benötigt das aktivierte OAuth Libraries Plugin.',

	'facebook_connect:consumer_key' => 'Facebook Application Id',
	'facebook_connect:consumer_secret' => 'Facebook Application Secret Code',

	'facebook_connect:settings:instructions' => 'Du musst dir eine Klient id und Secret von <a href="http://www.facebook.com/developers/" target="_blank">Facebook</a> holen. Die meisten Felder sind Selbsterklärend. the one piece of data you will need is the callback url which takes the form http://[yoursite]/action/facebooklogin/return - [yoursite] is the url of your Elgg network.',

	'facebook_connect:usersettings:description' => "Verbinde dein %s Konto mit Facebook.",
	'facebook_connect:usersettings:request' => "You must first <a href=\"%s\">authorize</a> %s to access your Facebook account.",
	'facebook_connect:usersettings:logout_required' => 'Du musst zunächst der %s erlauben, auf dein Facebook Konto zuzugreifen. Dafür bitte einmal ausloggen und erneut einloggen.',
	'facebook_connect:authorize:error' => 'Facebook wurde nicht erfolgreich autorisiert.',
	'facebook_connect:authorize:success' => 'Facebook Zuganng wurde autorisiert.',

	'facebook_connect:usersettings:authorized' => "Du hast %s erlaubt auf deinen Facebook Konto zuzugreifen: @%s.",
	'facebook_connect:usersettings:revoke' => 'Klicke <a href="%s">hier</a>, um die Facebook-Verbindung zu löschen.',
	'facebook_connect:revoke:success' => 'Facebook Zugang wurde wiederrufen.',

	'facebook_connect:login' => 'Erlaube existierenden Nutzern, die hier Facebook Konto verbunden haben, sich über Facebook anzumelden?',
	'facebook_connect:new_users' => 'Erlaube neuen Nutzern sich per Facebook regisiteren, auch wenn die manuelle Registierung deaktivert ist?',
	'facebook_connect:post_onfb' => 'Für neue Nutzer den Facebook Konto synch Status auf Facebook posten?',
	'facebook_connect:login:success' => 'Du bist angemeldet.',
	'facebook_connect:login:error' => 'Login mit Facebook fehlgeschlagen.',
	'facebook_connect:login:email' => "Du musst eine gültige Email-Adresse für dein neues %s Konto eingeben.",
	'facebook_connect:email:subject' => '%s Registierung erfolgreich',
	'facebook_connect:email:body' => '
Hallo %s,

Glückwunsch! Du wurdest erfolgreich regisitert. Bitte besuche unser Netzwerk hier auf %s %s.

Deine Anmeldedaten sind -

Username ist %s
Email    ist %s
Password ist %s

Du kannst dich mit EMail-Adrese oder Usernamen anmleden.

%s
%s'
	
	);

add_translation('de', $german);
