<?php
// Inicialize a sessão
require_once "../session_timeout.php";
// Verifique se o usuário está logado, se não, redirecione-o para uma página de login
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("location: ../admin/index.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../admin/css/home.css">
  <script src="/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="icon" type="image/png" href="../images/icons/favicon.ico" />

  <title>Portal Unifi 2DE</title>
</head>

<body>
  <nav class="navbar  navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="../admin/home.php">Usuários</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Relatorios
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="../admin/listaDevices.php">Usuários Conectados</a></li>
              <li><a class="dropdown-item" href="#">Esquipamentos</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link disabled">Disabled</a>
          </li>
        </ul>
        <a class="btn btn-outline-danger" href="../admin/logout.php"><span class="material-icons">logout</span></a>

      </div>
  </nav>

  <div class="container p-5">



    <div class="border border-3 rounded m-0 ">
      <div class="table-responsive">
        <table class="table table-dark">
          <thead>
            <th scope="col">Hostname</th>
            <th scope="col">IP</th>
            <th scope="col">MAC</th>

          </thead>
          <tbody>
            <?php
            require_once '../vendor/autoload.php';
            require_once '../config.php';
            $site_id = 'default';

            $unifi_connection = new UniFi_API\Client($controlleruser, $controllerpassword, $controllerurl, $site_id, $controllerversion);
            $set_debug_mode   = $unifi_connection->set_debug($debug);
            $loginresults     = $unifi_connection->login();
            $clients_array    = $unifi_connection->list_clients();

            if (!empty($clients_array)) {
              foreach ($clients_array as $client) {
                if ($client->is_guest and  $client->authorized) {
                  echo "<tr class='table '>";
                  echo "<td>" . $client->hostname . "</td>";
                  echo "<td>" . $client->ip . "</td>";
                  echo "<td>" .  $client->mac . "</td>";
                  echo "</tr>";
                  ++$total;
                }
              }
            } else {
              echo "<tr  class='table'><td colspan='5' class ='text-center'><h4>Nenhum cliente online encontrado</h4></td></tr>";
            }

            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>


  <!-- Modal -->
  <div class="modal fade custom-modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Novo Usuário</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="myForm" onsubmit="return validarFormulario()" action="../admin/adicionar.php" method="post">
            <div class="form-group">
              <label for="formGroupInput">Nome completo:</label>
              <input type="text" class="form-control" id="nome" name="nome" placeholder="insira seu nome completo" autocomplete="off" required>
            </div>
            <div class="form-group">
              <label for="formGroupInput">Identidade militar:</label>
              <input type="text" class="form-control" id="identidadeM" name="identidadeM" placeholder="Ex: 000.000.000-0" autocomplete="off" required>
            </div>
            <div id="identidadeMAlert" class="alert alert-danger" role="alert" style="display: none;">

            </div>
            <div class="form-group">
              <label for="cpf">CPF:</label>
              <input type="text" class="form-control" id="cpf" name="cpf" placeholder="Ex: 000.000.000-00" autocomplete="off" required>
            </div>
            <div id="cpfAlert" class="alert alert-danger" role="alert" style="display: none;"></div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-outline-success" type="button">Salvar</button>
              <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Fechar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Edit Modal -->
  <div class="modal fade custom-modal" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Editar Usuário</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="editForm" onsubmit="return validarFormularioEdit()" action="../admin/editar.php" method="post">
            <div class="form-group">
              <label for="formGroupInput">ID:</label>
              <input type="text" class="form-control" id="editId" name="editId" autocomplete="off" readonly>
            </div>
            <div class="form-group">
              <label for="formGroupInput">Nome completo:</label>
              <input type="text" class="form-control" id="editNome" name="editNome" placeholder="insira seu nome completo" autocomplete="off" required>
            </div>
            <div class="form-group">
              <label for="formGroupInput">Identidade militar:</label>
              <input type="text" class="form-control " id="editIdentidade" name="editIdentidade" placeholder="Ex: 000.000.000-0" autocomplete="off" required>
            </div>
            <div id="editIdentidadeMAlert" class="alert alert-danger" role="alert" style="display: none;">
              Número da identidade incompleto!
            </div>
            <div class="form-group">
              <label for="cpf">CPF:</label>
              <input type="text" class="form-control" id="editCpf" name="editCpf" placeholder="Ex: 000.000.000-00" autocomplete="off" required>
            </div>
            <div id="editCpfAlert" class="alert alert-danger" role="alert" style="display: none;">
              Por favor, digite um CPF válido!
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-outline-success" type="button">Salvar</button>
              <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Fechar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <footer style="position: a; bottom: 0;" class="text-center text-lg-start bg-light text-muted p-0 w-100">
    <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
      &copy; 2023 Ribeiro CodeLab. Todos os direitos reservados.</p>
    </div>
  </footer>

  <?php
  if (!empty($_SESSION["mensagem"])) {
    echo '<script>' . $_SESSION["mensagem"] . '</script>';
    unset($_SESSION["mensagem"]); // remove a mensagem de erro da variável de sessão
  }
  ?>
  <script src="../vendor/jquery-3.2.1.min.js"></script>
  <script src="../vendor/jquery/jquery.mask.min.js"></script>
  <script src="../admin/js/main.js"></script>

</body>

</html>