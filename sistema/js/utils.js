
function hideAlert(id) {
    $(id).hide();
}

function showAlert(id, message) {
    if (message) {
        $(id).text(message);
    }
    $(id).show();
}

function serializeArrayToJson(serializeArray) {
    var indexedArray = {};

    $.map(serializeArray, function (n, i) {
        indexedArray[n['name']] = n['value'];
    });

    return indexedArray;
}