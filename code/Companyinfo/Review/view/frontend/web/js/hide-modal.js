define(['jquery'], function($) {
	return function(data) {
		$('.hide-modal').on(data.event, function(event) {
			event.preventDefault();
			$('.modal__wrapper').hide();
		});
	}
});