<?php

function regexnNumero($stgNumero)
{
    $numbers = preg_replace('/[^0-9]/', '', $stgNumero);
    return $numbers;
}

if (!empty($_POST['identidade']) && !empty($_POST['cpf'])) {
    session_start();
    $identidade = regexnNumero($_POST['identidade']);
    $cpf = regexnNumero($_POST['cpf']);
    require_once "conexao.php";
    if ($conn->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conn->connect_error);
    }

    // Consulta SQL para verificar se o usuário existe
    $sql = "SELECT  SUBSTRING(cpf, 1, 4) AS cpf, identidade FROM portal_unifi.usuarios WHERE identidade = '$identidade' AND SUBSTRING(cpf, 1, 4) = '$cpf'";
    $result = $conn->query($sql);
    $result_consulta  = $result->num_rows > 0;
    $conn->close();
    // Verificar se houve algum resultado na consulta
    if ($result_consulta) {
        header('Location: connecting.php');
        exit;
    } else {
        $_SESSION["login_user_err"] = "Usuário ou senha incorretos.";
    }
    header('Location: index.php');
} else {
    header('Location: index.php');
}
