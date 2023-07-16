function ajaxForm(formItems) {
  var form = new FormData();
  formItems.forEach(formItem => {
    form.append(formItem[0], formItem[1]);
  });
  return form;
}



/**
 * 
 * @param {*} url route
 * @param {*} method POST or GET 
 * @param {*} functionsOnSuccess Array of functions that should be called after ajax
 * @param {*} form for POST request
 */
function ajax(url, method, functionsOnSuccess, form) {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  })

  if (typeof form === 'undefined') {
    form = new FormData;
  }

  if (typeof functionsOnSuccess === 'undefined') {
    functionsOnSuccess = [];
  }
  $.ajax({
    beforeSend: skeletonContent(),
    url: url,
    type: method,
    async: true,
    data: form,
    processData: false,
    contentType: false,
    dataType: 'json',
    error: function(xhr, textStatus, error) {
      console.log(xhr.responseText);
      console.log(xhr.statusText);
      console.log(textStatus);
      console.log(error);
    },
    success: function(response) {
      for (var j = 0; j < functionsOnSuccess.length; j++) {
        for (var i = 0; i < functionsOnSuccess[j][1].length; i++) {
          if (functionsOnSuccess[j][1][i] == "response") {
            functionsOnSuccess[j][1][i] = response;
          }
        }
        functionsOnSuccess[j][0].apply(this, functionsOnSuccess[j][1]);
      }
      skeletonContent('hide')
    }
  });
}
function skeletonContent(skeleton='show')
{
  if(skeleton=='show')
  {
    $('#'+skeletonId).removeClass('d-none');
    $('#'+contentId).addClass('d-none');
  }
  else
  {
    $('#'+skeletonId).addClass('d-none');
    $('#'+contentId).removeClass('d-none');
  }
}
function successStatsFunction(response)
{
  $('#get_suggestions_btn').html("Suggestions ("+response['suggestions']+")");
  $('#get_sent_requests_btn').html("Sent Requests ("+response['sent_requests']+")");
  $('#get_received_requests_btn').html("Received Requests ("+response['recieved_requests']+")");
  $('#get_connections_btn').html("Connections ("+response['connections']+")");
}
function successFunction(response) {
  $('#content').html(response['content']);
}
function successSendRequest(response){
  if(response['status'])
  {
    $('#create_request_btn_'+response['id']).html('Request Sent');
    getStats();
    getSuggestions();
  }
  else
  {
    alert(response['message']);
  }
}
function successDeleteRequest(response){
  if(response['status'])
  {
    getStats();
    getRequests();
  }
  else
  {
    alert(response['message']);
  }
}
function successUpdateRequest(response){
  if(response['status'])
  {
    getStats();
    getReceivedRequests();
  }
  else
  {
    alert(response['message']);
  }
}
function successDeleteConnection(response){
  if(response['status'])
  {
    getStats();
    getConnections();
  }
  else
  {
    alert(response['message']);
  }
}