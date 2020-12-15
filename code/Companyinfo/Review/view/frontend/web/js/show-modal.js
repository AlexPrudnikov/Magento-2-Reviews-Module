define(['jquery'], function($){
    return function(data) {
	    $('#show-modal').on(data.event, function(event) {
		    event.preventDefault();
		    $('.modal__wrapper').show();
    	});
    }
});