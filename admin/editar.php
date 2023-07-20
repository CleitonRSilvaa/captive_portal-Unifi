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
if (isset($_POST['editNome']) && isset($_POST['editIdentidade']) && isset($_POST['editCpf']) && isset($_POST['editId'])) {

  $id = $_POST['editId'];
  $nome = validarEntrada($_POST['editNome']);
  $identidade = validarEntrada($_POST['editIdentidade']);
  $cpf = validarEntrada($_POST['editCpf']);

  $identidade = regexnNumero($identidade);
  $cpf = regexnNumero($cpf);
  // Verifica se os campos não estão vazios
  if (!empty($nome) && !empty($identidade) && !empty($cpf) && !empty($id)) {
    // Conexão com o banco de dados (altere de acordo com suas configurações)
    require_once "../conexao.php";

    // Declaração preparada
    $sql = "UPDATE usuarios SET nome = ?, identidade = ?, cpf = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
      die("Erro na declaração preparada: " . $conn->error);
    }
    // Vincular os parâmetros
    $stmt->bind_param("sssi", $nome, $identidade, $cpf, $id);

    // Executar a atualização
    if ($stmt->execute()) {
      $_SESSION["mensagem"] = "Swal.fire({
        position: 'top-end',
        icon: 'success',
        title: 'Cadastrado atualizado com sucesso!',
        showConfirmButton: false,
        timer: 2500
      });";
    } else {
      $_SESSION["mensagem"] = "Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Erro ao atualizar cadastro do usuário!',
      });";
    }

    // Fechar a declaração preparada e a conexão
    $stmt->close();
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
