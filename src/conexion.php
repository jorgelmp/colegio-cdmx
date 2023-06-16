<?php
// Conexión a la base de datos MySQL
$servername = "10.108.244.249" #"10.109.180.44"; //cluster ip del servicio de mysql
$username = "root";
$password = "rootpassword";
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
    header("Location: index.html");
} else {
    echo "Error al ingresar los datos: " . $conn->error;
}

// Cerrar la conexión
$conn->close();
?>
