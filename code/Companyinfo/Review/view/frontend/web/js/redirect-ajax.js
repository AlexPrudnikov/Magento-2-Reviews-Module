define(['jquery'], function($){
 return function(data) {
    $("#limiter").on(data.event, function(event) {
      let limit = getPageLimit();
      updateTable(limit, 1, data.url);
    });
}
  function updateTable(pageLimit, pageNumber, url) {
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

  function getPageLimit() {
    let select = document.querySelector('#limiter');
    let limit = select.options[select.selectedIndex].text;
    return limit;
  }

});


