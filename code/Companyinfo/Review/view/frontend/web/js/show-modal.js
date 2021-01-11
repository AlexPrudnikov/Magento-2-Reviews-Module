define(['jquery'], function($){
    return function(data) {
	    $('#show-modal').on(data.event, function(event) {
		    event.preventDefault();
		    $('.modal__wrapper').show();
		    $('.input-text').focus();
		    
		    let form = $('.modal__wrapper').find('#form_id');
		    form.find('.submit.primary').prop('disabled', false);
    	});
    }
});