<?php
// models/Empleado.php

class Empleado {
    private $conexion;

    public function __construct($db) {
        $this->conexion = $db;
    }

    public function registrar($cedula, $password, $nombre, $apellido, $centro_costo, $cargo, $salario_base) {
        // Encriptamos la contraseña por seguridad antes de guardarla
        $password_hash = password_hash($password, PASSWORD_BCRYPT);
        $rol = 'empleado'; // Por defecto, todos los registrados aquí son empleados

        // Usamos sentencias preparadas (?)
        $sql = "INSERT INTO empleados (cedula, password, rol, nombre, apellido, centro_costo, cargo, salario_base) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = mysqli_prepare($this->conexion, $sql);
        
        if ($stmt) {
            // Vinculamos los parámetros (s = string, d = double/decimal)
            mysqli_stmt_bind_param($stmt, "sssssssd", $cedula, $password_hash, $rol, $nombre, $apellido, $centro_costo, $cargo, $salario_base);
            
            if (mysqli_stmt_execute($stmt)) {
                return true;
            }
            mysqli_stmt_close($stmt);
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

    // Función para actualizar los datos del empleado
    public function actualizar($id_empleado, $cedula, $nombre, $apellido, $centro_costo, $cargo, $salario_base) {
        $sql = "UPDATE empleados SET cedula=?, nombre=?, apellido=?, centro_costo=?, cargo=?, salario_base=? WHERE id_empleado=?";
        $stmt = mysqli_prepare($this->conexion, $sql);
        
        if ($stmt) {
            // "sssssdi" -> 5 strings, 1 double (salario), 1 integer (id)
            mysqli_stmt_bind_param($stmt, "sssssdi", $cedula, $nombre, $apellido, $centro_costo, $cargo, $salario_base, $id_empleado);
            if (mysqli_stmt_execute($stmt)) {
                return true;
            }
        }
        return false;
    }
}
?>