<!DOCTYPE html>
<html lang="pt">
  <head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Troque sua senha</title>
    <link href="../css/style.css" rel="stylesheet">
    <link href="../vendors/pace-progress/css/pace.min.css" rel="stylesheet">
    <script>
      window.dataLayer = window.dataLayer || [];

      function gtag() {
        dataLayer.push(arguments);
      }
      gtag('js', new Date());
      // Shared ID
      gtag('config', 'UA-118965717-3');
      // Bootstrap ID
      gtag('config', 'UA-118965717-5');

      function verificarInformacoesSenha(){
        if(document.frmNovaSenha.senha.value=="")
        {
          //Swal.fire('Erro na Inserção','A senha está em branco!','error');
          alert('A senha está em branco!');
          document.frmNovaSenha.senha.focus();
          return false;
        }
        if(document.frmNovaSenha.senha.value!=document.frmNovaSenha.senha2.value)
        {
          //Swal.fire('Erro na Inserção','As senhas são divergentes!','error');
          alert('As senhas são divergentes!');
          document.frmNovaSenha.senha.focus();
          return false;
        }         
        return true;
      }

      function verificarInformacoes(){
        if(document.frmTroca.email.value=="")
        {
          //Swal.fire('Erro na Inserção','O email está em branco!','error');
          alert('O email está em branco!');
          document.frmTroca.email.focus();
          return false;
        }        
        return true;
      }    

    </script>
  </head>  
  <body class="app flex-row align-items-center">
    <?php require '../config.php'; primeiroAcesso() ?>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="card mx-4">
            <div class="card-body p-4">
            <?php
                if(empty($_GET['chave'])) 
                  $_GET['chave'] = "";
                if(!verificacaoChave($_GET['chave']))
                {
            ?>
              <h1>Troque sua senha</h1>
              <p class="text-muted">Digite seu e-mail cadastrado para que possa ser enviado um link para troca de senha.</p>
              <form method="POST" action="../back/Troca_Senha_back.php" onSubmit="return verificarInformacoes();" name='frmTroca'>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">@</span>
                </div>
                <input class="form-control" type="text" name="email" id="email" placeholder="Email" maxlength="50">
              </div>              
              <button class="btn btn-block btn-success" type="submit" value="Confirmar" name="confirmar">Confirmar</button>
              <?php
                }
                else{
                  session_start();
                  $_SESSION["chave"] = $_GET['chave'];
              ?>
              <?php
                $select = "SELECT usrLogin, usrNome FROM tb_usuario WHERE usrChave = :chave";
                $stmt = $pdo->prepare($select);
                $stmt->bindValue(":chave", $_GET['chave']);
                $stmt->execute();

                while($row = $stmt->fetch()) 
                {
                  echo '<h1>'.$row['usrNome'].'<font size="2" class="text-muted"> - '.$row['usrLogin'].'</font></h1>';
                }
              ?>
              <p class="text-muted">Digite aqui sua nova senha!</p>              
              <form method="POST" action="../back/verifica_senha_back.php" onSubmit="return verificarInformacoesSenha();" name='frmNovaSenha'>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"></span>
                </div>
                <input class="form-control" type="password" name="senha" id="senha" placeholder="Digite sua senha">                
              </div>  
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"></span>
                </div>
                <input class="form-control" type="password" name="senha2" id="senha2" placeholder="Repita sua senha">              
              </div> 
              <button class="btn btn-block btn-success" type="submit" value="Confirmar" name="confirmar">Confirmar</button>
              <?php
                }
              ?>
            </form>
            </div>            
          </div>
        </div>
      </div>
    </div>
  </body>  
</html>
