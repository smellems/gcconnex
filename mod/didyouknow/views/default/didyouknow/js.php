
$(document).ready(function(){
	$('#dyk-refresh').click(function(){
		$('#dyk-tip').fadeTo(400, 0, function(){
			$(this).slideUp(400, function(){
				$(this).load(location.href+" #dyk-tip", function(){
					$(this).slideDown();
					$(this).fadeTo(400, 1);
				});
			});
		});
	});
});
