<?php
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
   
  require_once('conexao.php');
  require './phpmailer/Exception.php';
  require './phpmailer/PHPMailer.php';
  require './phpmailer/SMTP.php';
   
  header('Content-Type: text/html; charset=UTF-8');
  
  if(!empty($_POST['email'])){
 
    $user = mysqli_real_escape_string($connect,$_POST['email']);
    $q = mysqli_query($connect, "SELECT usrId FROM tb_usuario WHERE usrEmail = '$user'");   
 
    if(mysqli_num_rows($q) == 1 ){
      while($row=mysqli_fetch_array($q))
      {
        $chave = sha1(uniqid(mt_rand(), true));

        $conf = mysqli_query($connect, "UPDATE tb_usuario set usrChave = '$chave' where usrId='".$row['usrId']."'");
  
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
          $mail->Charset = 'UTF-8';
          $mail->setFrom('starwebplanning@gmail.com', 'ADMINISTRADOR');
          $mail->addAddress($_POST['email'], 'Usuário');
          $mail->isHTML(true);
          $mail->Subject = '=?UTF-8?B?'.base64_encode("Recuperação de Senha").'?=';
          $mail->Body = 'Olá, <p> <p>Atensiosamente,<p> ADMINISTRADOR';                  
  
          if ($mail->send()){
            echo '<p>Foi enviado um e-mail para o seu endereço, onde poderá encontrar um link único para alterar a sua password</p>';  
          } else {
            echo '<p>Houve um erro ao enviar o email (o servidor suporta a função mail?)</p>'; 
          }  
        } else 
        {
          echo '<p>Não foi possível gerar o endereço único</p>'; 
        }
      }
    } else {
    echo '<p>Esse utilizador não existe</p>';
    }  
  }


 /* use master\src\PHPMailer;
  use master\src\Exception;

  require '../vendor/autoload.php';

  //require 'master/src/Exception.php';
  //require 'master/src/PHPMailer.php';
  //require 'master/src/SMTP.php';

  $mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = 2;                                       // Enable verbose debug output
    $mail->isSMTP();                                            // Set mailer to use SMTP
    $mail->Host='smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth= true;                                   // Enable SMTP authentication
    $mail->Username= 'starwebplanning@gmail.com';                     // SMTP username
    $mail->Password= 'astarium';                               // SMTP password
    $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('starwebplanning@gmail.com', 'Teste');
    $mail->addAddress('nathanwillian.costa@gmail.com', 'Testando');     // Add a recipient
    //$mail->addAddress('ellen@example.com');               // Name is optional
    //$mail->addReplyTo('info@example.com', 'Information');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    // Attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Here is the subject';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();

    if ($mail) {
      echo "E-mail enviado com sucesso!";
    } else {
      echo "Não foi possível enviar o e-mail.";
    }
} catch (Exception $e){}*/
  

?>