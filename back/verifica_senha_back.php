
<?php
require '../config.php';
session_start();
$chave = $_SESSION["chave"];

if(!empty($chave))
{
  $select = "SELECT usrID, usrLogin, (select TIMESTAMPDIFF(second , now(), usrDataExpirar) from tb_usuario us where u.usrID = us.usrID) 'data' FROM tb_usuario u WHERE usrChave = :chave";

  $stmt = $pdo->prepare($select);

  $stmt->bindValue(":chave", $chave);

  $stmt->execute();

  if ($stmt->rowcount() == 1)
  {
    while($row = $stmt->fetch()) {

      if($row['data'] > 0)
      {
        $senha = $row['usrLogin']."//".$_POST['senha'];
    
        $senha = hash('sha256', $senha);

        $select = "UPDATE tb_usuario set usrSenha= :senha, usrDataExpirar = NULL, usrChave=NULL where usrId=:id";

        $stmt = $pdo->prepare($select);
      
        $stmt->bindValue(":senha", $senha);
        $stmt->bindValue(":id", $row['usrID']);
      
        $stmt->execute();

        if ($stmt->rowcount() == 1)
            header("Location:../src/login.php");
        else 
        {
          echo"<script>
          alert('Houve um erro na alteração!');window.location
          .href='../src/Troca_Senha.php';</script>";
          die();
        }
      }
      else{
        echo"<script>
          alert('Sua chave expirou!\nEnvie uma nova solicitação de troca de senha!');window.location
          .href='../src/Troca_Senha.php';</script>";
          die();
      }
    }    
  }
  else 
        {
          echo"<script>
          alert('Não foi encontrado um usuário com esta chave!');window.location
          .href='../src/Troca_Senha.php';</script>";
          die();
        }
}
?>