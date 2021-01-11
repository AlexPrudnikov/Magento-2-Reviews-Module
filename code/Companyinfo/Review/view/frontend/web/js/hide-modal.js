define(['jquery'], function($) {
	return function(data) {
		$('.hide-modal').on(data.event, function(event) {
			event.preventDefault();
			$('.modal__wrapper').hide();
			$('#form_id')[0].reset();

			let form = $('.modal__wrapper').find('#form_id');
			form.find('.submit.primary').prop('disabled', true);
			form.attr('action', data.action);
			form.find('.submit.primary').html('Submit');
		});
	}
});