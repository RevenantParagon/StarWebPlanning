<?php   
  $connect = mysqli_connect('127.0.0.1','root','toor');
  $db= mysqli_select_db($connect, 'projeto');

  function Inserir($tabela, $colunas, $valores)
  {
    $sql = "INSERT INTO ".$tabela."(".$colunas.") VALUES(".$valores.")";

    $retorno = false;

    if(mysqli_query($GLOBALS['connect'], $sql))
      $retorno = true;
    mysqli_close($GLOBALS['connect']);

    return $retorno;
  }

?>