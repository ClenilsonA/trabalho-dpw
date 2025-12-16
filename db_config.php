<?php
// Configuração da Base de Dados Laragon
$host = 'localhost';
$username = 'root'; 
$password = ''; 
$database = 'bookify_db';


$conn = new mysqli($host, $username, $password, $database);


if ($conn->connect_error) {
    die("Falha na conexão com a base de dados: " . $conn->connect_error);
}


$conn->set_charset("utf8mb4");

?>