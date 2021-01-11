define(['jquery',
        'Magento_Customer/js/customer-data',
        'Magento_Ui/js/view/messages',
        'mage/translate'
       ], function($, customerData){
       return function(data) {
         	$('.review__menu-list-item-btn-delete').on(data.event, function(event) {

			 event.preventDefault();
			 $.ajax({
              url: $(this).attr('href'),
              type: "GET",
              showLoader: true,
              cache: false,
              success: function(response){
                  updateTable(data.url, response.page);
                 }
             });
		    });
    }

    function updateTable(url, pageNumber = 1) {
    let select = document.querySelector('#limiter');
    let pageLimit = select ? select.options[select.selectedIndex].text : 5;

    $.ajax({
      type:"GET", 
      url: `${url}?limit=${pageLimit}&p=${pageNumber}`,
      showLoader: true,
      success: function(data) {
        $("#reviewList").html(data);
        $('.pager').first().trigger('contentUpdated');
      }
    });
  }

});