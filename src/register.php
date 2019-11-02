<!DOCTYPE html>

<html lang="pt">
  <head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Primeiro Acesso</title>    

    <link href="../css/style.css" rel="stylesheet">
    <link href="../vendors/pace-progress/css/pace.min.css" rel="stylesheet">

    <script async="" src="https://www.googletagmanager.com/gtag/js?id=UA-118965717-3"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script src="sweetalert2.all.min.js"></script>

    <script>
      window.dataLayer = window.dataLayer || [];

      function gtag() {
        dataLayer.push(arguments);
      }

      function verificarInformacoes(){        
        if(document.frmRegistro.prontuario.value=="")
        {
          //Swal.fire('Erro na Inserção','O prontuário está em branco!','error');
          alert('O prontuário está em branco!');
          document.frmRegistro.prontuario.focus();
          return false;
        }
        if(document.frmRegistro.nome.value=="")
        {
          //Swal.fire('Erro na Inserção','O nome está em branco!','error');
          alert('O nome está em branco!');
          document.frmRegistro.nome.focus();
          return false;
        }
        if(document.frmRegistro.email.value=="")
        {
          //Swal.fire('Erro na Inserção','O email está em branco!','error');
          alert('O email está em branco!');
          document.frmRegistro.email.focus();
          return false;
        }
        if(document.frmRegistro.senha.value=="")
        {
          //Swal.fire('Erro na Inserção','A senha está em branco!','error');
          alert('A senha está em branco!');
          document.frmRegistro.senha.focus();
          return false;
        }
        if(document.frmRegistro.senha.value!=document.frmRegistro.senha2.value)
        {
          //Swal.fire('Erro na Inserção','As senhas são divergentes!','error');
          alert('As senhas são divergentes!');
          document.frmRegistro.senha.focus();
          return false;
        }
        return true;
        }
    </script>
  </head>
  <body class="app flex-row align-items-center">
    <?php require '../config.php'; verifica_registro()?>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="card mx-4">
            <div class="card-body p-4">
              <h1>Primeiro Acesso</h1>
              <p class="text-muted">Criar Administrador</p>
              <form method="POST" action="../back/register_back.php" onSubmit="return verificarInformacoes();" name='frmRegistro'>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="icon-user"></i>
                  </span>
                </div>
                <input class="form-control" type="text" name="prontuario" id="prontuario" placeholder="Prontuário" style="text-transform:uppercase" maxlength="8">
              </div>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"></span>
                </div>
                <input class="form-control" type="text" name="nome" id="nome" placeholder="Nome" maxlength="50">
              </div>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">@</span>
                </div>
                <input class="form-control" type="text" name="email" id="email" placeholder="Email" maxlength="50">
              </div>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="icon-lock"></i>
                  </span>
                </div>
                <input class="form-control" type="password" name="senha" id="senha" placeholder="Senha">
              </div>
              <div class="input-group mb-4">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="icon-lock"></i>
                  </span>
                </div>
                <input class="form-control" type="password" name="senha2" id="senha2" placeholder="Repita a Senha">
              </div>
              <input class="btn btn-block btn-success" type="submit" value="Criar Administrador" name="criar" id="criar">
            </form>
            </div>            
          </div>
        </div>
      </div>
    </div>
  </body>
</html>