<?php

		include dirname(__FILE__).DIRECTORY_SEPARATOR."lang".DIRECTORY_SEPARATOR."en.php";
		include dirname(__FILE__).DIRECTORY_SEPARATOR."config.php";
		if (file_exists(dirname(__FILE__).DIRECTORY_SEPARATOR."lang".DIRECTORY_SEPARATOR.$lang.".php")) {
			include dirname(__FILE__).DIRECTORY_SEPARATOR."lang".DIRECTORY_SEPARATOR.$lang.".php";
		}

		foreach ($broadcast_language as $i => $l) {
			$broadcast_language[$i] = str_replace("'", "\'", $l);
		}
		$grp ="";
		$width = $camWidth;
		$height = $camHeight;
		if( $videoPluginType == '2' ){
			require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'sdk'.DIRECTORY_SEPARATOR.'API_Config.php';
			require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'sdk'.DIRECTORY_SEPARATOR.'OpenTokSDK.php';

			$apiKey = '348501';
			$apiSecret = '1022308838584cb6eba1fd9548a64dc1f8439774';
			$apiServer = 'https://api.opentok.com/hl';

			$apiObj = new OpenTokSDK($apiKey, $apiSecret);
			$location = time();

			if (!empty($_SERVER['REMOTE_ADDR'])) {
				$location = $_SERVER['REMOTE_ADDR'];
			}

			$session = $apiObj->create_session($location);
			$grp = $session->getSessionId();
			$width = $vidWidth;
			$height = $vidHeight;
		}
?>

/*
 * CometChat
 * Copyright (c) 2012 Inscripts - support@cometchat.com | http://www.cometchat.com | http://www.inscripts.com
*/

(function($){   
  
		$.ccbroadcast = (function () {
		var title = '<?php echo $broadcast_language[0];?>';
		var type = <?php echo $videoPluginType;?>;
		
		var lastcall = 0;

		   return {

				getTitle: function() {
					return title;	
				},

				init: function (id) {
					var random = '';
					var currenttime = new Date();
					currenttime = parseInt(currenttime.getTime()/1000);
					if (currenttime-lastcall > 10) {
						baseUrl = $.cometchat.getBaseUrl();
						baseData = $.cometchat.getBaseData();
						if(type == 2){
							random = '<?php echo $grp;?>';
						} else {
							random = currenttime;
						}
						$.getJSON(baseUrl+'plugins/broadcast/index.php?action=request&callback=?', {to: id, grp: random, basedata: baseData});
						loadCCPopup(baseUrl+'plugins/broadcast/index.php?action=call&type=1&grp='+random+'&basedata='+baseData, 'broadcast',"status=0,toolbar=0,menubar=0,directories=0,resizable=1,location=0,status=0,scrollbars=0, width=440,height=410",440,410,'<?php echo $broadcast_language[8];?>',1);
						
						lastcall = currenttime;
					} else {
						alert('<?php echo $broadcast_language[1];?>');
					}
				},

				accept: function (id,grp) {
					baseUrl = $.cometchat.getBaseUrl();
					baseData = $.cometchat.getBaseData();
					$.getJSON(baseUrl+'plugins/broadcast/index.php?action=call&callback=?', {to: id, grp: grp, basedata: baseData});
					loadCCPopup(baseUrl+'plugins/broadcast/index.php?action=call&grp='+grp+'&basedata='+baseData, 'broadcast',"status=0,toolbar=0,menubar=0,directories=0,type=0,resizable=1,location=0,status=0,scrollbars=0, width=440,height=410",440,410,'<?php echo $broadcast_language[8];?>',1);
				}

			};
		})();
 
})(jqcc);