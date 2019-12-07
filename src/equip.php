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
            if (document.frmEquipamento.marca.value == "") {
                //Swal.fire('Erro na Inserção','O prontuário está em branco!','error');
                alert('A marca está em branco!');
                document.frmEquipamento.marca.focus();
                return false;
            }
            if (document.frmEquipamento.modelo.value == "") {
                //Swal.fire('Erro na Inserção','O nome está em branco!','error');
                alert('O modelo está em branco!');
                document.frmEquipamento.modelo.focus();
                return false;
            }
            if (document.frmEquipamento.qtde_porta.value == "") {
                //Swal.fire('Erro na Inserção','O prontuário está em branco!','error');
                alert('A quantidade de portas está em branco!');
                document.frmEquipamento.qtde_porta.focus();
                return false;
            }
            if (document.frmEquipamento.tipo.value == "") {
                //Swal.fire('Erro na Inserção','O prontuário está em branco!','error');
                alert('O tipo de equipamento está em branco!');
                document.frmEquipamento.tipo.focus();
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
    ?>
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <?php require '../back/function/equip_function.php';
                if (!isset($_GET['funcao'])) {
                    $_GET['funcao'] = 'cadastrar';
                }
                if ($_GET['funcao'] == 'cadastrar') { ?>
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Cadastro de Equipamentos</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="index.php">Início</a></li>
                                <li class="breadcrumb-item active">Cadastro de Equipamentos</li>
                            </ol>
                        </div>
                    </div>
                    <div class="card card-primary">
                        <form method="POST" action="../back/equip_back.php?funcao=cadastrar" onSubmit="return verificarInformacoes();" name="frmEquipamento">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <div class="form-group">
                                            <label for="marca">Marca</label>
                                            <input type="text" class="form-control" id="marca" name="marca" maxlength="50" placeholder="Marca">
                                        </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="form-group">
                                            <label for="modelo">Modelo</label>
                                            <input type="text" class="form-control" id="modelo" name="modelo" maxlength="50" placeholder="Modelo">
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label for="qtde_porta">Nº de Portas</label>
                                            <input type="text" class="form-control" id="qtde_porta" name="qtde_porta" maxlength="2" placeholder="Nº de Portas">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Tipo de Equipamento</label>
                                    <select class="custom-select" name="tipo">
                                        <option value="0">Switch</option>
                                        <option value="1">Pabx</option>
                                        <option value="2">Controlador de Wifi</option>
                                        <option value="3">Roteador</option>
                                        <option value="4">Firewall</option>
                                    </select>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Disposição das Portas</h3>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label for="linha">Número de Linhas</label>
                                            <input type="number" class="form-control" id="linha" name="linha" maxlength="1" value='1'>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" id="lado_esq" name="lado" value=E checked>
                                                <label for="lado_esq" class="custom-control-label">Esquerda para Direira</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" id="ordem_cima" name="ordem" value=C checked>
                                                <label for="ordem_cima" class="custom-control-label">Cima para Baixo</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" id="direcao_linha" name="direcao" value=L checked>
                                                <label for="direcao_linha" class="custom-control-label">Em linha</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" id="lado_dir" name="lado" value=D>
                                                <label for="lado_dir" class="custom-control-label">Direira para Esquerda</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" id="ordem_baixo" name="ordem" value=B>
                                                <label for="ordem_baixo" class="custom-control-label">Baixo para Cima</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" id="direcao_coluna" name="direcao" value=C>
                                                <label for="direcao_coluna" class="custom-control-label">Em coluna</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary" id="cadastrar" name="cadastrar">Cadastrar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                <?php } else {
                    $row = voltarEquip($pdo, $_GET['id']);
                    ?>
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Cadastro de Equipamentos</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="index.php">Início</a></li>
                                <li class="breadcrumb-item active">Cadastro de Equipamentos</li>
                            </ol>
                        </div>
                    </div>
                    <div class="card card-primary">
                        <form method="POST" action=<?php echo "../back/equip_back.php?funcao=editar&id=" . $_GET['id'] . ""; ?> onSubmit="return verificarInformacoes();" name="frmEquipamento">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <div class="form-group">
                                            <label for="marca">Marca</label>
                                            <input type="text" class="form-control" id="marca" name="marca" maxlength="50" placeholder="Marca" value="<?php echo $row['marca'] ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="form-group">
                                            <label for="modelo">Modelo</label>
                                            <input type="text" class="form-control" id="modelo" name="modelo" maxlength="50" placeholder="Modelo" value="<?php echo $row['modelo'] ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label for="qtde_porta">Nº de Portas</label>
                                            <input type="text" class="form-control" id="qtde_porta" name="qtde_porta" maxlength="2" placeholder="Nº de Portas" value="<?php echo $row['porta'] ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Tipo de Equipamento</label>
                                    <select class="custom-select" name="tipo">
                                        <option value="0">Switch</option>
                                        <option value="1">Pabx</option>
                                        <option value="2">Controlador de Wifi</option>
                                        <option value="3">Roteador</option>
                                        <option value="4">Firewall</option>
                                    </select>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Disposição das Portas</h3>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label for="linha">Número de Linhas</label>
                                            <input type="number" class="form-control" id="linha" name="linha" maxlength="1" value="<?php echo $row['linha'] ?>">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" id="lado_esq" name="lado" value=E <?= ($row['lado'] == 'E') ? 'checked' : '' ?>>
                                                <label for="lado_esq" class="custom-control-label">Esquerda para Direira</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" id="ordem_cima" name="ordem" value=C <?= ($row['ordem'] == 'C') ? 'checked' : '' ?>>
                                                <label for="ordem_cima" class="custom-control-label">Cima para Baixo</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" id="direcao_linha" name="direcao" value=L <?= ($row['direcao'] == 'L') ? 'checked' : '' ?>>
                                                <label for="direcao_linha" class="custom-control-label">Em linha</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" id="lado_dir" name="lado" value=D <?= ($row['lado'] == 'D') ? 'checked' : '' ?>>
                                                <label for="lado_dir" class="custom-control-label">Direira para Esquerda</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" id="ordem_baixo" name="ordem" value=B <?= ($row['ordem'] == 'B') ? 'checked' : '' ?>>
                                                <label for="ordem_baixo" class="custom-control-label">Baixo para Cima</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" id="direcao_coluna" name="direcao" value=C <?= ($row['direcao'] == 'C') ? 'checked' : '' ?>>
                                                <label for="direcao_coluna" class="custom-control-label">Em coluna</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary" id="editar" name="editar">Editar</button>
                                </div>
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