window.addEvent('domready', function(){

	$$('.progress').each(function(element){

		element.tween(
			'width',
			element.getParent('.assignment').getSize().x
				* (element.get('data-width') / 100)
		);
	});

	$('menu').getElements('input[type="checkbox"], select').addEvent(
		'change',
		function(element){

			$('menu').submit();
		}
	);
});