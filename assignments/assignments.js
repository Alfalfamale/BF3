window.addEvent('domready', function(){

	$$('.progress').each(function(element){

		element.tween(
			'width',
			element.getParent('.assignment').getSize().x
				* (element.get('data-width') / 100)
		);
	});
});