<?php
$host = "localhost";
$db = "";
$user = "root";
$pass = "";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Erro na conexão com MySQL: " . $conn->connect_error);
}
?>
