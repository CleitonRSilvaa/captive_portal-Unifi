<?php

session_start();
// //Get the MAC addresses of AP and user

$_SESSION["id"] = $_GET["id"];
$_SESSION["ap"] = $_GET["ap"];


?>

<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="dark">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tela de Login</title>
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/style.css">

</head>

<body>
  <div class="container">
    <div class="logo">
      <img src="seu_logo.png" alt="Logo">
    </div>
    <h2 class="text-center mb-4">Login</h2>

    <form id="loginForm" action="autenticacao.php" method="post">
      <div class="form-group">
        <label for="text" class="form-label">Identidade militar</label>
        <input type="text" class="form-control" id="identidade" name="identidade" placeholder="Ex: 000.000.000-0" autocomplete="off" required>
        <div class="form-group">
          <label for="cpf" class="form-label">CPF (4 primeiros dígitos)</label>
          <div class="input-group mb-3">
            <input name="cpf" id="cpf" type="password" class="form-control" placeholder="4 primeiros dígitos" aria-label="Recipient's username" aria-describedby="button-addon3" required>
            <button class="btn btn-secondary" type="button" id="button-addon3" onClick="toggleVisibility(this)"><span class="material-icons">visibility</span></button>
          </div>
          <?php

          if (isset($_SESSION["login_user_err"])) {
            echo '<div class="alert alert-danger">' . $_SESSION["login_user_err"] . '</div>';
            unset($_SESSION["login_user_err"]);
          }
          ?>
        </div>
        <div class="center form-group ">
          <div class="row">
            <button type="submit" id="loginButton" class="btn btn-primary ">Entrar</button>
          </div>

        </div>

    </form>
    <div class="terms">
      <p>Ao entrar, você concorda com os <a href="#">termos de aceite</a>.</p>
      <p>&copy; 2023 Ribeiro CodeLab. Todos os direitos reservados.</p>
    </div>
  </div>

  <script>
    const form = document.getElementById('loginForm');
    const loginButton = document.getElementById('loginButton');

    form.addEventListener('submit', function(event) {
      //event.preventDefault(); // Impede o envio do formulário

      // Desabilita o botão de login
      loginButton.disabled = true;
      // Aqui você pode adicionar a lógica de redirecionamento ou exibição de mensagens de erro/sucesso
      // Exemplo:
      if (response.success) {

      } else {
        alert('Login falhou!');
        loginButton.disabled = false;
      }

    });
  </script>

  <script src="../vendor/jquery-3.2.1.min.js"></script>
  <script src="../vendor/jquery/jquery.mask.min.js"></script>
  <script src="../js/main.js"></script>


</body>

</html>