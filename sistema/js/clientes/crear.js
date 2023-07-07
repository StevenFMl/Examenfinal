function openCreateModal() {
    hideAlert('#created_client_ok');
    hideAlert('#created_client_error');
    $('#createClientModal').modal('show');
}

function closeCreateModal() {
    $('#createClientModal').modal('hide');
}

$("#btnCreateModal").click(function () {
    openCreateModal();
});

var form = $("#form_new_cliente_venta");
form.submit(function (e) {
    e.preventDefault();
    $.ajax({
        type: form.attr('method'),
        url: form.attr('action'),
        data: form.serialize(),
        dataType: 'JSON',
        success: function (result) {
            console.log(result);
            hideAlert('#created_client_ok');
            showAlert('#created_client_error', result.message);
            closeCreateModal()
        },
        error: function (request, status, error) {
            showAlert('#created_client_error', request.responseJSON.error);
        }
    });
});

// buscar Cliente
$('#dni_cliente').keyup(function (e) {
    e.preventDefault();
    var cl = $(this).val();
    var action = 'searchCliente';
    $.ajax({
        url: 'modal.php',
        type: "POST",
        async: true,
        data: { action: action, cliente: cl },
        success: function (response) {
            if (response == 0) {
                $('#idcliente').val('');
                $('#nom_cliente').val('');
                $('#tel_cliente').val('');
                $('#dir_cliente').val('');
                // mostar boton agregar
                $('#nom_cliente').removeAttr('disabled');
                $('#tel_cliente').removeAttr('disabled');
                $('#dir_cliente').removeAttr('disabled');
            } else {
                var data = $.parseJSON(response);
                $('#idcliente').val(data.idcliente);
                $('#nom_cliente').val(data.nombre);
                $('#tel_cliente').val(data.telefono);
                $('#dir_cliente').val(data.direccion);
                // ocultar boton Agregar

                // Bloque campos
                $('#nom_cliente').attr('disabled', 'disabled');
                $('#tel_cliente').attr('disabled', 'disabled');
                $('#dir_cliente').attr('disabled', 'disabled');
                // ocultar boto Guardar
                $('#div_registro_cliente').slideUp();
                $("#selectedClientName").text(`${data.nombre}`)
                $("#selectedClientPhone").text(`${data.telefono}`)
                $("#selectedClientAddress").text(`${data.direccion}`)
            }
        },
        error: function (error) {

        }
    });

});


// // crear cliente = Ventas
// $('#form_new_cliente_venta').submit(function(e) {
//     e.preventDefault();
//     $.ajax({
//       url: 'modal.php',
//       type: "POST",
//       async: true,
//       data: $('#form_new_cliente_venta').serialize(),
//       success: function(response) {
//         if (response  != 0) {
//           // Agregar id a input hidden
//           $('#idcliente').val(response);
//           //bloque campos
//           $('#nom_cliente').attr('disabled','disabled');
//           $('#tel_cliente').attr('disabled','disabled');
//           $('#dir_cliente').attr('disabled','disabled');
//           // ocultar boton Agregar
//           $('.btn_new_cliente').slideUp();
//           //ocultar boton Guardar
//           $('#div_registro_cliente').slideDown();
//         }
//       },
//       error: function(error) {
//       }
//     });
//   });
