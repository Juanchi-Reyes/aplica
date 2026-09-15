<?php
// models/Empleado.php
class Empleado
{
    private $conexion;

    public function __construct($db)
    {
        $this->conexion = $db;
    }

    // Funcion para registrar un empleado de forma transaccional (Tabla usuarios + Tabla empleados)
    public function registrar($cedula, $password, $nombre, $apellido, $telefono, $correo, $id_centro_costo, $id_cargo, $salario_base, $fecha_ingreso)
    {

        // Iniciamos la transacción para asegurar que ambos registros se guarden o ninguno
        mysqli_begin_transaction($this->conexion);

        try {
            // 1. Insertamos en la tabla usuarios
            $nombre_completo = $nombre . ' ' . $apellido;
            $password_hash = password_hash($password, PASSWORD_BCRYPT);

            // Asumimos rol CONSULTA por defecto para los empleados (no es administrador)
            $sql_usuario = "INSERT INTO usuarios (nombre_completo, correo, password_hash) VALUES (?, ?, ?)";
            $stmt_u = mysqli_prepare($this->conexion, $sql_usuario);
            mysqli_stmt_bind_param($stmt_u, "sss", $nombre_completo, $correo, $password_hash);
            mysqli_stmt_execute($stmt_u);

            // 2. Insertamos en la tabla empleados
            $sql_empleado = "INSERT INTO empleados (numero_identificacion, nombre_completo, id_cargo, id_centro_costo, sueldo_base, fecha_ingreso) 
                             VALUES (?, ?, ?, ?, ?, ?)";
            $stmt_e = mysqli_prepare($this->conexion, $sql_empleado);
            mysqli_stmt_bind_param($stmt_e, "ssiids", $cedula, $nombre_completo, $id_cargo, $id_centro_costo, $salario_base, $fecha_ingreso);
            mysqli_stmt_execute($stmt_e);

            // Si todo fue bien, confirmamos los cambios
            mysqli_commit($this->conexion);
            return true;
        } catch (Exception $e) {
            // Si algo falló (ej. correo o cédula duplicada), revertimos todo
            mysqli_rollback($this->conexion);
            return false;
        }
    }

    // Función para actualizar los datos laborales
    public function actualizar($id_empleado, $cedula, $nombre, $apellido, $id_centro_costo, $id_cargo, $salario_base)
    {
        $nombre_completo = $nombre . ' ' . $apellido;
        $sql = "UPDATE empleados SET numero_identificacion=?, nombre_completo=?, id_centro_costo=?, id_cargo=?, sueldo_base=? WHERE id_empleado=?";
        $stmt = mysqli_prepare($this->conexion, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssiidi", $cedula, $nombre_completo, $id_centro_costo, $id_cargo, $salario_base, $id_empleado);
            if (mysqli_stmt_execute($stmt)) {
                return true;
            }
        }
        return false;
    }

    // Funcion para obtener todos los empleados (Ahora cruzando datos con JOIN)
    public function listarTodos()
    {
        $sql = "SELECT e.*, c.nombre_cargo, cc.nombre AS nombre_centro_costo 
                FROM empleados e 
                JOIN cargos c ON e.id_cargo = c.id_cargo 
                JOIN centros_costo cc ON e.id_centro_costo = cc.id_centro_costo 
                ORDER BY e.id_empleado DESC";
        $resultado = mysqli_query($this->conexion, $sql);

        $empleados = [];
        if ($resultado) {
            while ($fila = mysqli_fetch_assoc($resultado)) {
                $empleados[] = $fila;
            }
        }
        return $empleados;
    }

    // Obtenemos por ID, también cruzando los datos para las vistas
    public function obtenerPorId($id_empleado)
    {
        $sql = "SELECT e.*, c.nombre_cargo, cc.nombre AS nombre_centro_costo 
                FROM empleados e 
                JOIN cargos c ON e.id_cargo = c.id_cargo 
                JOIN centros_costo cc ON e.id_centro_costo = cc.id_centro_costo 
                WHERE e.id_empleado = ?";
        $stmt = mysqli_prepare($this->conexion, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $id_empleado);
            mysqli_stmt_execute($stmt);
            $resultado = mysqli_stmt_get_result($stmt);
            return mysqli_fetch_assoc($resultado);
        }
        return null;
    }

    // Eliminar o inactivar. (Recomendación: En una BD real es mejor marcar INACTIVO, pero mantenemos tu lógica de eliminación física por ahora)
    public function eliminar($id_empleado)
    {
        $sql = "DELETE FROM empleados WHERE id_empleado = ?";
        $stmt = mysqli_prepare($this->conexion, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $id_empleado);
            if (mysqli_stmt_execute($stmt)) {
                return true;
            }
        }
        return false;
    }
}
?>