
<?php
require '../config.php';

$login = (isset($_POST['login']) && $_POST['login'] != '') ? $_POST['login'] : '';
$senha = (isset($_POST['senha']) && $_POST['senha'] != '') ? $_POST['senha'] : '';

if (isset($_POST['esquecer_senha'])) {
  header("Location:../src/Troca_Senha.php");
} else if ($login != '' && $senha != '') {
  $login = strtoupper($_POST['login']);
  $senha = $_POST['senha'];

  $senha = $login . "//" . $senha;
  $senha = hash('sha256', $senha);

  $select = "SELECT usrID 'id', usrTipo 'tipo', camId FROM tb_usuario WHERE usrLogin = :usuario AND usrSenha = :senha";

  $stmt = $pdo->prepare($select);

  $stmt->bindValue(":usuario", $login);
  $stmt->bindValue(":senha", $senha);

  $stmt->execute();

  if ($stmt->rowcount() == 0) {
    echo "<script>
      alert('Login Incorreto!');window.location.href='../src/login.php';</script>";
  } else {
    session_start();
    while ($row = $stmt->fetch()) {
      $_SESSION["id"] = $row['id'];
      $_SESSION["tipo"] = $row['tipo'];
      $_SESSION["login"] = $login;
      $_SESSION["campus"] = $row['camId'];
    }
    header("Location:../src/index.php");
  }
} else {  
  session_start();
  session_unset();
  session_destroy();

  //$_SESSION['id'] = false;
  header("Location:../src/login.php");
}
?>