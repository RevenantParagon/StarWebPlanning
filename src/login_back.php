<?php
require_once('conexao.php');

if (isset($_POST['entrar'])) {
    $login = $_POST['login'];
    $senha = $_POST['senha'];

    $senha = $login."//".$senha;

    $senha = hash('sha256', $senha);

    //include("conexao.php");
    
        $verifica = mysqli_query($connect, "SELECT * FROM tb_usuario WHERE usrLogin = '$login' AND usrSenha = '$senha'") or die("erro ao selecionar");

        if (mysqli_num_rows($verifica)<=0){
          echo"<script language='javascript' type='text/javascript'>
          alert('Login e/ou senha incorretos');window.location
          .href='login.php';</script>";
          die();
        }else{
          setcookie("login",$login);
          header("Location:index.html");
        }
}
else if (isset($_POST['esquecer_senha']))
{
  header("Location:Troca_Senha.php");
}
?>