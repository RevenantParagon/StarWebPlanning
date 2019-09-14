<!DOCTYPE html>
<html lang="pt">
<head>
    <title>Home</title>
    <meta lang="pt">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="images/icons/icone_ifsp_.png" />
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
</head>
<body>
    <?php
        session_start();
        if(isset($_SESSION["login"]))
            $login_cookie = $_SESSION["login"];
        else
            header("Location:./login.php");
        session_destroy();
    ?>
    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-6">
            <div class="card text-center">
                <?php $login_cookie ?>  
            </div>
            <div class="card text-center">
                <img src="../img/Construcao.jpg" alt="Em Construção" width=600 height=600> 
            </div>
        </div>
        <div class="col-sm-3"></div>
    </div>
</body>
</html>