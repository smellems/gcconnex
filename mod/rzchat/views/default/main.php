<?php
/**
 * @version 1.0
 * @copyright Copyright (C) 2014 rayzzz.com. All rights reserved.
 * @license GNU/GPL2, see LICENSE.txt
 * @website http://rayzzz.com
 * @twitter @rayzzzcom
 * @email rayzexpert@gmail.com
 */

$sModule = "rzchat";
$sModuleUrl = elgg_get_site_url() . "mod/" . $sModule . "/";
require_once(elgg_get_plugins_path() . $sModule . "/include/init.inc.php");
$oInit = RzInit::getInstance($sModule);
$user = elgg_get_logged_in_user_entity();

?>
<div id="rz_app"></div>
<script type="text/javascript">
	swfobject.embedSWF("<?=$sModuleUrl?>app/user.swf", "rz_app", "<?=$oInit->aRzInfo['width']?>", "<?=$oInit->aRzInfo['height']?>", "10", "<?=$sModuleUrl?>app/expressInstall.swf", {app:"<?=($user->isAdmin() == 'yes' ? "admin" : "user")?>",url:"<?=$sModuleUrl?>XML.php",id:"<?=$user->guid?>",password:"<?=$user->password?>"}, {allowScriptAccess:"always",allowFullScreen:"true",base:"<?=$sModuleUrl?>",wmode:"opaque"}, {style:"display:block;"});
</script>