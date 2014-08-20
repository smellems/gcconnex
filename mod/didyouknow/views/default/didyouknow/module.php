
<div class="elgg-module elgg-module-aside">
	<div class="elgg-head">
		<h3>
			<?php echo elgg_echo('didyouknow:title'); ?>
			<span class="dyk-icon dyk-icon-refresh float-alt" id="dyk-refresh" title="<?php echo elgg_echo('didyouknow:refresh'); ?>"></span>
		</h3>
	</div>
	<div class="elgg-body" id="dyk-tip">
		<?php

			$max = 4;
			if(!isset($_SESSION['didyouknow'])){
				$_SESSION['didyouknow'] = mt_rand(0,5);
			}else{
				if($_SESSION['didyouknow'] >= $max){
					$_SESSION['didyouknow'] = 0;
				}else{
					$_SESSION['didyouknow']++;
				}
			}

			$output = '';
			if(elgg_get_context() == 'event_calendar'){
				$output = elgg_echo('didyouknow:event_calendar:' . $_SESSION['didyouknow']);
			}
			if(elgg_get_context() == 'groups'){
				$output = elgg_echo('didyouknow:groups:' . $_SESSION['didyouknow']);
			}
			echo $output;
		?>
	</div>
</div>
