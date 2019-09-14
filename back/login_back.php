
<?php
require '../config.php';

$login = (isset($_POST['login']) && $_POST['login'] != '') ? $_POST['login'] : '';
$senha = (isset($_POST['senha']) && $_POST['senha'] != '') ? $_POST['senha'] : '';

if (isset($_POST['esquecer_senha']))
{
  header("Location:../src/Troca_Senha.php");
}else if ($login != '' && $senha != '') {
    $login = $_POST['login'];
    $senha = $_POST['senha'];

    $senha = $login."//".$senha;
    $senha = hash('sha256', $senha);
    
    $select = "SELECT * FROM tb_usuario WHERE usrLogin = :usuario AND usrSenha = :senha";

    $stmt = $pdo->prepare($select);

    $stmt->bindValue(":usuario", $login);
    $stmt->bindValue(":senha", $senha);

    $stmt->execute();

    if ($stmt->rowcount()==0){
      echo"<script>
      alert('Login Incorreto!');window.location.href='../src/login.php';</script>";
      $urlRetorno = "../src/login.php";
    }else{
      session_start();
      $_SESSION["login"] = $login;
      header("Location:../src/index.php");
    }
}
else{
    echo"<script>
    alert('Login ou a senha está em branco!');window.location.href='../src/login.php';</script>";
    $urlRetorno = "../src/login.php";
}
?>