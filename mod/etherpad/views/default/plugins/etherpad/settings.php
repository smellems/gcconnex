<?php
/**
 * The etherpad plugin settings
 */
?>
<p>
<?php

  echo elgg_echo('etherpad:base_url')."<br>"; 

  echo elgg_view('input/text', array('name' => 'params[etherpad]', 'value' => $vars['entity']->etherpad));
  echo "&nbsp;".elgg_echo('etherpad:example'); 
  echo "<br>";
?>

</p>
