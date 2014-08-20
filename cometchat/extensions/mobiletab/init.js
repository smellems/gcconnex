<?php
		include dirname(__FILE__).DIRECTORY_SEPARATOR."config.php";
		include dirname(__FILE__).DIRECTORY_SEPARATOR."lang".DIRECTORY_SEPARATOR."en.php";
		
		if (file_exists(dirname(__FILE__).DIRECTORY_SEPARATOR."lang".DIRECTORY_SEPARATOR.$lang.".php")) {
			include dirname(__FILE__).DIRECTORY_SEPARATOR."lang".DIRECTORY_SEPARATOR.$lang.".php";
		}

		foreach ($mobiletab_language as $i => $l) {
			$mobiletab_language[$i] = str_replace("'", "\'", $l);
		}
 
?>

/*
 * CometChat
 * Copyright (c) 2012 Inscripts - support@cometchat.com | http://www.cometchat.com | http://www.inscripts.com
*/

(function($){  
	$.ccmobiletab = (function () {
		var title = "<?php echo $mobiletab_language[0]; ?>", buddyListMessages = {},loggedout=0,cookie_prefix='<?php echo $cookiePrefix; ?>',tabsize="<?php echo $mobiletabsize; ?>",mobileDevice = navigator.userAgent.match(/ipad|ipod|iphone|android|windows ce|blackberry|palm|symbian/i);
	
		return{
			init:function(){
				if(mobileDevice || location.href.match(jqcc.cometchat.getBaseUrl()+'extensions/mobiletab/')){
					$('#cometchat').hide(0);
					$('body').append('<div class="cometchat_ccmobiletab_redirect "> '+title+' (<span id="ccmobiletab_buddycount">0</span>) </div>');
					jqcc.ccmobiletab.tabalertScale();
					$(".cometchat_ccmobiletab_redirect ,.cometchat_ccmobiletab_tabalert").live('click',function(){
						$(".cometchat_ccmobiletab_redirect .cometchat_ccmobiletab_tabalert").remove();
						jqcc.cookie(cookie_prefix+'state',':::::', {path: '/'});
						location.href=jqcc.cometchat.getBaseUrl()+'extensions/mobile/';
					});
					jqcc.ccmobiletab.updateTabAlert();
				}
			},
			tabalertScale:function(){
				tabsize=tabsize/100;
				var bottom =-(1-tabsize)*40;
				if(tabsize != 1){
					$('.cometchat_ccmobiletab_redirect').css({'transform': 'scale('+tabsize+')','-ms-transform':'scale('+tabsize+')','-webkit-transform': 'scale('+tabsize+')','-o-transform': 'scale('+tabsize+')','-moz-transform': 'scale('+tabsize+')'});
					$('.cometchat_ccmobiletab_redirect').css('bottom',bottom+'px');
				}
			},
			notify:function(totmsg){
				var str,amount;
				typeof(totmsg)=="undefined"?amount=0:amount=totmsg;
				$.each(buddyListMessages,function(i,j){
					amount = parseInt(amount) + parseInt(j);
				});
				if (amount === 0) {
					$(".cometchat_ccmobiletab_redirect .cometchat_ccmobiletab_tabalert").remove();
				}else{
					if (confirm("<?php echo $mobiletab_language[1]; ?>")) {
						$(".cometchat_ccmobiletab_redirect .cometchat_ccmobiletab_tabalert").remove();
						jqcc.cookie(cookie_prefix+'state',':::::', {path: '/'});
						location.href=jqcc.cometchat.getBaseUrl()+'extensions/mobile/';
					}else {
						if($(".cometchat_ccmobiletab_redirect .cometchat_ccmobiletab_tabalert").length>0){
							$(".cometchat_ccmobiletab_redirect .cometchat_ccmobiletab_tabalert").html(amount);
						}else{
							$("<div/>").addClass("cometchat_ccmobiletab_tabalert").html(amount).appendTo($('.cometchat_ccmobiletab_redirect'));	
						}
					}
				}
			},
			updateBuddyList: function(data) {
				$("#ccmobiletab_buddycount").html(data.length);
			},
			newMessages: function(data) {
				$.each(data, function(i,incoming) {
					if (incoming.self == 0) {
						if (buddyListMessages[incoming.from]) {
							buddyListMessages[incoming.from] += 1;
						} else {
							buddyListMessages[incoming.from] = 1;
						}
					jqcc.cookie(cookie_prefix+'new',incoming.from, {path: '/'});
					}
				});	
				jqcc.ccmobiletab.notify();
			},
			loggedOut:function(){
				loggedout=1;
				$(".cometchat_ccmobiletab_redirect").hide(0);
			},
			updateTabAlert:function(){
				if (loggedout == 0) {
					var cc_state = jqcc.cookie("<?php echo $cookiePrefix; ?>"+'state'),newActiveChatboxes={},totmessages=0,value="";
					if (cc_state != null) {
						var cc_states = cc_state.split(/:/);

						if (cc_states[1] != ' ' && cc_states[1] != '') {
							value = cc_states[1];
						}
						if (value != '') {

							var chatboxData = value.split(/,/);

							for(i=0;i<chatboxData.length;i++) {
								var chatboxIds = chatboxData[i].split(/\|/);
								newActiveChatboxes[chatboxIds[0]] = chatboxIds[1];
							}
						}
						for (r in newActiveChatboxes) {
							if (newActiveChatboxes.hasOwnProperty(r)) {
								if (parseInt(newActiveChatboxes[r]) > 0) {
									totmessages += parseInt(newActiveChatboxes[r]);
								}
							}
						}
						jqcc.ccmobiletab.notify(totmessages);
					}
				}	
			}
		};
	})();
})(jqcc);