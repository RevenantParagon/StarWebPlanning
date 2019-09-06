<?php
    require_once('conexao.php');

    $verifica = mysqli_query($connect, "SELECT * FROM tb_usuario") or die("erro ao selecionar");

    if (mysqli_num_rows($verifica)==0){
        header("Location:register.php");
    }
?>