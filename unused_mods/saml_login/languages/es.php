<?php
/**
 * An english language definition file
 */

$spanish = array(
	'saml_login' => 'Acceso SAML',
	'saml_login:config:error' => 'Error de configuración del plugin SAML',
	'saml_login:simplesamlphppath' => 'Ruta al entorno del SimpleSAMLPHP. ej: /var/www/sp/simplesamlphp',
	'saml_login:saml_authsource' => 'Nombre de la fuente de autenticación del SP que quieres conectar con elgg. (Las fuentes están definidas en SSP en /config/authsources.php)',
	'saml_login:usernamefield' => 'Atributo de la aserción SAML que contiene el identificador de usuario que se usará para elgg, posibles valores son el uid, cn o el eduPersonPrincipalName',
	'saml_login:login' => '¿Permites el acceso a usuarios que se hayan autenticado en el IdP?',
	'saml_login:login:disabled' => 'El acceso vía SAML está deshabilitado',
	'saml_login:login:success' => 'Has accedido correctamente (acceso SAML)',
	'saml_login:login:error' => 'Hubo un error al acceder (acceso SAML)',
	'saml_login:login:no_mail' => 'El IdP no suministró el atributo email y es obligatorio',
	'saml_login:login:no_username' =>  'El IdP no suministró un username y es obligatorio',
	'saml_login:logout' => '¿Habilitar SLO?',
	'saml_login:new_users' => 'La creación de usuarios vía SAML está deshabilitada. Te autenticastes correctamente en el IdP pero es necesario tener creada una cuenta en elgg para poder acceder',
	'saml_login:new_user:disabled' => 'La creación de usuarios vía SAML está deshabilitada',
	'saml_login:new_user:bad' => 'Fallo al registrar un nuevo usuario (provisión SAML)',
	'saml_login:new_user:success' => 'Nuevo usuario creado (provisión SAML)',
	'saml_login:update_userdata' => '¿Actualizar la cuenta de los usuarios de elgg con los datos del usuario que provienen del IdP en cada acceso?',
);

add_translation('es', $spanish);
