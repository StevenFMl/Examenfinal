<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$alert = '';
session_start();
if (!empty($_SESSION['active'])) {
  echo json_encode([
    'message' => 'Bienvenido ' . $_SESSION['nombre'] . " redireccionando ...",
    "redirect" => 'sistema/index.php'
  ]);
} else {
  if (!empty($_POST)) {
    if (empty($_POST['usuario']) || empty($_POST['clave'])) {
      http_response_code(400);
      echo json_encode([
        'error' => 'Ingrese usuario y contraseña'
      ]);
    } else {
      require_once "../../../conexion.php";
      $user = mysqli_real_escape_string($conexion, $_POST['usuario']);
      $clave = md5(mysqli_real_escape_string($conexion, $_POST['clave']));
      $query = mysqli_query($conexion, "SELECT u.idusuario, u.nombre, u.correo,u.usuario,r.idrol,r.rol FROM usuario u INNER JOIN rol r ON u.rol = r.idrol WHERE u.usuario = '$user' AND u.clave = '$clave'");
      mysqli_close($conexion);
      $resultado = mysqli_num_rows($query);
      if ($resultado > 0) {
        $dato = mysqli_fetch_array($query);
        $_SESSION['active'] = true;
        $_SESSION['idUser'] = $dato['idusuario'];
        $_SESSION['nombre'] = $dato['nombre'];
        $_SESSION['email'] = $dato['correo'];
        $_SESSION['user'] = $dato['usuario'];
        $_SESSION['rol'] = $dato['idrol'];
        $_SESSION['rol_name'] = $dato['rol'];
        echo json_encode([
          'message' => 'Bienvenido ' . $dato['nombre'] . " redireccionando ...",
          "redirect" => 'sistema/index.php'
        ]);
      } else {
        http_response_code(400);
        echo json_encode([
          'error' => 'Usuario o Contraseña Incorrecta'
        ]);
        session_destroy();
      }
    }
  } else {
    http_response_code(400);
    echo json_encode([
      'error' => 'Ingrese usuario y contraseña'
    ]);
  }
}
