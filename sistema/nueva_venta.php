<?php include_once "includes/header.php"; ?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h4 class="text-center">Nueva Venta</h4>
            <a href="#" id="btnCreateModal" class="btn btn-primary">
                <i class="fas fa-user-plus"></i> Seleccionar/Crear Cliente
            </a>
            <a href="#" id="btnProdutSelectionModal" class="btn btn-primary">
                <i class="fas fa-box"></i> Añadir Productos
            </a>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Cliente</th>
                        <th scope="col">Vendedor</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">
                            <div id="selectedClient">
                                Nombres: <label id="selectedClientName"></label></br>
                                Teléfono: <label id="selectedClientPhone"></label></br>
                                Dirección: <label id="selectedClientAddress"></label>
                            </div>
                        </th>
                        <td><?php echo $_SESSION['nombre']; ?></td>
                    </tr>
                </tbody>
            </table>
            <div class="row">
                <div class="table-responsive">
                    <table class="table" id="saleDetailTable">
                        <thead class="thead-dark">
                            <tr>
                                <th>Código</th>
                                <th>Descripción</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                                <th>Precio Total</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-8"></div>
                <div class="col-4">
                    <strong>Subtotal:</strong> $<label for="" id="subtotal"></label><br>
                    <strong>IGV/IVA:</strong> $<label for="" id="taxes"></label><br>
                    <strong>Total:</strong> $<label for="" id="total"></label>
                </div>
            </div>
            <div class="row float-right">
                <div id="billing_error" class="alert alert-danger" role="alert"></div>
                <div id="acciones_venta" class="form-group">
                    <a href="#" class="btn btn-danger" id="btn_anular_venta">Anular</a>
                    <a href="#" class="btn btn-primary" id="btn_facturar_venta">
                        <i class="fas fa-save"></i> Finalizar Venta
                    </a>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->


<?php include_once "includes/footer.php"; ?>