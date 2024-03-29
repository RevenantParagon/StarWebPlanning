<!DOCTYPE html>
<html lang="pt">
  <head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login</title>
    <link href="../css/style.css" rel="stylesheet">
    <link href="../vendors/pace-progress/css/pace.min.css" rel="stylesheet">
    <script async="" src="https://www.googletagmanager.com/gtag/js?id=UA-118965717-3"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag() {
        dataLayer.push(arguments);
      }
    </script>
  </head>
  <body class="app flex-row align-items-center">
    <?php require '../config.php'; primeiroAcesso() ?>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-4">
          <div class="card-group">
            <div class="card p-4">
              <div class="card-body">
                <h1>Login</h1>
                <form method="POST" id="formLogin" action="../back/login_back.php">
                  <p class="text-muted">Inicie sua conexão</p>
                  <p id="error"></p>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="icon-user"></i>
                      </span>
                    </div>
                    <input class="form-control" type="text" name="login" id="login" placeholder="Prontuário" style="text-transform:uppercase" maxlength="8">
                  </div>
                  <div class="input-group mb-4">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="icon-lock"></i>
                      </span>
                    </div>
                    <input class="form-control" type="password" name="senha" id="senha" placeholder="Senha">
                  </div>
                  <div class="row">
                    <div class="col-6">
                      <input class="btn btn-primary px-4" type="submit" value="Login" id="entrar" name="entrar">
                    </div>
                    <div class="col-6 text-right">
                      <input class="btn btn-link px-0" type="submit" value = "Esqueceu sua senha?" name="esquecer_senha" id="esquecer_senha">
                    </div>  
                </div>                            
              </form>
            </div>  
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>


