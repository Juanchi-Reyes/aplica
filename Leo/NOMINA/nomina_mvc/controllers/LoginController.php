<?php
// controllers/LoginController.php
require_once __DIR__ . '/../config/conexion.php';

$mensaje_error = "";

// Verificamos si se envió el formulario
if (isset($_POST['btn_login'])) {
    $cedula = trim($_POST['cedula']);
    $password = $_POST['password'];

    // Buscamos al usuario por su cédula
    $sql = "SELECT id_empleado, cedula, password, rol FROM empleados WHERE cedula = ?";
    $stmt = mysqli_prepare($conexion, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $cedula);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);

        // Si el usuario existe
        if ($fila = mysqli_fetch_assoc($resultado)) {
            // Comparamos la contraseña digitada con el hash de la base de datos
            if (password_verify($password, $fila['password'])) {
                
                // Guardamos los datos en la sesión[cite: 3]
                $_SESSION['id_empleado'] = $fila['id_empleado'];
                $_SESSION['rol'] = $fila['rol'];

                // Redireccionamos dependiendo del rol
                if ($fila['rol'] == 'admin') {
                    header("Location: views/admin/listar_empleados.php");
                } else {
                    header("Location: views/empleado/perfil_empleado.php");
                }
                exit; // Siempre usar exit después de un header
            } else {
                $mensaje_error = "Contraseña incorrecta.";
            }
        } else {
            $mensaje_error = "El usuario no existe.";
        }
    }
}
?>