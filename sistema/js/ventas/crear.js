var selectedClient = null;
var configuration = {
    igv:0
};
var billTotal = {
    subtotal: 0,
    taxes: 0,
    total: 0
};
hideAlert('#selectedClient');
hideAlert('#productAddedOK');
hideAlert('#billing_error');
function openProductsSelectionModal() {
    hideAlert('#created_client_ok');
    hideAlert('#created_client_error');
    $('#productSelectionModal').modal('show');
}

function closeProductsSelectionModal() {
    $('#productSelectionModal').modal('hide');
}

$("#btnProdutSelectionModal").click(function () {
    openProductsSelectionModal();
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
            hideAlert('#created_client_ok');
            showAlert('#created_client_error', result.message);
            closeCreateModal()
        },
        error: function (request, status, error) {
            showAlert('#created_client_error', request.responseJSON.error);
        }
    });
});

// Traer configuración del IGV/IVA
function getConfiguration() {
    $.ajax({
        url: './api/controladores/configuracion.php',
        type: 'GET',
        dataType: 'JSON',
        success: function (response) {
            if (response.id) {
                configuration.igv = parseFloat(response.igv) 
            } else {
                showAlert("#billing_error", "No se pudo cargar los datos del IGV/IVA")
            }
        },
        error: function (error) {

        }
    });
}
getConfiguration();

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
                $('.btn_new_cliente').slideDown();
                $('#nom_cliente').removeAttr('disabled');
                $('#tel_cliente').removeAttr('disabled');
                $('#dir_cliente').removeAttr('disabled');
            } else {
                selectedClient = $.parseJSON(response);
                $('#idcliente').val(selectedClient.idcliente);
                $('#nom_cliente').val(selectedClient.nombre);
                $('#tel_cliente').val(selectedClient.telefono);
                $('#dir_cliente').val(selectedClient.direccion);
                // ocultar boton Agregar
                $('.btn_new_cliente').slideUp();

                // Bloque campos
                $('#nom_cliente').attr('disabled', 'disabled');
                $('#tel_cliente').attr('disabled', 'disabled');
                $('#dir_cliente').attr('disabled', 'disabled');
                // ocultar boto Guardar
                $('#div_registro_cliente').slideUp();
                showAlert('#selectedClient');
            }
        },
        error: function (error) {

        }
    });

});
// buscar producto = Ventas
var productToAdd = null;
var shoppingCartToAdd = [];
$('#txt_cod_producto').keyup(function (e) {
    e.preventDefault();
    var productos = $(this).val();
    if (productos == "") {
        $('#txt_descripcion').html('-');
        $('#txt_existencia').html('-');
        $('#txt_cant_producto').val('0');
        $('#txt_precio').html('0.00');
        $('#txt_precio_total').html('0.00');

        //Bloquear Cantidad
        $('#txt_cant_producto').attr('disabled', 'disabled');
        // Ocultar Boto Agregar
        $('#add_product_venta').slideUp();
    }
    var action = 'infoProducto';
    if (productos != '') {
        $.ajax({
            url: 'modal.php',
            type: "POST",
            async: true,
            data: { action: action, producto: productos },
            success: function (response) {
                if (response == 0) {
                    $('#txt_descripcion').html('-');
                    $('#txt_existencia').html('-');
                    $('#txt_cant_producto').val('0');
                    $('#txt_precio').html('0.00');
                    $('#txt_precio_total').html('0.00');
                    //Bloquear Cantidad
                    $('#txt_cant_producto').attr('disabled', 'disabled');
                    // Ocultar Boto Agregar
                    $('#add_product_venta').slideUp();
                } else {
                    productToAdd = JSON.parse(response);
                    $('#txt_descripcion').html(productToAdd.descripcion);
                    $('#txt_existencia').html(productToAdd.existencia);
                    $('#txt_cant_producto').val('1');
                    $('#txt_precio').html(productToAdd.precio);
                    $('#txt_precio_total').html(productToAdd.precio);
                    // Activar Cantidad
                    $('#txt_cant_producto').removeAttr('disabled');
                    // Mostar boton Agregar
                    $('#add_product_venta').slideDown();

                }
            },
            error: function (error) {
            }
        });
        $('#txt_descripcion').html('-');
        $('#txt_existencia').html('-');
        $('#txt_cant_producto').val('0');
        $('#txt_precio').html('0.00');
        $('#txt_precio_total').html('0.00');

        //Bloquear Cantidad
        $('#txt_cant_producto').attr('disabled', 'disabled');
        // Ocultar Boto Agregar
        $('#add_product_venta').slideUp();

    }
});
var productSelecctionForm = $("#addProductForm");
productSelecctionForm.submit(function (e) {
    e.preventDefault();
    var selectedProduct = serializeArrayToJson(productSelecctionForm.serializeArray());
    productToAdd.amount = parseInt(selectedProduct.txt_cant_producto);
    productToAdd.total_price = parseFloat(selectedProduct.txt_cant_producto) * parseFloat(productToAdd.precio);
    addToCart(productToAdd);
});

function removeItemFromCart(productIndex) {
    shoppingCartToAdd.splice(productIndex, 1);
    updateSaleDetail();
}

function addToCart(productToAdd) {
    var existsInCart = shoppingCartToAdd.findIndex(element => {
        return productToAdd.codproducto == element.codproducto;
    })
    if (existsInCart == -1) {
        shoppingCartToAdd.push(productToAdd);
    } else {
        shoppingCartToAdd[existsInCart].amount = productToAdd.amount
    }
    showAlert('#productAddedOK');
    setTimeout(function () {
        hideAlert("#productAddedOK");
    }, 1000)
    updateSaleDetail();
}

var saleDetailDataTable = $('#saleDetailTable').DataTable({
    columns: [
        { "data": "code" },
        { "data": "description" },
        { "data": "amount" },
        { "data": "unit_price" },
        { "data": "total_price" },
        { "data": "actions" },
    ]
})
function updateSaleDetail() {
    billTotal.total = 0
    billTotal.subtotal = 0
    billTotal.taxes = 0
    saleDetailDataTable.clear();
    var formatedShoppingCat = shoppingCartToAdd.map((product, index) => {
        billTotal.total += product.total_price;
        console.log(billTotal.total);
        return {
            code: product.codproducto,
            description: product.descripcion,
            amount: product.amount,
            unit_price: product.precio,
            total_price: product.total_price,
            actions: '<button type="button" class="btn btn-danger" onclick="removeItemFromCart(' + index + ')"><i class="fas fa-trash"></i> Eliminar</button>'
        }
    })
    console.log(billTotal);
    console.log(configuration.igv);
    billTotal.taxes = billTotal.total * (configuration.igv / 100);
    billTotal.subtotal = billTotal.total - billTotal.taxes;
    $('#subtotal').text(billTotal.subtotal.toFixed(2));
    $('#taxes').text(billTotal.taxes.toFixed(2));
    $('#total').text(billTotal.total.toFixed(2));
    saleDetailDataTable.rows.add(formatedShoppingCat).draw();
    viewProcesar();
}

// mostrar/ ocultar boton Procesar
function viewProcesar() {
    if (shoppingCartToAdd.length > 0) {
        $('#btn_facturar_venta').show();
        $('#btn_anular_venta').show();
    } else {
        $('#btn_facturar_venta').hide();
        $('#btn_anular_venta').hide();
    }
}
// Generar PDF
function generarPDF(cliente, factura) {
    url = 'factura/generaFactura.php?cl=' + cliente + '&f=' + factura;
    window.open(url, '_blank');
}

// facturar venta
$('#btn_facturar_venta').click(function (e) {
    e.preventDefault();
    if (!selectedClient) {
        showAlert("#billing_error", "Debe seleccionar el cliente antes de finalizar la venta");
        return;
    }

    if (shoppingCartToAdd.length) {
        var action = 'createOrder';
        $.ajax({
            url: './api/controladores/orders.php',
            type: 'POST',
            async: true,
            dataType: 'JSON',
            data: { action: action, client: selectedClient, details: shoppingCartToAdd, billTotal },
            success: function (response) {
                if (response.id) {
                    $("#btn_facturar_venta").text("Generando pdf ...")
                    setTimeout(function() {
                        generarPDF(selectedClient.idcliente, response.id);
                        location.reload();
                    }, 2000)
                } else {
                    console.log('no hay dato');
                }
            },
            error: function (error) {

            }
        });
    }
});