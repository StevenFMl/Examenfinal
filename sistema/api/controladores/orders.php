
<?php
require_once "../../../conexion.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
// registrar cliente = ventas
if ($_POST['action'] == 'createOrder') {
  $codcliente = $_POST['codcliente'];
  $token = md5($_SESSION['idUser']);
  $details = $_POST['details'];
  $detailsSql = "";
  foreach ($details as $detail) {
    $codproducto = $detail['codproducto'];
    $cantidad = $detail['amount'];
    $detailsSql .= "CALL add_detalle_temp ($codproducto,$cantidad,'$token');";
  }

  $query_insert = mysqli_multi_query($conexion, $detailsSql);
  if ($query_insert) {
    $codCliente = mysqli_insert_id($conexion);
    $msg = $codCliente;
  } else {
    $msg = 'error';
  }

  mysqli_close($conexion);
  echo json_encode([
    'id' => $msg
  ]);
  exit;
}
exit;
