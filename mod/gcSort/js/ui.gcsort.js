elgg.provide('ui.gcsort');

/*function gcsort() {
		var url = window.location.href;
		alert('gcsort');
		if (window.location.search.length) {
			url = url.substring(0, url.indexOf('?'));
		}
		url += '?sort=' + $(this).val();
		elgg.forward(url);
}*/

ui.gcsort.init = function() {
	$('#gcsort-selector').change(function() {
		var url = window.location.href;
		
		if (window.location.search.length) {
			url = url.substring(0, url.indexOf('?'));
		}
		url += '?sort=' + $(this).val();
		elgg.forward(url);
	});
};

elgg.register_hook_handler('init', 'system', ui.gcsort.init);