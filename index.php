<!DOCTYPE html>
<html lang="en">

<head>
    <title>Home</title>
    <meta lang="pt">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="images/icons/icone_ifsp_.png" />
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
</head>

<body>
    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-6">
            <div class="card text-center">
                <?php
                if(isset($_COOKIE['login'])){
                    $login_cookie = $_COOKIE['login'];
                    echo"<div class='card-header'>";
                    echo"Bem-Vindo, $login_cookie <br>";
                    echo"</div>";
                    echo"<div class='card-body'>";
                    echo"<p class='card-text'>Essas informações <font color='red'>PODEM</font> ser acessadas por você</p>";
                    echo"</div>";
                }else{
                    echo"<div class='card-header'>";
                    echo"Bem-Vindo, convidado<br>";
                    echo"</div>";
                    echo"<div class='card-body'>";
                    echo"<h5 class='card-title'>Essas informações <font color='red'>NÃO PODEM</font> ser acessadas por você</h5><br>";
                    echo"<p class='card-text'>Para ler o conteúdo realize login</p>";
                    echo"</div>";
                    echo"<div class='card-footer text-muted'>";
                    echo"<a href='login.html' class='btn btn-primary'>Login</a> ";
                    echo"<a href='passwordreset.php' class='btn btn-primary'>Esqueceu a senha?</a>";
                    echo"</div>";
                }
                ?>
            </div>
        </div>
        <div class="col-sm-3"></div>
    </div>
</body>

</html>