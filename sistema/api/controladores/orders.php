
<?php
require_once "../../../conexion.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
// registrar cliente = ventas
if ($_POST['action'] == 'createOrder') {
  $codcliente = $_POST['client']['idcliente'];
  $token = md5($_SESSION['idUser']);
  $usuarioId = $_SESSION['idUser'];
  $billTotal = $_POST['billTotal']['total'];
  $details = $_POST['details'];
  $date = date("Y-m-d h:i:s");
  $status = 1;
  $billHeaderSql = "INSERT INTO factura(fecha,usuario,codcliente,totalfactura,estado) VALUES ('$date','$usuarioId','$codcliente','$billTotal','$status')";
  $detailsSql = "";

  if ($conexion->query($billHeaderSql)) {
    $billingId = mysqli_insert_id($conexion);
  } else {
    mysqli_close($conexion);
    echo json_encode([
      'error' => $conexion->error
    ]);
    exit;
  }

  foreach ($details as $detail) {
    $codproducto = $detail['codproducto'];
    $cantidad = $detail['amount'];
    $precioTotal = $detail['total_price'];
    $detailsSql .= "INSERT INTO detallefactura(nofactura,codproducto,cantidad,precio_venta) VALUES ('$billingId','$codproducto','$cantidad','$precioTotal');";
  }
  $query_insert = mysqli_multi_query($conexion, $detailsSql);
  if ($query_insert) {
    echo json_encode([
      'id' => $billingId
    ]);
  } else {
    echo json_encode([
      'error' => "Error al guardar el detalle"
    ]);
  }

  mysqli_close($conexion);
  exit;
}
exit;
