var skeletonId = 'skeleton';
var contentId = 'content';
var skipCounter = 0;
var takeAmount = 10;


function getRequests(mode) {
  var functionsOnSuccess = [
    [successFunction, ['response']]
  ];
  ajax('/connect-request', 'GET',functionsOnSuccess);
}

function getMoreRequests(mode) {
  // Optional: Depends on how you handle the "Load more"-Functionality
  // your code here...
}

function getStats() {
  var functionsOnSuccess = [
    [successStatsFunction, ['response']]
  ];
  ajax('/stats', 'GET',functionsOnSuccess);
}

function getReceivedRequests() {
  var functionsOnSuccess = [
    [successFunction, ['response']]
  ];
  ajax('/received-requests', 'GET',functionsOnSuccess);
}

function getConnections() {
  var functionsOnSuccess = [
    [successFunction, ['response']]
  ];
  ajax('/connections', 'GET',functionsOnSuccess);
}

function getMoreConnections() {
  // Optional: Depends on how you handle the "Load more"-Functionality
  // your code here...
}

function getConnectionsInCommon(userId, connectionId) {
  // your code here...
}

function getMoreConnectionsInCommon(userId, connectionId) {
  // Optional: Depends on how you handle the "Load more"-Functionality
  // your code here...
}

function getSuggestions() {
  var functionsOnSuccess = [
    [successFunction, ['response']]
  ];
  
  ajax('/suggestions', 'GET',functionsOnSuccess);
}

function getMoreSuggestions() {
  var functionsOnSuccess = [
    [successPaginationFunction, ['response','suggestion_content']]
  ];
  var page = $('#load_more_btn').attr("data-page");
  var form = ajaxForm([
    ['page', page],
  ]);
  ajax('/more-suggestions', 'POST',functionsOnSuccess,form);
}

function sendRequest(suggestionId) {
  var functionsOnSuccess = [
    [successSendRequest, ['response']],
  ];

  var form = ajaxForm([
    ['suggestionId', suggestionId],
  ]);
  ajax('/connect-request', 'POST',functionsOnSuccess,form);
}

function deleteRequest(requestId) {
  var functionsOnSuccess = [
    [successDeleteRequest, ['response']],
  ];

  var form = ajaxForm([
    ['requestId', requestId],
  ]);
  ajax('/connect-request/'+requestId, 'DELETE',functionsOnSuccess,form);
}

function acceptRequest(requestId) {
  var functionsOnSuccess = [
    [successUpdateRequest, ['response']],
  ];

  var form = ajaxForm([
    ['requestId', requestId],
  ]);
  ajax('/connect-request/'+requestId, 'PUT',functionsOnSuccess,form);
}

function removeConnection(connectionId) {
  var functionsOnSuccess = [
    [successDeleteConnection, ['response']],
  ];

  var form = ajaxForm([
    ['connectionId', connectionId],
  ]);
  ajax('/connections/'+connectionId, 'DELETE',functionsOnSuccess,form);
}

$(function () {
  getStats();
  getSuggestions();
});