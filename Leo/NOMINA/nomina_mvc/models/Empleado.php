<?php
// Empleado
class Empleado {
    private $conexion;

    public function __construct($db) {
        $this->conexion = $db;
    }

    // Funcion para registrar un empleado
    public function registrar($cedula, $password, $nombre, $apellido, $telefono, $correo, $centro_costo, $cargo, $salario_base) {
        $password_hash = password_hash($password, PASSWORD_BCRYPT);
        $rol = 'empleado'; 

        // Añadimos telefono y correo a la consulta SQL
        $sql = "INSERT INTO empleados (cedula, password, rol, nombre, apellido, telefono, correo, centro_costo, cargo, salario_base) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = mysqli_prepare($this->conexion, $sql);
        if ($stmt) {
            // "sssssssssd" -> 9 strings, 1 decimal
            mysqli_stmt_bind_param($stmt, "sssssssssd", $cedula, $password_hash, $rol, $nombre, $apellido, $telefono, $correo, $centro_costo, $cargo, $salario_base);
            if (mysqli_stmt_execute($stmt)) {
                return true;
            }
        }
        return false;
    }

    // Función para actualizar los datos de un empleado
    public function actualizar($id_empleado, $cedula, $nombre, $apellido, $telefono, $correo, $centro_costo, $cargo, $salario_base) {
        $sql = "UPDATE empleados SET cedula=?, nombre=?, apellido=?, telefono=?, correo=?, centro_costo=?, cargo=?, salario_base=? WHERE id_empleado=?";
        $stmt = mysqli_prepare($this->conexion, $sql);
        
        if ($stmt) {
            // "sssssssdi" -> 7 strings, 1 decimal, 1 entero osea 9 variables XDDD
            mysqli_stmt_bind_param($stmt, "sssssssdi", $cedula, $nombre, $apellido, $telefono, $correo, $centro_costo, $cargo, $salario_base, $id_empleado);
            if (mysqli_stmt_execute($stmt)) {
                return true;
            }
        }
        return false;
    }

    //Funcion para obtener todos los empleados
    public function listarTodos(){
        // Seleccionamos todo, ordenado por fecha de creación descendente
        $sql = "SELECT * FROM empleados ORDER BY fecha_creacion DESC";
        $resultado = mysqli_query($this->conexion, $sql);

        $empleados = [];
        //guardamos los resultados en una lista
        while($fila = mysqli_fetch_assoc($resultado)){
            $empleados[] = $fila;
        }
        return $empleados;
    }

    public function obtenerPorId($id_empleado){
        $sql = "SELECT * FROM empleados WHERE id_empleado = ?";
        // sentencia preparadas
        $stmt = mysqli_prepare($this->conexion, $sql);
        
        if ($stmt) {
            // Vinculamos el parámetro (i = integer) Solo envia un numero entero
            mysqli_stmt_bind_param($stmt, "i", $id_empleado);
            // Ejecutamos la consulta
            mysqli_stmt_execute($stmt);
            // Obtenemos el resultado
            $resultado = mysqli_stmt_get_result($stmt);
            // Devolvemos el resultado como un array
            return mysqli_fetch_assoc($resultado);
        }
        return null;
    }

    // Funcion para eliminar un empleado por su ID
    public function eliminar($id_empleado){
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