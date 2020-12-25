define(['jquery',
        'Magento_Customer/js/customer-data',
        'Magento_Ui/js/view/messages',
        'mage/translate'
       ], function($, customerData){
       return function(data) {
          $("#form_id").submit(function(){
          var value = $("textarea[name='review']").val();

          if($(this).validation().valid()) {
             $.ajax({
              url: $(this).attr('action'),
              data: {review:value, id:data.id},
              type: "POST",
              showLoader: true,
              cache: false,
              success: function(response){
                  updateTable(data.url);
                  successMessage();
                 }
             });
          }
        return false;
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
        $('.modal__wrapper').hide();
        $('#form_id')[0].reset();
      }
    });
  }

  function successMessage () {
    setTimeout(function (){
      var msg = $.mage.__('Thank you for your review, it will be published after being checked by a moderator!.');
        customerData.set('messages', {
          messages: [{
            type: 'success',
            text:msg
          }]
      });    
    }, 4000);
  }
});