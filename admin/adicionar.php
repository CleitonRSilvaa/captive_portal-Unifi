<?php

require_once "../session_timeout.php";
// Função para validar e sanitizar os dados de entrada
function validarEntrada($dados)
{
  $dados = trim($dados); // Remove espaços em branco no início e no final
  $dados = stripslashes($dados); // Remove barras invertidas
  $dados = htmlspecialchars($dados); // Converte caracteres especiais em entidades HTML
  return $dados;
}


function regexnNumero($stgNumero)
{
  $numbers = preg_replace('/[^0-9]/', '', $stgNumero);
  return $numbers;
}



// Verifica se todos os campos foram enviados
if (isset($_POST['nome']) && isset($_POST['identidadeM']) && isset($_POST['cpf'])) {
  $nome = validarEntrada($_POST['nome']);
  $identidade = validarEntrada($_POST['identidadeM']);
  $cpf = validarEntrada($_POST['cpf']);

  $identidade = regexnNumero($identidade);
  $cpf = regexnNumero($cpf);
  // Verifica se os campos não estão vazios
  if (!empty($nome) && !empty($identidade) && !empty($cpf)) {

    // Conexão com o banco de dados (altere de acordo com suas configurações)
    require_once "../conexao.php";


    $query = "SELECT * FROM usuarios WHERE identidade = ? OR cpf = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $identidade, $cpf);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 1) {
      $_SESSION["mensagem"] = "Swal.fire({
        position: 'top-end',
        icon: 'warning',
        title: 'Já existe um cadastro com esse CPF ou Identidade militar',
        showConfirmButton: false,
        timer: 2500
      });";

      header('Location: ../admin/home.php');
      exit;
    }
    // Prepara a consulta SQL para adicionar o usuário
    $query = $conn->prepare("INSERT INTO usuarios (nome, identidade, cpf) VALUES (?, ?, ?)");
    $query->bind_param("sss", $nome, $identidade, $cpf);
    $result = $query->execute();

    if ($result) {
      $_SESSION["mensagem"] = "Swal.fire({
        position: 'top-end',
        icon: 'success',
        title: 'Usuário cadastrado com sucesso!',
        showConfirmButton: false,
        timer: 2500
      });";
    } else {
      $_SESSION["mensagem"] = "Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Erro ao cadastrar usuário!',
      });";
    }

    $query->close();
    $conn->close();
  } else {
    $_SESSION["mensagem"] = "Swal.fire({
      icon: 'warning',
      title: 'Atenção',
      text: 'Todos os campos são obrigatórios!',
    });";
  }
} else {
  $_SESSION["mensagem"] = "Swal.fire({
    icon: 'warning',
    title: 'Atenção',
    text: 'Todos os campos são obrigatórios!',
  });";
}

header('Location: ../admin/home.php');
