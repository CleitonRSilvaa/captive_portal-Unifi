<?php
// Inicialize a sessão
require_once "../session_timeout.php";
 
// Verifique se o usuário já está logado, em caso afirmativo, redirecione-o para a página de boas-vindas
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: ../admin/home.php");
    exit;
}
 
// Incluir arquivo de configuração
require_once "../conexao.php";
 
// Defina variáveis e inicialize com valores vazios
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// Processando dados do formulário quando o formulário é enviado
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Verifique se o nome de usuário está vazio
    if(empty(trim($_POST["username"]))){
        $username_err = "Por favor, insira o nome de usuário.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Verifique se a senha está vazia
    if(empty(trim($_POST["password"]))){
        $password_err = "Por favor, insira sua senha.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    if(empty($username_err) && empty($password_err)){

    // Prepare uma declaração selecionada
        $query = "SELECT * FROM users_admin WHERE username = ? AND password = SHA2(?, 256)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
        // Usuário encontrado
        $row = $result->fetch_assoc();
        $id = $row["id"];
        $username = $row["username"];
        $hashed_password = $row["password"];
        // Armazene dados em variáveis de sessão
        $_SESSION["loggedin"] = true;
        $_SESSION["id"] = $id;
        $_SESSION["username"] = $username; 
        // Redirecionar o usuário para a página de boas-vindas
        header("location: ../admin/home.php");
        } else {
            $_SESSION["login_err"] = "Nome de usuário ou senha inválidos.";
        }
        
        
        // Fechar conexão
        $stmt->close();
        $conn->close();
    }else{
          $_SESSION["login_err"] = "Nome de usuário ou senha inválidos.";
    }

    header("location: ../admin/index.php");
    exit; 
}
