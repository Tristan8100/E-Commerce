console.log("ajax.js loaded");

function ajaxFunction(objectData, successCallback, failCallback) {

    if (objectData.method && objectData.method.toUpperCase() !== 'GET' && objectData.csrfToken) {
        objectData.data._token = objectData.csrfToken;
    }

    $.ajax({
        url: objectData.url,
        type: objectData.method || 'GET',
        data: objectData.data || {},
        dataType: objectData.dataType || 'json',
        beforeSend: function() {
            console.log("Request started...");
        },
        success: function(response) {
            if (typeof successCallback === "function") {
                successCallback(response);
            }
        },
        error: function(xhr, status, error) {
            failCallback(xhr, status, error);

        },
        complete: function() {
            console.log("Request completed.");
        }
    });
}