function validateSession() {
    $.ajax({
        type: "GET",
        url: './api/controladores/validate.php',
        dataType: 'JSON',
        error: function (request, status, error) {
            window.location.href = request.responseJSON.redirect;
        }
    });
}

$(document).ready(function () {
    validateSession();
})