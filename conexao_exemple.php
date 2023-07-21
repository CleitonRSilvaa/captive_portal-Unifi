<?php
$servername = "127.0.0.1:3306"; // nome do servidor MySQL
$username = "user"; // nome de usuário do MySQL
$password = "password"; // senha do MySQL
$database = "database"; // nome do banco de dados
// Estabelece a conexão
$conn = mysqli_connect($servername, $username, $password, $database);

// Verifica se a conexão foi estabelecida corretamente
if (!$conn) {
    die("Erro na conexão: " . mysqli_connect_error());
}
