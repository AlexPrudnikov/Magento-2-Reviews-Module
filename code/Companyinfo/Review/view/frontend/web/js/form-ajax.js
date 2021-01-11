define(['jquery',
        'Magento_Customer/js/customer-data',
        'Magento_Ui/js/view/messages',
        'mage/translate'
       ], function($, customerData){
       return function(data) {
          $("#form_id").submit(function(){
          var value = $("textarea[name='review']").val();
          var idReview = parseInt($(this).attr('action').split('=')[1]);

          if($(this).validation().valid()) {
             $.ajax({
              url: $(this).attr('action'),
              data: {review:value, idReview: idReview},
              type: "POST",
              showLoader: true,
              cache: false,
              success: function(response){
                  updateTable(data.url, data.action, response.page);
                  successMessage(response.message);
                 }
             });
          }
        return false;
        });
    }

    function updateTable(url, action, pageNumber = 1) {
    let select = document.querySelector('#limiter');
    let pageLimit = select ? select.options[select.selectedIndex].text : 5;

    $.ajax({
      type:"GET", 
      url: `${url}?limit=${pageLimit}&p=${pageNumber}`,
      showLoader: true,
      success: function(response) {
        $("#reviewList").html(response);
        $('.pager').first().trigger('contentUpdated');
        $('.modal__wrapper').hide();
        $('#form_id')[0].reset();

        resetForm(action);
      }
    });
  }

  function successMessage (message) {
    setTimeout(function (){
      var msg = $.mage.__(message);
        customerData.set('messages', {
          messages: [{
            type: 'success',
            text:msg
          }]
      });    
    }, 4000);
  }

  function resetForm(action) {
    let form = $('.modal__wrapper').find('#form_id');
    form.attr('action', action);
    form.find('.submit.primary').html('Submit');
  }

});