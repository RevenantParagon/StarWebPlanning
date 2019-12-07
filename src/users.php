<!DOCTYPE html>
<!--
* CoreUI - Free Bootstrap Admin Template
* @version v2.1.15
* @link https://coreui.io
* Copyright (c) 2018 creativeLabs Łukasz Holeczek
* Licensed under MIT (https://coreui.io/license)
-->

<html lang="pt">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Star Web Planning</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  <script>
    function verificarInformacoes() {
      if (document.frmUsuario.prontuario.value == "") {
        //Swal.fire('Erro na Inserção','O prontuário está em branco!','error');
        alert('O prontuário está em branco!');
        document.frmUsuario.prontuario.focus();
        return false;
      }
      if (document.frmUsuario.nome.value == "") {
        //Swal.fire('Erro na Inserção','O nome está em branco!','error');
        alert('O nome está em branco!');
        document.frmUsuario.nome.focus();
        return false;
      }
      if (document.frmUsuario.email.value == "") {
        //Swal.fire('Erro na Inserção','O email está em branco!','error');
        alert('O email está em branco!');
        document.frmUsuario.email.focus();
        return false;
      }
      if (document.frmUsuario.senha.value == "") {
        //Swal.fire('Erro na Inserção','A senha está em branco!','error');
        alert('A senha está em branco!');
        document.frmUsuario.senha.focus();
        return false;
      }
      if (document.frmUsuario.senha.value != document.frmUsuario.senha2.value) {
        //Swal.fire('Erro na Inserção','As senhas são divergentes!','error');
        alert('As senhas são divergentes!');
        document.frmUsuario.senha.focus();
        return false;
      }
      return true;
    }
  </script>


</head>

<body class="hold-transition sidebar-mini layout-fixed">

  <?php require '../config.php';
  session_start();
  if (!isset($_SESSION["id"])) {
    echo "<script>window.location.href='./login.php';</script>";
  }
  telaInicial();
  if (!isset($_GET['id'])) {
    verificaAcesso(basename(__FILE__));
  } else {
    if ($_GET['id'] != $_SESSION['id'])
      verificaAcesso(basename(__FILE__));
  } ?>
  <div class="content-wrapper">
    <section class="content">
      <div class="container-fluid">
        <?php require '../back/function/users_function.php';
        if (!isset($_GET['funcao'])) {
          $_GET['funcao'] = 'cadastrar';
        }
        if ($_GET['funcao'] == 'cadastrar') { ?>
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Cadastro de Usuário</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">Início</a></li>
                <li class="breadcrumb-item active">Cadastro de Usuário</li>
              </ol>
            </div>
          </div>
          <div class="card card-primary">
            <form method="POST" action="../back/users_back.php?funcao=cadastrar" onSubmit="return verificarInformacoes();" name="frmUsuario">
              <div class="card-body">
                <div class="form-group">
                  <label for="prontuario">Prontuário</label>
                  <input type="text" class="form-control" id="prontuario" name="prontuario" placeholder="Prontuário" style="text-transform:uppercase" maxlength="8">
                </div>
                <div class="form-group">
                  <label for="nome">Nome</label>
                  <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome">
                </div>
                <div class="form-group">
                  <label for="email">Email</label>
                  <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                </div>
                <div class="form-group">
                  <label>Campus</label>
                  <select class="custom-select" name="campus">
                    <?php criaCombobox($connect, null) ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="Senha">Senha</label>
                  <input type="password" class="form-control" id="senha" name="senha" placeholder="Senha">
                </div>
                <div class="form-group">
                  <label for="Senha2">Repita a Senha</label>
                  <input type="password" class="form-control" id="senha2" name="senha2" placeholder="Repetir Senha">
                </div>
                <div class="form-group">
                  <div class="col-sm-4">
                    <div class="custom-control custom-radio">
                      <input class="custom-control-input" type="radio" id="administrador" name="tipo_usuario" value=1>
                      <label for="administrador" class="custom-control-label">Administrador</label>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="custom-control custom-radio">
                      <input class="custom-control-input" type="radio" id="coordenador" name="tipo_usuario" value=0 checked>
                      <label for="coordenador" class="custom-control-label">Coordenador</label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer">
                <button type="submit" class="btn btn-primary" id="cadastrar" name="cadastrar">Cadastrar</button>
              </div>
            </form>
          </div>
        <?php } else {
          $row = voltarUsuario($pdo, $_GET['id']);
          ?>
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Editar Usuário</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">Início</a></li>
                <li class="breadcrumb-item active">Editar Usuário</li>
              </ol>
            </div>
          </div>
          <div class="card card-primary">
            <form method="POST" action=<?php echo "../back/users_back.php?funcao=editar&id=" . $_GET['id'] . ""; ?> onSubmit="return verificarInformacoes();" name="frmUsuario">
              <div class="card-body">
                <div class="form-group">
                  <label for="prontuario">Prontuário</label>
                  <input type="text" class="form-control" id="prontuario" name="prontuario" placeholder="Prontuário" style="text-transform:uppercase" value="<?php echo $row['prontuario'] ?>">
                </div>
                <div class="form-group">
                  <label for="nome">Nome</label>
                  <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome" value="<?php echo $row['nome'] ?>">
                </div>
                <div class="form-group">
                  <label for="email">Email</label>
                  <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $row['email'] ?>">
                </div>
                <div class="form-group">
                  <label>Campus</label>
                  <select class="custom-select" name="campus">
                    <?php
                      criaCombobox($connect, $row['campus']) ?>
                  </select>
                </div>
                <div class="form-group">
                  <div class="form-group">
                    <label for="Senha">Senha</label>
                    <input type="password" class="form-control" id="senha" name="senha" placeholder="Senha">
                  </div>
                  <div class="form-group">
                    <label for="Senha2">Repita a Senha</label>
                    <input type="password" class="form-control" id="senha2" name="senha2" placeholder="Repetir Senha">
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-4">
                    <div class="custom-control custom-radio">
                      <input class="custom-control-input" type="radio" id="administrador" name="tipo_usuario" value=1 <?= ($row['tipoUsuario'] == 1) ? 'checked' : '' ?>>
                      <label for="administrador" class="custom-control-label">Administrador</label>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="custom-control custom-radio">
                      <input class="custom-control-input" type="radio" id="coordenador" name="tipo_usuario" value=0 <?= ($row['tipoUsuario'] == 0) ? 'checked' : '' ?>>
                      <label for="coordenador" class="custom-control-label">Coordenador</label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer">
                <button type="submit" class="btn btn-primary" id="editar" name="editar" onclick="<script> </script>">Editar</button>
              </div>
            </form>
          </div><?php } ?>
      </div>
    </section>
  </div>


  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- ChartJS -->
  <script src="plugins/chart.js/Chart.min.js"></script>
  <!-- Sparkline -->
  <script src="plugins/sparklines/sparkline.js"></script>
  <!-- JQVMap -->
  <script src="plugins/jqvmap/jquery.vmap.min.js"></script>
  <script src="plugins/jqvmap/maps/jquery.vmap.world.js"></script>
  <!-- jQuery Knob Chart -->
  <script src="plugins/jquery-knob/jquery.knob.min.js"></script>
  <!-- daterangepicker -->
  <script src="plugins/moment/moment.min.js"></script>
  <script src="plugins/daterangepicker/daterangepicker.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <!-- Summernote -->
  <script src="plugins/summernote/summernote-bs4.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.js"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="dist/js/pages/dashboard.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="dist/js/demo.js"></script>

</body>

</html>