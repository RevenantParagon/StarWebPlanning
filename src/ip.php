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

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js" type="text/javascript"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js" type="text/javascript"></script>

  <script>
    function verificarInformacoes() {
      if (document.frmIP.nome.value == "") {
        //Swal.fire('Erro na Inserção','O prontuário está em branco!','error');
        alert('O nome está em branco!');
        document.frmIP.nome.focus();
        return false;
      }
      if (document.frmIP.ip.value == "") {
        //Swal.fire('Erro na Inserção','O nome está em branco!','error');
        alert('O IP da rede está em branco!');
        document.frmIP.ip.focus();
        return false;
      }
      if (document.frmIP.cidr.value == "") {
        //Swal.fire('Erro na Inserção','O prontuário está em branco!','error');
        alert('A máscara CIDR está em branco!');
        document.frmIP.cidr.focus();
        return false;
      }
      if (document.frmIP.cidr.value > 30 || document.frmIP.cidr.value < 24) {
        //Swal.fire('Erro na Inserção','O nome está em branco!','error');
        alert('A máscara de rede possui uma faixa de ips incorreta!');
        document.frmIP.cidr.focus();
        return false;
      }
      return true;
    }
  </script>

  <script type="text/javascript">
    function tornarTabelaEditavel(tabela) {
      // Obtém todas as tds da tabela fornecida.
      var tdlist = tabela.getElementsByTagName("td");

      for (var i = 0; tdlist[i]; i++) {
        // Adiciona o evento double click em cada td da tabela.
        tdlist[i].onclick = function() {
          // Se for texto, muda para input.
          if (this.firstChild.nodeType == 3) {
            // Cria um campo de texto editável e insere o valor da td nesse campo.
            var campo = document.createElement("input");
            campo.value = this.firstChild.nodeValue;

            // Substitui o texto da td pelo campo.
            this.replaceChild(campo, this.firstChild);

            campo.select();

            // Faz o processo inverso ao perder o foco.
            campo.onblur = function() {
              this.parentNode.replaceChild(document.createTextNode(this.value), this);
            }
          }
        }
      }
    }
    window.onload = function() {
      tornarTabelaEditavel(document.getElementById('tabela'));
    }
  </script>

  <script type="text/javascript">
    $(".ip").mask("999.999.999.999");
    $(".cidr").mask("99");
    //$(".mascara").mask("999.999.999.999");
  </script>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <?php require '../config.php';
  session_start();
  if (!isset($_SESSION["id"])) {
    echo "<script>window.location.href='./login.php';</script>";
  }
  if ($_SESSION["tipo"] != 1 && $_GET["campus"] != $_SESSION["campus"])
        echo "<script>window.location.href='./visualiza_ip.php?campus=".$_SESSION["campus"]."';</script>";
  telaInicial();
  ?>

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Provedores</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Início</a></li>
              <li class="breadcrumb-item"><a href="./visualiza_campus.php">Visualiza Campus</a></li>
              <li class="breadcrumb-item active">Provedores</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <?php
    require '../back/function/ip_function.php';

    if (!isset($_GET["campus"])) {
      echo "<script>window.location.href='./visualiza_campus.php';</script>";
    }

    $q = mysqli_query($connect, "SELECT proId 'ID', proNome 'Nome', proIp 'IP', proMascara 'Mascara' FROM tb_provedor where camId = " . $_GET['campus']);

    if (mysqli_num_rows($q) > 0) {
      while ($row = mysqli_fetch_array($q)) {
        $ip = new calc_ipv4($row['IP'] . "/" . $row['Mascara']);
        ?>
        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-md-12">
              <div class="card card-primary collapsed-card">
                <div class="card-header">
                  <h3 class="card-title"><?php echo $row['Nome']; ?></h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                      <i class="fas fa-plus"></i></button>
                  </div>
                </div>
                <div class="card-body">
                  <form method="POST" name="frmIP" onSubmit="return verificarInformacoes();" action=<?php echo "../back/ip_back.php?funcao=editar&campus=" . $_GET['campus'] . "&id=" . $row['ID'] . ""; ?>>
                    <div class="form-group">
                      <label for="nome">Provedor</label>
                      <input type="text" id="nome" name="nome" class="form-control" value="<?php echo $row['Nome']; ?>">
                    </div>
                    <div class="row">
                      <div class="col-md-4">
                        <label>IP</label>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <input type="text" id="ip" name="ip" class="form-control" placeholder="Ex.: 000.000.000.000" value="<?php echo $row['IP']; ?>">
                        </div>
                      </div>
                      <span><b>/</b></span>
                      <div class="col-md-1">
                        <div class="form-group">
                          <input type="text" id="cidr" name="cidr" class="form-control" placeholder="Ex.: 00" value="<?php echo $row['Mascara']; ?>">
                        </div>
                      </div>
                      <div class="col-2">
                        <input type="submit" value="Salvar Provedor" class="btn btn-success">
                      </div>
                      <div class="col-2">
                        <a href=<?php echo "../back/ip_back.php?funcao=deletar&campus=" . $_GET['campus'] . "&id=" . $row['ID'] . ""; ?> class="btn btn-secondary">Deletar</a>
                      </div>
                    </div>
                  </form>
                  <div class="row">
                    <div class="col-12">
                      <div class="card">
                        <div class="card-header">
                          <h3 class="card-title">Ips Válidos</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                          <table id="tabela" class="table table-hover">
                            <thead>
                              <tr>
                                <th>IP</th>
                                <th>Máscara</th>
                                <th>Gateway</th>
                                <th>Uso</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <?php buscarIP($connect, $pdo, $row['ID'], $row['Mascara']) ?>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <!-- /.card-body -->
                      </div>
                      <!-- /.card -->
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-2">
                      <input type="submit" value="Salvar IPs" class="btn btn-success float-left">
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </section>
    <?php
      }
    }
    ?>
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="card card-primary collapsed-card">
            <div class="card-header">
              <h3 class="card-title">Add Provedor</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-plus"></i></button>
              </div>
            </div>
            <div class="card-body">
              <form method="POST" name="frmIP" onSubmit="return verificarInformacoes();" action=<?php echo "../back/ip_back.php?funcao=cadastrar&campus=" . $_GET['campus'] . ""; ?>>
                <div class="form-group">
                  <label for="inputName">Provedor</label>
                  <input type="text" id="inputName" class="form-control" name="nome">
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <label>IP</label>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <input type="text" id="ip" class="form-control" placeholder="Ex.: 000.000.000.000" name="ip">
                    </div>
                  </div>
                  <span><b>/</b></span>
                  <div class="col-md-1">
                    <div class="form-group">
                      <input type="text" id="cidr" class="form-control" placeholder="Ex.: 00" name="cidr">
                    </div>
                  </div>
                </div>
                <div class="col-2">
                  <input type="submit" value="Salvar Provedor" class="btn btn-success" name="salvar" id="salvar">
                </div>
              </form>
              <div class="row">
                <div class="col-12">
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Ips Válidos</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                      <table id="tabela" class="table table-hover">
                        <thead>
                          <tr>
                            <th>IP</th>
                            <th>Máscara</th>
                            <th>Gateway</th>
                            <th>Uso</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <!-- /.card-body -->
                  </div>
                  <!-- /.card -->
                </div>
              </div>
            </div>
          </div>
        </div>
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