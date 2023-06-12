<?php
// Conexión a la base de datos MySQL
$servername = "mysql-service";
$username = "root";
$password = "password";
$port = 3306;
$dbname = "clientes";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname,$port);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error al conectar con la base de datos: " . $conn->connect_error);
}

// Obtener los datos del formulario
$nombre = $_POST["nombre"];
$correo = $_POST["correo"];
$comentario = $_POST["comentario"];

// Insertar los datos en la tabla
$sql = "INSERT INTO client (nombre, correo, comentario) VALUES ('$nombre', '$correo', '$comentario')";

if ($conn->query($sql) === TRUE) {
    echo "Datos ingresados correctamente";
} else {
    echo "Error al ingresar los datos: " . $conn->error;
}

// Cerrar la conexión
$conn->close();
?>
