hideAlert('#error_alert');
hideAlert('#success_alert');
var form = $("#login_form");
form.submit(function (e) {
    e.preventDefault();
    $.ajax({
        type: form.attr('method'),
        url: form.attr('action'),
        data: form.serialize(),
        dataType: 'JSON',
        success: function (result) {
            hideAlert('#error_alert');
            showAlert('#success_alert', result.message);
            window.location.href = result.redirect;
        },
        error: function (request, status, error) {
            showAlert('#error_alert', request.responseJSON.error);
        }
    });
});