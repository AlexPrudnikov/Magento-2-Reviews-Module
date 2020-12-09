define(['jquery'], function($){
 return function(data) {
    $(".item a").on('click', function(event) {
      event.preventDefault();

      let url = event.currentTarget.href;
      let page = getRequestParam(url, 'p');
      let limit = getPageLimit();

      updateTable(limit, page, data.url);
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

  function getRequestParam(href, param) {
    let url = new URL(href);
    let data = url.searchParams.get(param);
    return data;  
  }

});


