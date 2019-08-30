<?php
$login = $_POST['login'];
$entrar = $_POST['entrar'];
$senha = $_POST['senha'];

$senha = $login."//".$senha;

$senha = hash('sha256', $senha);

$connect = mysqli_connect('127.0.0.1','root','toor');
$db = mysqli_select_db($connect, 'projeto');
  if (isset($entrar)) {
      $verifica = mysqli_query($connect, "SELECT * FROM tb_usuario WHERE usrLogin = '$login' AND usrSenha = '$senha'") or die("erro ao selecionar");

      if (mysqli_num_rows($verifica)<=0){
        echo"<script language='javascript' type='text/javascript'>
        alert('Login e/ou senha incorretos');window.location
        .href='login.html';</script>";
        die();
      }else{
        setcookie("login",$login);
        header("Location:index.php");
      }
  }
?>