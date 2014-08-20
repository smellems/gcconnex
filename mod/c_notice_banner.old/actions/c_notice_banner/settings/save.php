<?php

				$log = fopen(dirname( __FILE__ ) . "/notice_banner.txt", 'w');
				fwrite($log, "start logging" . "\r\n" );
				fwrite($log, "do something??" . "\r\n" );
				fwrite($log, "end logging" . "\r\n" );
				fclose($log);


// system_message(elgg_echo('plugins:settings:asdfsave:ok', array($plugin_name)));
// forward(REFERER);