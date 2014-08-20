//<script>

	elgg.provide('elgg.places');
	elgg.places.interface = function() {
		$('[data-place][data-status]').live('click', function(e) {

			e.preventDefault();
			var $elem = $(this);
			console.log($elem.data('status'));
			if ($elem.data('status') === 'on') {
				elgg.action($elem.data('off'), {
					data: $elem.data(),
					dataType: 'json',
					beforeSend: function() {
						$('body').addClass('places-state-loading');
					},
					complete: function() {
						$('body').removeClass('places-state-loading');
					},
					success: function(data) {
						if (data.status >= 0) {
							var guid = $elem.data('guid');
							var counter = $elem.data('counter');
							var count = $elem.data('count');

							$('[data-place][data-status][data-guid="' + guid + '"][data-counter="' + counter + '"]').attr({
								'data-count': parseInt(count) - 1,
								'href': $elem.data('on'),
								'data-status': 'off'
							}).html($elem.data('onText')).data('status', 'off');
						}
					}
				});
			} else {
				elgg.action($elem.data('on'), {
					data: $elem.data(),
					dataType: 'json',
					beforeSend: function() {
						$('body').addClass('places-state-loading');
					},
					complete: function() {
						$('body').removeClass('places-state-loading');
					},
					success: function(data) {
						if (data.status >= 0) {
							var guid = $elem.data('guid');
							var counter = $elem.data('counter');
							var count = $elem.data('count');

							$('[data-place][data-status][data-guid="' + guid + '"][data-counter="' + counter + '"]').attr({
								'data-count': parseInt(count) + 1,
								'href': $elem.data('off'),
								'data-status': 'on'
							}).html($elem.data('offText')).data('status', 'on');
						}
					}
				});
			}
		});
	};



	elgg.register_hook_handler('init', 'system', elgg.places.interface);