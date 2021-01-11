define(['jquery',
        'Magento_Customer/js/customer-data',
        'Magento_Ui/js/view/messages',
        'mage/translate'
       ], function($, customerData){
       return function(data) {
       	let oldReview;
       	let form = $('.modal__wrapper').find('#form_id');
       	let button = form.find('.submit.primary');
       	button.prop('disabled', true);


       	$('.review__menu-list-item-btn-edit').on(data.event, function(event) {
       		event.preventDefault();

       		let textarea = form.find('textarea');
     		let idReview = parseInt($(this).attr('href').split('=')[1]);
       		let review = $(`#${idReview}`).text();
       		oldReview = review;
       		textarea.val(review);
       		form.attr('action', $(this).attr('href'));

       		changeNameButton(form);
       		show();
		    focus();
       	});

       	$('#form_id').on('keyup', function(event) {
       		if($(this).is(':visible')) {
       			let newReview = getNewReview(form);

       			if(oldReview !== newReview) {
       				button.prop('disabled', false);
       			} else {
       				button.prop('disabled', true);
       			}
       		}
       	});
    }

    function getNewReview(form) {
       	let textarea = form.find('textarea');
       	let newReview = textarea.val();
       	return newReview;
    }

    function changeNameButton(form) {
    	form.find('.submit.primary').html('Save');
    }

    function focus() {
    	$('.input-text').focus();
    }

    function show() {
    	$('.modal__wrapper').show();
    }
});