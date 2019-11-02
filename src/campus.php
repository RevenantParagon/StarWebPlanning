<!DOCTYPE html>

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
      if (document.frmCampus.campus.value == "") {
        //Swal.fire('Erro na Inserção','O prontuário está em branco!','error');
        alert('O campus está em branco!');
        document.frmCampus.campus.focus();
        return false;
      }
      if (document.frmCampus.sigla.value == "") {
        //Swal.fire('Erro na Inserção','O nome está em branco!','error');
        alert('A sigla está em branco!');
        document.frmCampus.sigla.focus();
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
  verificaAcesso(basename(__FILE__));
  ?>
  <div class="content-wrapper">
    <section class="content">
      <div class="container-fluid">
        <?php require '../back/function/campus_function.php';
        if (!isset($_GET['funcao'])) {
          $_GET['funcao'] = 0;
        }
        if ($_GET['funcao'] == 0) { ?>
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Cadastro de Campus</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">Início</a></li>
                <li class="breadcrumb-item active">Cadastro de Campus</li>
              </ol>
            </div>
          </div>
          <div class="card card-primary">
            <form method="POST" action="../back/campus_back.php?tipo=cadastrar" onSubmit="return verificarInformacoes();" name="frmCampus">
              <div class="card-body">
                <div class="form-group">
                  <label for="campus">Campus</label>
                  <input type="text" class="form-control" id="campus" name="campus" maxlength="30" placeholder="Campus">
                </div>
                <div class="form-group">
                  <label for="sigla">Sigla</label>
                  <input type="text" class="form-control" id="sigla" name="sigla" maxlength="3" placeholder="Sigla" style="text-transform:uppercase">
                </div>
                <div class="form-group">
                  <label for="ip">IP</label>
                  <input type="text" class="form-control" id="ip" name="ip" maxlength="15" placeholder="IP">
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary" id="cadastrar" name="cadastrar">Cadastrar</button>
                </div>
              </div>
            </form>
          </div>
        <?php } else {
          $row = voltarCampus($pdo, $_GET['id']);
          ?>
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Editar Campus</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">Início</a></li>
                <li class="breadcrumb-item active">Editar Campus</li>
              </ol>
            </div>
          </div>
          <div class="card card-primary">
            <form method="POST" action=<?php echo "../back/campus_back.php?tipo=editar&id=" . $_GET['id'] . ""; ?> onSubmit="return verificarInformacoes();" name="frmCampus">
              <div class="card-body">
                <div class="form-group">
                  <label for="nome">Campus</label>
                  <input type="text" class="form-control" id="campus" name="campus" placeholder="Campus" maxlength="30" value="<?php echo $row['campus'] ?>">
                </div>
                <div class="form-group">
                  <label for="email">Sigla</label>
                  <input type="text" class="form-control" id="sigla" name="sigla" placeholder="Sigla" maxlength="3" style="text-transform:uppercase" value="<?php echo $row['sigla'] ?>">
                </div>
                <div class="form-group">
                  <label for="ip">IP</label>
                  <input type="text" class="form-control" id="ip" name="ip" maxlength="15" placeholder="IP" value="<?php echo $row['ip'] ?>">
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