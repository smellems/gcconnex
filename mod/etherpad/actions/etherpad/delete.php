<?php

$guid = get_input('guid');
$entity = get_entity($guid);

//if (($entity) && ($entity->canEdit())) {
if ($entity) {
    if ($entity->delete()) {
         system_message(elgg_echo('etherpad:delete:success', array($guid)));
     } else {
         register_error(elgg_echo('etherpad:delete:fail', array($guid)));
     }

} else {
     register_error(elgg_echo('etherpad:delete:fail', array($guid)));
}

 
forward(REFERER);
