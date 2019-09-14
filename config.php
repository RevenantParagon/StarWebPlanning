<?php   
  $connect = mysqli_connect('127.0.0.1','root','toor');
  $db= mysqli_select_db($connect, 'projeto');

  $pdo = new PDO('mysql:host=localhost;dbname=projeto','root','toor');

  function primeiroAcesso()
  {
    $verifica = mysqli_query($GLOBALS['connect'], "SELECT * FROM tb_usuario") or die("erro ao selecionar");

    if (mysqli_num_rows($verifica)==0){
        header("Location:./register.php");
    }
  }

  function verificacaoChave($chave)
  {
    if(!empty($chave))
    {
      $select = "SELECT * FROM tb_usuario WHERE usrChave = :chave";

      $stmt = $GLOBALS['pdo']->prepare($select);

      $stmt->bindValue(":chave", $chave);

      $stmt->execute();

      if ($stmt->rowcount() == 1)
        return true;
    }
    return false;
  }

  function verifica_registro()
  {
    $verifica = mysqli_query($GLOBALS['connect'], "SELECT * FROM tb_usuario") or die("erro ao selecionar");

    if (mysqli_num_rows($verifica)>0)
        header("Location:./login.php");
  }
?>