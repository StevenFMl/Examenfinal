
<?php
require_once "../../../conexion.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
// Obtener configuración
$data = null;
$query = mysqli_query($conexion, "SELECT * FROM configuracion LIMIT 1");

$result = mysqli_num_rows($query);
if ($result > 0) {
    $data = mysqli_fetch_assoc($query);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
} else {
    http_response_code(500);
    echo json_encode([
        'error' => 'Error al obtener configuración'
    ]);
}
exit;
