<?php

elgg_register_event_handler('init', 'system', 'c_sensitive_info_msg_init');

function c_sensitive_info_msg_init() {

	$plugin_list = elgg_get_plugins('active', 1);

	// this is the famous loop within a loop
	foreach ($plugin_list as $plugin_form)
	{
		$filepath = elgg_get_plugins_path().$plugin_form['title'].'/views/default/forms/'.$plugin_form['title'];
		if (file_exists($filepath))
		{
			$dir = scandir($filepath);
			//print_r($dir);
			foreach ($dir as $form_file)
			{
				//elgg_log('cyu - plugin:'.$plugin['title'], 'NOTICE');
				if ( (strstr($form_file,'edit') || strstr($form_file,'save') || strstr($form_file, 'upload')) && (!strstr($form_file, '.old'))) 
				{
					//elgg_log('cyu - form_file:'.$form_file, 'NOTICE');
					$remove_php = explode('.',$form_file);
					//elgg_log('cyu - << replacing ...:'.'forms/'.$plugin_form['title'].'/'.$remove_php[0].' >>' , 'NOTICE');
					elgg_extend_view('forms/'.$plugin_form['title'].'/'.$remove_php[0], 'forms/save2', 100);
				}
			}
		}
	}

	// everything below are rebels
	elgg_extend_view('forms/photos/image/save', 'forms/save2', 100);
	elgg_extend_view('forms/photos/batch/edit', 'forms/save2', 100);
	//elgg_extend_view('forms/photos/batch/edit/image', 'forms/save2', 600);
	elgg_extend_view('forms/photos/album/save', 'forms/save2', 100);
	elgg_extend_view('forms/discussion/save', 'forms/save2', 100);
	elgg_extend_view('forms/file_tools/upload/multi', 'forms/save2', 100);
	elgg_extend_view('forms/file_tools/upload/zip', 'forms/save2', 100);
}
