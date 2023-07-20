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
if (isset($_POST['userId'])) {
  $id = $_POST['userId'];
  if (!empty($id)) {
    // Conexão com o banco de dados (altere de acordo com suas configurações)
    require_once "../conexao.php";

    // Declaração preparada
    $sql = "DELETE FROM usuarios WHERE id = $id";

    // Executa a consulta SQL
    if ($conn->query($sql) === TRUE) {
      $_SESSION["mensagem"] = "Swal.fire({
        position: 'top-end',
        icon: 'success',
        title: 'Usuário deletado com sucesso!',
        showConfirmButton: false,
        timer: 2500
      });";
    } else {
      $_SESSION["mensagem"] = "Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Erro ao deletar usuário:' " . $conn->error;
      ",
      });";
    }

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
