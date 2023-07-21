<?php

session_start();

if (!empty($_SESSION["loggedin"])) {
    header("location: ../admin/home.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign Up</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="../images/icons/favicon.ico" />
</head>

<body>

    <div class="main p-3">
        <section class="sign-in">
            <div class="container">
                <div class="signin-content">
                    <div class="signin-image">
                        <figure><img src="images/signin-image.png" alt="sing up image"></figure>
                    </div>
                    <div class="signin-form">
                        <h2 class="form-title">Login</h2>
                        <form method="POST" class="register-form" id="login-form" action="../admin/loginAdmin.php" method="POST">
                            <div class="form-group">
                                <label for="your_name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input required type="text" name="username" id="your_name" placeholder="Usuario" />
                            </div>
                            <div class="form-group">
                                <label for="your_pass"><i class="zmdi zmdi-lock"></i></label>
                                <input required type="password" name="password" id="your_pass" placeholder="Senha" />
                            </div>
                            <?php
                            if (!empty($_SESSION["login_err"])) {

                                echo '<div class="alert alert-danger">' . $_SESSION["login_err"] . '</div>';
                                unset($_SESSION["login_err"]); // remove a mensagem de erro da variável de sessão
                            }
                            ?>
                            <div class="form-group form-button">
                                <input type="submit" name="signin" id="signin" class="form-submit" value="Log in" />
                            </div>
                        </form>


                    </div>
                </div>
            </div>
        </section>

    </div>

    <footer style="position: fixed; bottom: 0;" class="text-center text-lg-start bg-light text-muted p-0 w-100">
        <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
            &copy; 2023 Ribeiro CodeLab. Todos os direitos reservados.</p>
        </div>
    </footer>

    <script src="../js/jquery/jquery-3.2.1.min.js"></script>
    <script src="../js/main.js"></script>
</body>

</html>