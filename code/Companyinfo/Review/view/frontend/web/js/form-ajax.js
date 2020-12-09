define(['jquery'], function($){
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
                  console.log(response);
                  updateTable(data.url);
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
      }
    });
  }

});