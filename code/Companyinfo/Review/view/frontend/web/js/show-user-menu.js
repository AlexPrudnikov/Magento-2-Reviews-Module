define(['jquery',
        'Magento_Customer/js/customer-data',
        'Magento_Ui/js/view/messages',
        'mage/translate'
       ], function($, customerData){
       return function(data) {
          $('.review__btn').on(data.event, function(event) {
          event.preventDefault();
     
          let menu = $(this).parent('.review__wrapper-btn')
                 .parent('.review__wrapper')
                 .find('.review__menu-list')
                 .show();

          menu.mouseleave(() => menu.hide());

      });
    }
});