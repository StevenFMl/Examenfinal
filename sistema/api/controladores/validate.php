<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$alert = '';
session_start();
if (!empty($_SESSION['active'])) {
  echo json_encode([
    'message' => 'Bienvenido ' . $_SESSION['nombre'] . " redireccionando ...",
  ]);
} else {
  http_response_code(401);
  echo json_encode([
    'error' => 'No autorizado',
    "redirect" => '../index.php'
  ]);
}
