<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script src="sweetalert2.all.min.js"></script>

<?php
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;  
  
  require '../config.php';
  require '../phpmailer/Exception.php';
  require '../phpmailer/PHPMailer.php';
  require '../phpmailer/SMTP.php';
  
  if(!empty($_POST['email'])){
 
    $user = mysqli_real_escape_string($connect,$_POST['email']);
    $q = mysqli_query($connect, "SELECT usrId FROM tb_usuario WHERE usrEmail = '$user'");   
 
    if(mysqli_num_rows($q) == 1 ){
      while($row=mysqli_fetch_array($q))
      {
        $chave = sha1(uniqid(mt_rand(), true));

        $conf = mysqli_query($connect, "UPDATE tb_usuario set usrChave = '$chave', usrDataExpirar = date_add(now(), interval 1 hour) where usrId='".$row['usrId']."'");

        $link = 'localhost/pi2/src/Troca_senha.php?chave='.$chave;

        if($conf == 1)
        {
          $mail = new PHPMailer;          
          
          $mail->isSMTP();
          $mail->SMTPDebug = 0;
          $mail->Host = 'smtp.gmail.com';
          $mail->Port = 465;
          $mail->SMTPSecure = 'ssl';
          $mail->SMTPAuth = true;
          $mail->Username = 'starwebplanning@gmail.com';
          $mail->Password = 'astarium';
          $mail->setFrom('starwebplanning@gmail.com', 'ADMINISTRADOR');
          $mail->addAddress($_POST['email'], 'Usuário');
          $mail->isHTML(true);
          $mail->Subject = '=?UTF-8?B?'.base64_encode("Recuperação de Senha").'?=';
          $mail->Body = 'Olá, <p> Recentemente, recebemos uma solicitação para redefinição de senha. Clique no link abaixo para redefini-la<p><a href='.$link.'>'.$link.'</a> <p>Atensiosamente,<p> ADMINISTRADOR';                  
  
          if ($mail->send()){
            echo"<script>
            alert('Foi enviado um e-mail para o seu endereço, onde poderá encontrar um link único para alterar a sua senha!');window.location
            .href='../src/login.php';</script>";
            die();
          } else {
            echo"<script>
            alert('Houve um erro ao enviar o email! Tente novamente.');window.location
            .href='../src/Troca_Senha.php';</script>";
            die();
          }  
        } else 
        {
          echo"<script>
          alert('Não foi possível gerar o endereço único!');window.location
          .href='../src/Troca_Senha.php';</script>";
          die();
        }
      }
    } else {
      echo"<script>
      alert('Esse utilizador não existe!');window.location
      .href='../src/Troca_Senha.php';</script>";
      die();
    }  
  }
  else {
    echo"<script>
    alert('Não foi passado nenhum email!');window.location
    .href='../src/Troca_Senha.php';</script>";
    die();
  }
?>