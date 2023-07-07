<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="login.html">Logout</a>
            </div>
        </div>
    </div>
</div>
<!-- Create/select client modal -->
<div class="modal fade" id="createClientModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form method="post" name="form_new_cliente_venta" id="form_new_cliente_venta" action="modal.php">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Crear cliente</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <div id="created_client_ok" class="alert alert-success" role="alert"></div>
                            <div id="created_client_error" class="alert alert-danger" role="alert"></div>
                            <input type="hidden" name="action" value="addCliente">
                            <input type="hidden" id="idcliente" value="1" name="idcliente" required>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Dni</label>
                                        <input type="number" name="dni_cliente" id="dni_cliente" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Nombre</label>
                                        <input type="text" name="nom_cliente" id="nom_cliente" class="form-control" disabled required>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Teléfono</label>
                                        <input type="number" name="tel_cliente" id="tel_cliente" class="form-control" disabled required>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Dirreción</label>
                                        <input type="text" name="dir_cliente" id="dir_cliente" class="form-control" disabled required>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Products Selecction modal -->
<div class="modal fade bd-example-modal-lg" id="productSelectionModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <form method="post" name="addProductForm" id="addProductForm" action="modal.php">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Seleccionar producto</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Código del producto</label>
                                        <input class="form-control" type="number" name="txt_cod_producto" id="txt_cod_producto">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Cantidad</label>
                                        <input class="form-control" type="text" name="txt_cant_producto" id="txt_cant_producto" value="0" min="1" disabled>
                                    </div>
                                </div>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Nombre</th>
                                            <th scope="col">Existencias</th>
                                            <th scope="col">Precio unitario</th>
                                            <th scope="col">Precio total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <label id="txt_descripcion">-</label>
                                            </td>
                                            <td>
                                                <label id="txt_existencia">-</label>
                                            </td>
                                            <td>
                                                <label id="txt_precio" class="textright">0.00</label>
                                            </td>
                                            <td>
                                                <label id="txt_precio_total" class="txtright">0.00</label>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <i id="productAddedOK" class="fas fa-check" style="color: green;"></i>
                    <button type="submit" class="btn btn-primary">Añadir</button>
                    <button type="button" id="btnCloseProductSelecctionModal" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Cerrar</button>
                </div>
            </div>
        </div>
    </form>
</div>