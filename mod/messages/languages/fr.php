<?php
/**
* Elgg send a message action page
* 
* @package ElggMessages
*/

$french = array(
	/**
	* Menu items and titles
	*/

	'messages' => "Messages",
	'messages:unreadcount' => "%s non lus",
	'messages:back' => "retourner au messages",
	'messages:user' => "%s's inbox",
	'messages:posttitle' => "%s's messages: %s",
	'messages:inbox' => "Inbox",
	'messages:send' => "envoyer",
	'messages:sent' => "envoyer",
	'messages:message' => "Message",
	'messages:title' => "sujet",
	'messages:to' => "Ã€ ",
	'messages:from' => "Ã  partir de",
	'messages:fly' => "envoyer",
	'messages:replying' => "Message rÃ©pondant Ã ",
	'messages:inbox' => "BoÃ®te de rÃ©ception",
	'messages:sendmessage' => "Envoyer un message",
	'messages:compose' => "Composer un message",
	'messages:add' => "Composer un message",
	'messages:sentmessages' => "messages envoyÃ©s",
	'messages:recent' => "messages rÃ©cents",
	'messages:original' => "Message original",
	'messages:yours' => "Votre message",
	'messages:answer' => "rÃ©ponse",
	'messages:toggle' => 'toggle tous',
	'messages:markread' => 'marquer comme lu',
	'messages:recipient' => 'Choisissez un destinataire&hellip;',
	'messages:to_user' => 'Ã€ : %s',

	'messages:new' => 'Nouveau message',

	'notification:method:site' => 'Site',

	'messages:error' => "Il ya un problÃ©me d'enregistrer votre message. S'il vous plaÃ¯t essayez de nouveau.",

	'item:object:messages' => 'Messages',

	/**
	* Status messages
	*/

	'messages:posted' => "Votre message a Ã©tÃ© envoyÃ©.",
	'messages:success:delete:single' => 'Message a Ã©tÃ© supprimÃ©',
	'messages:success:delete' => 'Message a Ã©tÃ© supprimÃ©',
	'messages:success:read' => 'Les messages marquÃ©s comme lus',
	'messages:error:messages_not_selected' => 'Pas de messages sÃ©lectionnÃ©s',
	'messages:error:delete:single' => 'Impossible de supprimer le message',

	/**
	* Email messages
	*/

	'messages:email:subject' => 'Vous avez un nouveau message!',
	'messages:email:body' => "vous avez un nouveau message de %s. Il se lit comme suit:


	%s


	Pour afficher vos messages, cliquez ici:

	%s

	Pour envoyer %s un message, cliquez ici:

	%s

	Vous ne pouvez pas rÃ©pondre Ã¡ ce message.",

	/**
	* Error messages
	*/

	'messages:blank' => "DÃ©solÃ©, le contenu est nÃ©cessaire dans le corps du message avant que nous puissions l'enregistrer.",
	'messages:notfound' => "DÃ©solÃ©, nous n'avons pas pu trouver le message spÃ©cifiÃ©.",
	'messages:notdeleted' => "DÃ©solÃ©, nous n'avons pas pu supprimer ce message.",
	'messages:nopermission' => "Vous n'avez pas la permission de modifier ce message.",
	'messages:nomessages' => "Il n'y a aucun message.",
	'messages:user:nonexist' => "We could not find the recipient in the user database.",
	'messages:user:blank' => "Vous n'avez pas choisir quelqu'un d'envoyer Ã¡ .",

	'messages:deleted_sender' => 'utilisateur supprimÃ©',

);
		
add_translation("fr", $french);