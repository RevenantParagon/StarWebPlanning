<?php
  require_once('conexao.php');

  use master\src\PHPMailer;
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
} catch (Exception $e){}












  /*# Inicia a classe PHPMailer
  $mail = new PHPMailer();

  # Define os dados do servidor e tipo de conexão
  $mail->IsSMTP(); // Define que a mensagem será SMTP
  $mail->Host = "smtp.gmail.com"; # Endereço do servidor SMTP
  $mail->Port = 587; // Porta TCP para a conexão
  $mail->SMTPAutoTLS = false; // Utiliza TLS Automaticamente se disponível
  $mail->SMTPAuth = true; # Usar autenticação SMTP - Sim
  $mail->Username = 'starwebplanning@gmail.com'; # Usuário de e-mail
  $mail->Password = 'astarium'; // # Senha do usuário de e-mail

  # Define o remetente (você)
  $mail->From = 'starwebplanning@gmail.com'; # Seu e-mail
  $mail->FromName = "Nome do Remetente"; // Seu nome

  # Define os destinatário(s)
  $mail->AddAddress('nathanwillian.costa@gmail.com', 'Teste'); # Os campos podem ser substituidos por variáveis
  #$mail->AddAddress('webmaster@nomedoseudominio.com'); # Caso queira receber uma copia
  #$mail->AddCC('ciclano@site.net', 'Ciclano'); # Copia
  #$mail->AddBCC('fulano@dominio.com.br', 'Fulano da Silva'); # Cópia Oculta

  # Define os dados técnicos da Mensagem
  $mail->IsHTML(true); # Define que o e-mail será enviado como HTML
  #$mail->CharSet = 'iso-8859-1'; # Charset da mensagem (opcional)

  # Define a mensagem (Texto e Assunto)
  $mail->Subject = "Mensagem Teste"; # Assunto da mensagem
  $mail->Body = "Este é o corpo da mensagem de teste, em <b>HTML</b>! :)";
  $mail->AltBody = "Este é o corpo da mensagem de teste, somente Texto! \r\n :)";

  # Define os anexos (opcional)
  #$mail->AddAttachment("c:/temp/documento.pdf", "documento.pdf"); # Insere um anexo

  # Envia o e-mail
  $enviado = $mail->Send();

  # Limpa os destinatários e os anexos
  $mail->ClearAllRecipients();
  $mail->ClearAttachments();

  # Exibe uma mensagem de resultado (opcional)
  if ($enviado) {
    echo "E-mail enviado com sucesso!";
  } else {
    echo "Não foi possível enviar o e-mail.";
    echo "<b>Informações do erro:</b> " . $mail->ErrorInfo;
  }*/




  /*if(!empty($_POST['email']) ){
 
    $user = mysqli_real_escape_string($connect,$_POST['email']);
    $q = mysqli_query($connect, "SELECT usrId FROM tb_usuario WHERE usrEmail = '$user'");   
 
    if(mysqli_num_rows($q) == 1 ){
      // o utilizador existe, vamos gerar um link único e enviá-lo para o e-mail
      while($row=mysqli_fetch_array($q,MYSQL_ASSOC)
      {
        // gerar a chave
        // exemplo adaptado de http://snipplr.com/view/20236/
        $chave = sha1(uniqid(mt_rand(), true));
  
        // guardar este par de valores na tabela para confirmar mais tarde
        $conf = mysqli_query($connect, "UPDATE tb_usuario set usrChave = '$chave' where usrId='$row[usrId]'");
  
        if( mysqli_num_rows($conf) > 0 )
        {
  
          $link = "localhost/Pi/src/Troca_Senha.html?confirmacao=$chave";

          
  
          /*if( mail($user, 'Recuperação de password', 'Olá '.$user.', visite este link '.$link) ){
            echo '<p>Foi enviado um e-mail para o seu endereço, onde poderá encontrar um link único para alterar a sua password</p>';
  
          } else {
            echo '<p>Houve um erro ao enviar o email (o servidor suporta a função mail?)</p>'; 
          }
  
          // Apenas para testar o link, no caso do e-mail falhar
          echo '<p>Link: '.$link.' (apresentado apenas para testes; nunca expor a público!)</p>';
  
        } else 
        {
          echo '<p>Não foi possível gerar o endereço único</p>'; 
        }
      }
    } else {
    echo '<p>Esse utilizador não existe</p>';
    }  
  }*/ 
  //else {
    // mostrar formulário de recuperação

?>