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


    <script language="JavaScript">
        /*function alteraMascara() {  

      var cidr=document.getElementById("cidr").value;
      var mascara ="";

      for(var i=1;i<=32;i++)
      {
        if(i<cidr)
          mascara = mascara+1;

        
      }

      alert(mascara);

      document.getElementById("mascara").value = mascara;
    }*/
    </script>

    <script type="text/javascript">
        $("#ip").mask("999.999.999.999");
        $("#cidr").mask("99");
        $("#mascara").mask("999.999.999.999");
    </script>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <?php require '../config.php';
    session_start();
    if (!isset($_SESSION["id"])) {
        echo "<script>window.location.href='./login.php';</script>";
    }
    telaInicial();
    ?>
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <?php require '../back/function/ativo_function.php';
                if (!isset($_GET['funcao'])) {
                    $_GET['funcao'] = 'cadastrar';
                }
                if ($_GET['funcao'] == 'cadastrar') { ?>
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Cadastro de Ativos</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="index.php">Início</a></li>
                                <li class="breadcrumb-item"><a href="visualiza_campus.php">Visualizar Campus</a></li>
                                <li class="breadcrumb-item"><a href=<?php echo "visualiza_ativo?campus=" . $_GET['campus'] . ""; ?>>Visualizar Ativos</a></li>
                                <li class="breadcrumb-item active">Cadastro de Ativo</li>
                            </ol>
                        </div>
                    </div>
                    <div class="card card-primary">
                        <form method="POST" action="<?php echo "../back/ativo_back.php?funcao=cadastrar&campus=" . $_GET['campus'] . ""; ?>">
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label for="equip">Equipamento</label>
                                            <select class="custom-select" name="equip">
                                                <?php criaCombobox($connect, null); ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="local">Local</label>
                                            <input type="text" class="form-control" id="local" name="local" maxlength="30" placeholder="Local">
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="ip">IP</label>
                                            <input type="text" class="form-control" id="ip" name="ip" maxlenght="15" placeholder="Ex.: 000.000.000.000">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label for="nome">Nome</label>
                                            <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="usuario">Usuário</label>
                                            <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuário">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="senha">Senha</label>
                                            <input type="text" class="form-control" id="senha" name="senha" placeholder="Senha">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary" id="salvar" name="salvar">Salvar</button>
                                </div>
                        </form>
                    </div>
                <?php } else {
                    $row = voltarAtivo($pdo, $_GET['id']);
                    ?>
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Editar Ativos</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="index.php">Início</a></li>
                                <li class="breadcrumb-item"><a href="visualiza_campus.php?">Visualizar Campus</a></li>
                                <li class="breadcrumb-item"><a href=<?php echo "visualiza_ativo?campus=" . $_GET['campus'] . ""; ?>>Visualizar Ativos</a></li>
                                <li class="breadcrumb-item active">Editar Ativo</li>
                            </ol>
                        </div>
                    </div>
                    <div class="card card-primary">
                        <form method="POST" action="<?php echo "../back/ativo_back.php?funcao=editar&campus=" . $_GET['campus'] . "&id=".$_GET['id']; ?>">
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label for="equip">Equipamento</label>
                                            <select class="custom-select" name="equip">
                                                <?php criaCombobox($connect, $_GET['id']); ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="local">Local</label>
                                            <input type="text" class="form-control" id="local" name="local" maxlength="30" placeholder="Local" value="<?php echo $row['local'] ?>">
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="ip">IP</label>
                                            <input type="text" class="form-control" id="ip" name="ip" maxlenght="15" placeholder="Ex.: 000.000.000.000" value="<?php echo $row['ip'] ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label for="nome">Nome</label>
                                            <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome" value="<?php echo $row['nome'] ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="usuario">Usuário</label>
                                            <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuário" value="<?php echo $row['usuario'] ?>">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="senha">Senha</label>
                                            <input type="text" class="form-control" id="senha" name="senha" placeholder="Senha" value="<?php echo $row['senha'] ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary" id="editar" name="editar">Editar</button>
                                </div>
                        </form>
                    </div>
                <?php } ?>
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
    <script src="../../plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="dist/js/pages/dashboard.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>

    <!-- Select2 -->
    <script src="plugins/select2/js/select2.full.min.js"></script>
    <!-- Bootstrap4 Duallistbox -->
    <script src="plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
    <!-- InputMask -->
    <script src="plugins/inputmask/jquery.inputmask.bundle.js"></script>
    <script src="plugins/moment/moment.min.js"></script>
    <!-- date-range-picker -->
    <script src="plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
</body>

</html>