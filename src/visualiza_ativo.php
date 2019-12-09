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

    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.css">
    <script type="text/javascript" language="javascript">
        function retorno(id) {
            return document.getElementsByName(id).value;
        }
    </script>
    <script>
        <?php require '../back/function/ativo_function.php'; ?>

        function chamaFuncao(tipo) {
            if (tipo === '1') {
                document.getElementById("propriedade").innerHTML = "";
                $('#propriedade').append('<label for="provedor" class="col-form-label">IP de Provedores:</label><select class="custom-select" name="provedor"><?php criaComboboxProvedor($connect, 2) ?></select>'); // ADICIONA OS ELEMENTOS NA DIV
            } else if (tipo === '2') {
                document.getElementById("propriedade").innerHTML = "";
                $('#propriedade').append('<label for="ativo" class="col-form-label">Porta a vincular:</label><div class="row"><div class="col-9"><select class="custom-select" name="ativo"><?php criaComboboxAtivos($connect, 1) ?></select></div><div class="col-3"><input type="number" class="form-control" id="vinculaPorta" name="vinculaPorta" placeholder="Porta"/></div></div>'); // ADICIONA OS ELEMENTOS NA DIV
            } else if (tipo === '3') {
                document.getElementById("propriedade").innerHTML = "";
                $('#propriedade').append('<input type="text" id="outros" name="outros"  class="form-control" placeholder="Outros"/>'); // ADICIONA OS ELEMENTOS NA DIV
            } else {
                document.getElementById("propriedade").innerHTML = "";
            }
        }

        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })

        $('#link').tooltip({
            boundary: 'window'
        })
    </script>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <?php
    session_start();
    if (!isset($_SESSION["id"])) {
        echo "<script>window.location.href='./login.php';</script>";
    }
    if ($_SESSION["tipo"] != 1 && $_GET["campus"] != $_SESSION["campus"])
        echo "<script>window.location.href='./visualiza_ativo.php?campus=" . $_SESSION["campus"] . "';</script>";
    telaInicial(); ?>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Visualizar Ativos</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="index.php">Início</a></li>
                            <li class="breadcrumb-item"><a href="visualiza_campus.php">Visualizar Campus</a></li>
                            <li class="breadcrumb-item active">Visualizar Ativos</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Ativos</h3>
                            <div class="float-right">
                                <form method="POST" action=<?php echo "./ativo.php?funcao=cadastrar&campus=" . $_GET['campus'] . ""; ?>>
                                    <button type="submit" class="btn btn-primary">Inserir</button>
                                </form>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php
                            require '../back/function/equip_function.php';
                            $select = "select atiId 'id', atiLocal 'local',atiIP 'ip', atiNome 'nome', atiUsuario 'usuario', atiSenha 'senha', equId 'equip' from tb_ativo where camId=:id";

                            $stmt = $pdo->prepare($select);

                            $stmt->bindValue(":id", $_GET['campus']);

                            $stmt->execute();

                            if ($stmt->rowcount() > 0) {
                                //while ($row = $stmt->fetchAll()) {
                                $return = $stmt->fetchAll();
                                foreach ($return as &$row) {
                                    $equip = voltarEquip($pdo, $row['equip']);
                                    ?>
                                    <div class="card" style="overflow: auto;">
                                        <div class="row">
                                            <h3 style="margin:20px"><?php echo $row['nome'] ?></h3>
                                            <!--data-widget="control-sidebar" data-slide="true"-->
                                            <a href="<?php echo "./ativo.php?funcao=editar&campus=" . $_GET['campus'] . "&id=" . $row['id'] . ""; ?>" style="margin:10px">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="<?php echo "../back/ativo_back.php?funcao=deletar&campus=" . $_GET['campus'] . "&id=" . $row['id'] . ""; ?>" style="margin:10px">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </div>
                                        <form action="./visualiza_campus.php" method=POST>
                                            <table id="example1" class="table table-bordered table-striped">
                                                <?php
                                                        $cor = "#FFFFFF";

                                                        if ($equip['direcao'] === 'C') {
                                                            if ($equip['lado'] === 'E') {
                                                                for ($j = 0; $j < $equip['linha']; $j++) {
                                                                    //Coluna - Esquerda - Baixo
                                                                    if ($equip['ordem'] === 'B') {
                                                                        for ($i = $equip['linha'] - $j - 1; $i < $equip['porta']; $i += $equip['linha']) {
                                                                            $insert = "select porId 'id',porTipo 'tipo',porMac 'mac', porIP 'ip', porObs 'obs', proId, (select proNome from tb_provedor pr where pr.proId = p.proId) as 'proNome', (select porIdVinculada from tb_porta_porta pp where pp.porId = p.porId) as 'porVinculada' from tb_porta p where porNumero=:porta and atiId=:atiId";
                                                                            $cor = "#FFFFFF";
                                                                            $stmt = $pdo->prepare($insert);

                                                                            $stmt->bindValue(":porta", $i);
                                                                            $stmt->bindValue(":atiId", $row['id']);

                                                                            $stmt->execute();

                                                                            if ($stmt->rowcount() > 0) {
                                                                                $porta = $stmt->fetch();
                                                                                $vlans = retornaVlan($pdo, $porta['id']);
                                                                                $descricao = "";
                                                                                $descricaoVlans = "";
                                                                                $portaVinculada = null;
                                                                                $atiId = null;

                                                                                if (strpos($vlans['id'], ",") === false)
                                                                                    $cor = $vlans['cor'];

                                                                                if ($vlans['id'] != "")
                                                                                    $descricaoVlans = "<br> " . $vlans['id'];

                                                                                if ($porta['tipo'] == 3) {
                                                                                    $descricao = "<br> ";
                                                                                    $descricao .= $porta['obs'];
                                                                                } else if ($porta['tipo'] == 2) {
                                                                                    $q = mysqli_query($connect, "SELECT p.porNumero 'porta', a.atiId 'atiId', a.atiNome 'nome' FROM tb_ativo a, tb_porta p WHERE p.atiId=a.atiId and p.porId='" . $porta['porVinculada'] . "'");
                                                                                    if (mysqli_num_rows($q) > 0) {
                                                                                        $descricao = "<br>";
                                                                                        $vinculo = mysqli_fetch_array($q);
                                                                                        $descricao .= $vinculo['nome'] . " to port " . $vinculo['porta'];
                                                                                        $portaVinculada = $vinculo['porta'];
                                                                                        $atiId = $vinculo['atiId'];
                                                                                    } else
                                                                                        $descricao = "";
                                                                                } else if ($porta['tipo'] == 1) {
                                                                                    $descricao = "<br>";
                                                                                    $descricao .= $porta['proNome'];
                                                                                }

                                                                                echo '<th style="background: ' . $cor . '" width="5%"><a href="#" id="link" title="MAC: ' . $porta['mac'] . "\n" . 'IP: ' . $porta['ip'] . '" onclick=chamarPorta("' . $i . '|' . $porta['tipo'] . '|' . $vlans['id'] . '","' . $porta['obs'] . '|' . $porta['mac'] . '|' . $porta['ip'] . '","' . $porta['id'] . '|' . $portaVinculada . '|' . $atiId . '") data-toggle="modal" data-target="#exampleModal" id="porta">Porta ' . $i . "" . $descricao . "" . $descricaoVlans . '</a></th>';
                                                                            } else
                                                                                echo '<th style="background: ' . $cor . '" width="5%"><a href="#" onclick=chamarPorta("' . $i . '|0|","||","||") data-toggle="modal" data-target="#exampleModal" id="porta">Porta ' . $i . '</a></th>';
                                                                        }
                                                                        //Coluna - Esquerda - Cima
                                                                    } else {
                                                                        for ($i = $j; $i < $equip['porta']; $i += $equip['linha']) {
                                                                            $insert = "select porId 'id',porTipo 'tipo',porMac 'mac', porIP 'ip', porObs 'obs', proId, (select proNome from tb_provedor pr where pr.proId = p.proId) as 'proNome', (select porIdVinculada from tb_porta_porta pp where pp.porId = p.porId) as 'porVinculada' from tb_porta p where porNumero=:porta and atiId=:atiId";
                                                                            $cor = "#FFFFFF";
                                                                            $stmt = $pdo->prepare($insert);

                                                                            $stmt->bindValue(":porta", $i);
                                                                            $stmt->bindValue(":atiId", $row['id']);

                                                                            $stmt->execute();

                                                                            if ($stmt->rowcount() > 0) {
                                                                                $porta = $stmt->fetch();
                                                                                $vlans = retornaVlan($pdo, $porta['id']);
                                                                                $descricao = "";
                                                                                $descricaoVlans = "";
                                                                                $portaVinculada = null;
                                                                                $atiId = null;

                                                                                if (strpos($vlans['id'], ",") === false)
                                                                                    $cor = $vlans['cor'];

                                                                                if ($vlans['id'] != "")
                                                                                    $descricaoVlans = "<br> " . $vlans['id'];

                                                                                if ($porta['tipo'] == 3) {
                                                                                    $descricao = "<br> ";
                                                                                    $descricao .= $porta['obs'];
                                                                                } else if ($porta['tipo'] == 2) {
                                                                                    $q = mysqli_query($connect, "SELECT p.porNumero 'porta', a.atiId 'atiId', a.atiNome 'nome' FROM tb_ativo a, tb_porta p WHERE p.atiId=a.atiId and p.porId='" . $porta['porVinculada'] . "'");
                                                                                    if (mysqli_num_rows($q) > 0) {
                                                                                        $descricao = "<br>";
                                                                                        $vinculo = mysqli_fetch_array($q);
                                                                                        $descricao .= $vinculo['nome'] . " to port " . $vinculo['porta'];
                                                                                        $portaVinculada = $vinculo['porta'];
                                                                                        $atiId = $vinculo['atiId'];
                                                                                    } else
                                                                                        $descricao = "";
                                                                                } else if ($porta['tipo'] == 1) {
                                                                                    $descricao = "<br>";
                                                                                    $descricao .= $porta['proNome'];
                                                                                }

                                                                                echo '<th style="background: ' . $cor . '" width="5%"><a href="#" id="link" title="MAC: ' . $porta['mac'] . "\n" . 'IP: ' . $porta['ip'] . '" onclick=chamarPorta("' . $i . '|' . $porta['tipo'] . '|' . $vlans['id'] . '","' . $porta['obs'] . '|' . $porta['mac'] . '|' . $porta['ip'] . '","' . $porta['id'] . '|' . $portaVinculada . '|' . $atiId . '") data-toggle="modal" data-target="#exampleModal" id="porta">Porta ' . $i . "" . $descricao . "" . $descricaoVlans . '</a></th>';
                                                                            } else
                                                                                echo '<th style="background: ' . $cor . '" width="5%"><a href="#" onclick=chamarPorta("' . $i . '|0|","||","||") data-toggle="modal" data-target="#exampleModal" id="porta">Porta ' . $i . '</a></th>';
                                                                        }
                                                                    }
                                                                    echo '</tr>';
                                                                }
                                                            } else {
                                                                for ($j = $equip['linha']; $j > 0; $j--) {
                                                                    //Coluna - Direita - Baixo
                                                                    if ($equip['ordem'] === 'B') {
                                                                        for ($i = $equip['porta'] - ($equip['linha'] - $j) - 1; $i >= 0; $i -= $equip['linha']) {
                                                                            $insert = "select porId 'id',porTipo 'tipo',porMac 'mac', porIP 'ip', porObs 'obs', proId, (select proNome from tb_provedor pr where pr.proId = p.proId) as 'proNome', (select porIdVinculada from tb_porta_porta pp where pp.porId = p.porId) as 'porVinculada' from tb_porta p where porNumero=:porta and atiId=:atiId";
                                                                            $cor = "#FFFFFF";
                                                                            $stmt = $pdo->prepare($insert);

                                                                            $stmt->bindValue(":porta", $i);
                                                                            $stmt->bindValue(":atiId", $row['id']);

                                                                            $stmt->execute();

                                                                            if ($stmt->rowcount() > 0) {
                                                                                $porta = $stmt->fetch();
                                                                                $vlans = retornaVlan($pdo, $porta['id']);
                                                                                $descricao = "";
                                                                                $descricaoVlans = "";
                                                                                $portaVinculada = null;
                                                                                $atiId = null;

                                                                                if (strpos($vlans['id'], ",") === false)
                                                                                    $cor = $vlans['cor'];

                                                                                if ($vlans['id'] != "")
                                                                                    $descricaoVlans = "<br> " . $vlans['id'];

                                                                                if ($porta['tipo'] == 3) {
                                                                                    $descricao = "<br> ";
                                                                                    $descricao .= $porta['obs'];
                                                                                } else if ($porta['tipo'] == 2) {
                                                                                    $q = mysqli_query($connect, "SELECT p.porNumero 'porta', a.atiId 'atiId', a.atiNome 'nome' FROM tb_ativo a, tb_porta p WHERE p.atiId=a.atiId and p.porId='" . $porta['porVinculada'] . "'");
                                                                                    if (mysqli_num_rows($q) > 0) {
                                                                                        $descricao = "<br>";
                                                                                        $vinculo = mysqli_fetch_array($q);
                                                                                        $descricao .= $vinculo['nome'] . " to port " . $vinculo['porta'];
                                                                                        $portaVinculada = $vinculo['porta'];
                                                                                        $atiId = $vinculo['atiId'];
                                                                                    } else
                                                                                        $descricao = "";
                                                                                } else if ($porta['tipo'] == 1) {
                                                                                    $descricao = "<br>";
                                                                                    $descricao .= $porta['proNome'];
                                                                                }

                                                                                echo '<th style="background: ' . $cor . '" width="5%"><a href="#" id="link" title="MAC: ' . $porta['mac'] . "\n" . 'IP: ' . $porta['ip'] . '" onclick=chamarPorta("' . $i . '|' . $porta['tipo'] . '|' . $vlans['id'] . '","' . $porta['obs'] . '|' . $porta['mac'] . '|' . $porta['ip'] . '","' . $porta['id'] . '|' . $portaVinculada . '|' . $atiId . '") data-toggle="modal" data-target="#exampleModal" id="porta">Porta ' . $i . "" . $descricao . "" . $descricaoVlans . '</a></th>';
                                                                            } else
                                                                                echo '<th style="background: ' . $cor . '" width="5%"><a href="#" onclick=chamarPorta("' . $i . '|0|","||","||") data-toggle="modal" data-target="#exampleModal" id="porta">Porta ' . $i . '</a></th>';
                                                                        }
                                                                        //Coluna - Direita - Cima
                                                                    } else {
                                                                        for ($i = $equip['porta'] - $j; $i >= 0; $i -= $equip['linha']) {
                                                                            $insert = "select porId 'id',porTipo 'tipo',porMac 'mac', porIP 'ip', porObs 'obs', proId, (select proNome from tb_provedor pr where pr.proId = p.proId) as 'proNome', (select porIdVinculada from tb_porta_porta pp where pp.porId = p.porId) as 'porVinculada' from tb_porta p where porNumero=:porta and atiId=:atiId";
                                                                            $cor = "#FFFFFF";
                                                                            $stmt = $pdo->prepare($insert);

                                                                            $stmt->bindValue(":porta", $i);
                                                                            $stmt->bindValue(":atiId", $row['id']);

                                                                            $stmt->execute();

                                                                            if ($stmt->rowcount() > 0) {
                                                                                $porta = $stmt->fetch();
                                                                                $vlans = retornaVlan($pdo, $porta['id']);
                                                                                $descricao = "";
                                                                                $descricaoVlans = "";
                                                                                $portaVinculada = null;
                                                                                $atiId = null;

                                                                                if (strpos($vlans['id'], ",") === false)
                                                                                    $cor = $vlans['cor'];

                                                                                if ($vlans['id'] != "")
                                                                                    $descricaoVlans = "<br> " . $vlans['id'];

                                                                                if ($porta['tipo'] == 3) {
                                                                                    $descricao = "<br> ";
                                                                                    $descricao .= $porta['obs'];
                                                                                } else if ($porta['tipo'] == 2) {
                                                                                    $q = mysqli_query($connect, "SELECT p.porNumero 'porta', a.atiId 'atiId', a.atiNome 'nome' FROM tb_ativo a, tb_porta p WHERE p.atiId=a.atiId and p.porId='" . $porta['porVinculada'] . "'");
                                                                                    if (mysqli_num_rows($q) > 0) {
                                                                                        $descricao = "<br>";
                                                                                        $vinculo = mysqli_fetch_array($q);
                                                                                        $descricao .= $vinculo['nome'] . " to port " . $vinculo['porta'];
                                                                                        $portaVinculada = $vinculo['porta'];
                                                                                        $atiId = $vinculo['atiId'];
                                                                                    } else
                                                                                        $descricao = "";
                                                                                } else if ($porta['tipo'] == 1) {
                                                                                    $descricao = "<br>";
                                                                                    $descricao .= $porta['proNome'];
                                                                                }

                                                                                echo '<th style="background: ' . $cor . '" width="5%"><a href="#" id="link" title="MAC: ' . $porta['mac'] . "\n" . 'IP: ' . $porta['ip'] . '" onclick=chamarPorta("' . $i . '|' . $porta['tipo'] . '|' . $vlans['id'] . '","' . $porta['obs'] . '|' . $porta['mac'] . '|' . $porta['ip'] . '","' . $porta['id'] . '|' . $portaVinculada . '|' . $atiId . '") data-toggle="modal" data-target="#exampleModal" id="porta">Porta ' . $i . "" . $descricao . "" . $descricaoVlans . '</a></th>';
                                                                            } else
                                                                                echo '<th style="background: ' . $cor . '" width="5%"><a href="#" onclick=chamarPorta("' . $i . '|0|","||","||") data-toggle="modal" data-target="#exampleModal" id="porta">Porta ' . $i . '</a></th>';
                                                                        }
                                                                    }
                                                                    echo '</tr>';
                                                                }
                                                            }
                                                        } else {
                                                            if ($equip['ordem'] === 'C') {
                                                                $l = -1;
                                                                for ($j = 0; $j < $equip['linha']; $j++) {
                                                                    //Linha - Cima - Direita
                                                                    if ($equip['lado'] === 'D') {
                                                                        for ($i = (($equip['porta'] / $equip['linha']) * ($j + 1)) - 1; $i >= ($equip['porta'] / $equip['linha']) * $j; $i--) {
                                                                            $insert = "select porId 'id',porTipo 'tipo',porMac 'mac', porIP 'ip', porObs 'obs', proId, (select proNome from tb_provedor pr where pr.proId = p.proId) as 'proNome', (select porIdVinculada from tb_porta_porta pp where pp.porId = p.porId) as 'porVinculada' from tb_porta p where porNumero=:porta and atiId=:atiId";
                                                                            $cor = "#FFFFFF";
                                                                            $stmt = $pdo->prepare($insert);

                                                                            $stmt->bindValue(":porta", $i);
                                                                            $stmt->bindValue(":atiId", $row['id']);

                                                                            $stmt->execute();

                                                                            if ($stmt->rowcount() > 0) {
                                                                                $porta = $stmt->fetch();
                                                                                $vlans = retornaVlan($pdo, $porta['id']);
                                                                                $descricao = "";
                                                                                $descricaoVlans = "";
                                                                                $portaVinculada = null;
                                                                                $atiId = null;

                                                                                if (strpos($vlans['id'], ",") === false)
                                                                                    $cor = $vlans['cor'];

                                                                                if ($vlans['id'] != "")
                                                                                    $descricaoVlans = "<br> " . $vlans['id'];

                                                                                if ($porta['tipo'] == 3) {
                                                                                    $descricao = "<br> ";
                                                                                    $descricao .= $porta['obs'];
                                                                                } else if ($porta['tipo'] == 2) {
                                                                                    $q = mysqli_query($connect, "SELECT p.porNumero 'porta', a.atiId 'atiId', a.atiNome 'nome' FROM tb_ativo a, tb_porta p WHERE p.atiId=a.atiId and p.porId='" . $porta['porVinculada'] . "'");
                                                                                    if (mysqli_num_rows($q) > 0) {
                                                                                        $descricao = "<br>";
                                                                                        $vinculo = mysqli_fetch_array($q);
                                                                                        $descricao .= $vinculo['nome'] . " to port " . $vinculo['porta'];
                                                                                        $portaVinculada = $vinculo['porta'];
                                                                                        $atiId = $vinculo['atiId'];
                                                                                    } else
                                                                                        $descricao = "";
                                                                                } else if ($porta['tipo'] == 1) {
                                                                                    $descricao = "<br>";
                                                                                    $descricao .= $porta['proNome'];
                                                                                }

                                                                                echo '<th style="background: ' . $cor . '" width="5%"><a href="#" id="link" title="MAC: ' . $porta['mac'] . "\n" . 'IP: ' . $porta['ip'] . '" onclick=chamarPorta("' . $i . '|' . $porta['tipo'] . '|' . $vlans['id'] . '","' . $porta['obs'] . '|' . $porta['mac'] . '|' . $porta['ip'] . '","' . $porta['id'] . '|' . $portaVinculada . '|' . $atiId . '") data-toggle="modal" data-target="#exampleModal" id="porta">Porta ' . $i . "" . $descricao . "" . $descricaoVlans . '</a></th>';
                                                                            } else
                                                                                echo '<th style="background: ' . $cor . '" width="5%"><a href="#" onclick=chamarPorta("' . $i . '|0|","||","||") data-toggle="modal" data-target="#exampleModal" id="porta">Porta ' . $i . '</a></th>';
                                                                            $l = $i;
                                                                        }
                                                                        //Linha - Cima - Esquerda
                                                                    } else {
                                                                        for ($i = $l + 1; $i < ($equip['porta'] / $equip['linha']) * ($j + 1); $i++) {
                                                                            $insert = "select porId 'id',porTipo 'tipo',porMac 'mac', porIP 'ip', porObs 'obs', proId, (select proNome from tb_provedor pr where pr.proId = p.proId) as 'proNome', (select porIdVinculada from tb_porta_porta pp where pp.porId = p.porId) as 'porVinculada' from tb_porta p where porNumero=:porta and atiId=:atiId";
                                                                            $cor = "#FFFFFF";
                                                                            $stmt = $pdo->prepare($insert);

                                                                            $stmt->bindValue(":porta", $i);
                                                                            $stmt->bindValue(":atiId", $row['id']);

                                                                            $stmt->execute();

                                                                            if ($stmt->rowcount() > 0) {
                                                                                $porta = $stmt->fetch();
                                                                                $vlans = retornaVlan($pdo, $porta['id']);
                                                                                $descricao = "";
                                                                                $descricaoVlans = "";
                                                                                $portaVinculada = null;
                                                                                $atiId = null;

                                                                                if (strpos($vlans['id'], ",") === false)
                                                                                    $cor = $vlans['cor'];

                                                                                if ($vlans['id'] != "")
                                                                                    $descricaoVlans = "<br> " . $vlans['id'];

                                                                                if ($porta['tipo'] == 3) {
                                                                                    $descricao = "<br> ";
                                                                                    $descricao .= $porta['obs'];
                                                                                } else if ($porta['tipo'] == 2) {
                                                                                    $q = mysqli_query($connect, "SELECT p.porNumero 'porta', a.atiId 'atiId', a.atiNome 'nome' FROM tb_ativo a, tb_porta p WHERE p.atiId=a.atiId and p.porId='" . $porta['porVinculada'] . "'");
                                                                                    if (mysqli_num_rows($q) > 0) {
                                                                                        $descricao = "<br>";
                                                                                        $vinculo = mysqli_fetch_array($q);
                                                                                        $descricao .= $vinculo['nome'] . " to port " . $vinculo['porta'];
                                                                                        $portaVinculada = $vinculo['porta'];
                                                                                        $atiId = $vinculo['atiId'];
                                                                                    } else
                                                                                        $descricao = "";
                                                                                } else if ($porta['tipo'] == 1) {
                                                                                    $descricao = "<br>";
                                                                                    $descricao .= $porta['proNome'];
                                                                                }

                                                                                echo '<th style="background: ' . $cor . '" width="5%"><a href="#" id="link" title="MAC: ' . $porta['mac'] . "\n" . 'IP: ' . $porta['ip'] . '" onclick=chamarPorta("' . $i . '|' . $porta['tipo'] . '|' . $vlans['id'] . '","' . $porta['obs'] . '|' . $porta['mac'] . '|' . $porta['ip'] . '","' . $porta['id'] . '|' . $portaVinculada . '|' . $atiId . '") data-toggle="modal" data-target="#exampleModal" id="porta">Porta ' . $i . "" . $descricao . "" . $descricaoVlans . '</a></th>';
                                                                            } else
                                                                                echo '<th style="background: ' . $cor . '" width="5%"><a href="#" onclick=chamarPorta("' . $i . '|0|","||","||") data-toggle="modal" data-target="#exampleModal" id="porta">Porta ' . $i . '</a></th>';
                                                                            $l = $i;
                                                                        }
                                                                    }
                                                                    echo '</tr>';
                                                                }
                                                            } else {
                                                                $l = $equip['porta'];
                                                                for ($j = $equip['linha']; $j > 0; $j--) {
                                                                    //Linha - Baixo - Direita
                                                                    if ($equip['lado'] === 'D') {
                                                                        for ($i = $l - 1; $i >= $equip['porta'] / $equip['linha'] * ($j - 1); $i--) {
                                                                            $insert = "select porId 'id',porTipo 'tipo',porMac 'mac', porIP 'ip', porObs 'obs', proId, (select proNome from tb_provedor pr where pr.proId = p.proId) as 'proNome', (select porIdVinculada from tb_porta_porta pp where pp.porId = p.porId) as 'porVinculada' from tb_porta p where porNumero=:porta and atiId=:atiId";
                                                                            $cor = "#FFFFFF";
                                                                            $stmt = $pdo->prepare($insert);

                                                                            $stmt->bindValue(":porta", $i);
                                                                            $stmt->bindValue(":atiId", $row['id']);

                                                                            $stmt->execute();

                                                                            if ($stmt->rowcount() > 0) {
                                                                                $porta = $stmt->fetch();
                                                                                $vlans = retornaVlan($pdo, $porta['id']);
                                                                                $descricao = "";
                                                                                $descricaoVlans = "";
                                                                                $portaVinculada = null;
                                                                                $atiId = null;

                                                                                if (strpos($vlans['id'], ",") === false)
                                                                                    $cor = $vlans['cor'];

                                                                                if ($vlans['id'] != "")
                                                                                    $descricaoVlans = "<br> " . $vlans['id'];

                                                                                if ($porta['tipo'] == 3) {
                                                                                    $descricao = "<br> ";
                                                                                    $descricao .= $porta['obs'];
                                                                                } else if ($porta['tipo'] == 2) {
                                                                                    $q = mysqli_query($connect, "SELECT p.porNumero 'porta', a.atiId 'atiId', a.atiNome 'nome' FROM tb_ativo a, tb_porta p WHERE p.atiId=a.atiId and p.porId='" . $porta['porVinculada'] . "'");
                                                                                    if (mysqli_num_rows($q) > 0) {
                                                                                        $descricao = "<br>";
                                                                                        $vinculo = mysqli_fetch_array($q);
                                                                                        $descricao .= $vinculo['nome'] . " to port " . $vinculo['porta'];
                                                                                        $portaVinculada = $vinculo['porta'];
                                                                                        $atiId = $vinculo['atiId'];
                                                                                    } else
                                                                                        $descricao = "";
                                                                                } else if ($porta['tipo'] == 1) {
                                                                                    $descricao = "<br>";
                                                                                    $descricao .= $porta['proNome'];
                                                                                }

                                                                                echo '<th style="background: ' . $cor . '" width="5%"><a href="#" id="link" title="MAC: ' . $porta['mac'] . "\n" . 'IP: ' . $porta['ip'] . '" onclick=chamarPorta("' . $i . '|' . $porta['tipo'] . '|' . $vlans['id'] . '","' . $porta['obs'] . '|' . $porta['mac'] . '|' . $porta['ip'] . '","' . $porta['id'] . '|' . $portaVinculada . '|' . $atiId . '") data-toggle="modal" data-target="#exampleModal" id="porta">Porta ' . $i . "" . $descricao . "" . $descricaoVlans . '</a></th>';
                                                                            } else
                                                                                echo '<th style="background: ' . $cor . '" width="5%"><a href="#" onclick=chamarPorta("' . $i . '|0|","||","||") data-toggle="modal" data-target="#exampleModal" id="porta">Porta ' . $i . '</a></th>';
                                                                            $l = $i;
                                                                        }
                                                                        //Linha - Baixo - Esquerda
                                                                    } else {
                                                                        for ($i = $equip['porta'] / $equip['linha'] * ($j - 1); $i < $equip['porta'] / $equip['linha'] * $j; $i++) {
                                                                            $insert = "select porId 'id',porTipo 'tipo',porMac 'mac', porIP 'ip', porObs 'obs', proId, (select proNome from tb_provedor pr where pr.proId = p.proId) as 'proNome', (select porIdVinculada from tb_porta_porta pp where pp.porId = p.porId) as 'porVinculada' from tb_porta p where porNumero=:porta and atiId=:atiId";
                                                                            $cor = "#FFFFFF";
                                                                            $stmt = $pdo->prepare($insert);

                                                                            $stmt->bindValue(":porta", $i);
                                                                            $stmt->bindValue(":atiId", $row['id']);

                                                                            $stmt->execute();

                                                                            if ($stmt->rowcount() > 0) {
                                                                                $porta = $stmt->fetch();
                                                                                $vlans = retornaVlan($pdo, $porta['id']);
                                                                                $descricao = "";
                                                                                $descricaoVlans = "";
                                                                                $portaVinculada = null;
                                                                                $atiId = null;

                                                                                if (strpos($vlans['id'], ",") === false)
                                                                                    $cor = $vlans['cor'];

                                                                                if ($vlans['id'] != "")
                                                                                    $descricaoVlans = "<br> " . $vlans['id'];

                                                                                if ($porta['tipo'] == 3) {
                                                                                    $descricao = "<br> ";
                                                                                    $descricao .= $porta['obs'];
                                                                                } else if ($porta['tipo'] == 2) {
                                                                                    $q = mysqli_query($connect, "SELECT p.porNumero 'porta', a.atiId 'atiId', a.atiNome 'nome' FROM tb_ativo a, tb_porta p WHERE p.atiId=a.atiId and p.porId='" . $porta['porVinculada'] . "'");
                                                                                    if (mysqli_num_rows($q) > 0) {
                                                                                        $descricao = "<br>";
                                                                                        $vinculo = mysqli_fetch_array($q);
                                                                                        $descricao .= $vinculo['nome'] . " to port " . $vinculo['porta'];
                                                                                        $portaVinculada = $vinculo['porta'];
                                                                                        $atiId = $vinculo['atiId'];
                                                                                    } else
                                                                                        $descricao = "";
                                                                                } else if ($porta['tipo'] == 1) {
                                                                                    $descricao = "<br>";
                                                                                    $descricao .= $porta['proNome'];
                                                                                }

                                                                                echo '<th style="background: ' . $cor . '" width="5%"><a href="#" id="link" title="MAC: ' . $porta['mac'] . "\n" . 'IP: ' . $porta['ip'] . '" onclick=chamarPorta("' . $i . '|' . $porta['tipo'] . '|' . $vlans['id'] . '","' . $porta['obs'] . '|' . $porta['mac'] . '|' . $porta['ip'] . '","' . $porta['id'] . '|' . $portaVinculada . '|' . $atiId . '") data-toggle="modal" data-target="#exampleModal" id="porta">Porta ' . $i . "" . $descricao . "" . $descricaoVlans . '</a></th>';
                                                                            } else
                                                                                echo '<th style="background: ' . $cor . '" width="5%"><a href="#" onclick=chamarPorta("' . $i . '|0|","||","||") data-toggle="modal" data-target="#exampleModal" id="porta">Porta ' . $i . '</a></th>';
                                                                            $l = $i;
                                                                        }
                                                                    }
                                                                    echo '</tr>';
                                                                }
                                                            }
                                                        }
                                                        ?>
                                            </table>
                                        </form>
                                    </div>
                            <?php
                                }
                            }
                            ?>
                        </div>

                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <div id="titulo"></div>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div id="form"></div>

                                    <!--<form id="table">
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="tipo" class="col-form-label">Tipo de Conexão:</label>
                                                <select class="custom-select" id="tipo" name="tipo" onchange="javascript: chamaFuncao(this.value)">
                                                    <option value="0">Nenhuma</option>
                                                    <option value="1">Provedor</option>
                                                    <option value="2">Outra Porta</option>
                                                    <option value="3">Outros</option>
                                                </select>
                                            </div>
                                            <div class="form-group" id="propriedade">
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <label for="mac" class="col-form-label">MAC:</label>
                                                    <input type="text" class="form-control" id="mac" name="mac">
                                                </div>
                                                <div class="col-6">
                                                    <label for="ipPorta" class="col-form-label">IP:</label>
                                                    <input type="text" class="form-control" id="ipPorta" name="ipPorta">
                                                </div>
                                            </div>
                                            <label for="num_vlans" class="col-form-label">Adicionar Vlans</label>
                                            <div class="row">
                                                <div class="col-9">
                                                    <input type="number" min="0" max="255" class="form-control" id="num_vlans" name="num_vlans"></textarea>
                                                </div>
                                                <div class="col-3">
                                                    <button type="button" class="btn btn-secondary" onclick="adicionarVlan();">Adicionar</button>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="vlans" class="col-form-label">Vlans</label>
                                                <textarea class="form-control" id="vlans" disabled="true"></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="submit" class="btn btn-primary" value="Salvar">
                                        </div>
                                    </form>-->

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        function chamarPorta(string, string2, string3) {
            var str = string.split('|');
            var str2 = string2.split('|');
            var str3 = string3.split('|');
            var porta = str[0];
            var tipo = str[1];
            var vlans = str[2];
            var obs = str2[0];
            var mac = str2[1];
            var ipPorta = str2[2];
            var id = str3[0];
            var portaVincula = str3[1];
            var atiId = str3[2];

            document.getElementById("titulo").innerHTML = "";
            document.getElementById("form").innerHTML = "";

            var campus = "<?php echo $_GET['campus']; ?>";

            var select = "<?php criaVlan($pdo, $_GET['campus']); ?>";

            //var form = '<form action="../back/visualiza_ativo_back.php?campus=' + campus + '&porta=' + porta + '&id=' + id + '" method="POST"><div class="modal-body"><div class="form-group"><label for="tipo" class="col-form-label">Tipo de Conexão:</label><select class="custom-select" id="tipo" name="tipo" onchange="javascript: chamaFuncao(this.value)"><option value="0">Nenhuma</option><option value="1">Provedor</option><option value="2">Outra Porta</option><option value="3">Outros</option></select></div><div class="form-group" id="propriedade"></div><div class="row"><div class="col-6"><label for="mac" class="col-form-label">MAC:</label><input type="text" class="form-control" id="mac" name="mac"></div><div class="col-6"><label for="ipPorta" class="col-form-label">IP:</label><input type="text" class="form-control" id="ipPorta" name="ipPorta"></div></div><label for="num_vlans" class="col-form-label">Adicionar Vlans</label><div class="row"><div class="col-9"><input type="number" min="0" max="255" class="form-control" id="num_vlans" name="num_vlans"></textarea></div><div class="col-3"><button type="button" class="btn btn-secondary" onclick="adicionarVlan();">Adicionar</button></div></div><div class="form-group"><label for="vlans" class="col-form-label">Vlans</label><textarea class="form-control" id="vlans" disabled="true"></textarea></div></div><div class="modal-footer"><input type="submit" class="btn btn-primary" value="Salvar"></div></form';
            var form = '<form action="../back/visualiza_ativo_back.php?campus=' + campus + '&porta=' + porta + '&id=' + id + '" method="POST"><div class="modal-body"><div class="form-group"><label for="tipo" class="col-form-label">Tipo de Conexão:</label><select class="custom-select" id="tipo" name="tipo" onchange="javascript: chamaFuncao(this.value)"><option value="0">Nenhuma</option><option value="1">Provedor</option><option value="2">Outra Porta</option><option value="3">Outros</option></select></div><div class="form-group" id="propriedade"></div><div class="row"><div class="col-6"><label for="mac" class="col-form-label">MAC:</label><input type="text" maxlenght="17" class="form-control" id="mac" name="mac"></div><div class="col-6"><label for="ipPorta" class="col-form-label">IP:</label><input type="text" class="form-control" id="ipPorta" name="ipPorta" maxlenght="15"></div></div><label for="num_vlans" class="col-form-label">Adicionar Vlans</label><div class="row"><div class="col-9"><select class="custom-select" id="num_vlans" name="num_vlans">' + select + '</select></div><div class="col-3"><button type="button" class="btn btn-secondary" onclick="adicionarVlan();">Adicionar</button></div></div><div class="form-group"><label for="vlans" class="col-form-label">Vlans</label><input class="form-control" id="vlans" name="vlans" readonly=true></div></div><div class="modal-footer"><input type="submit" class="btn btn-primary" value="Salvar"></div></form';

            $('#form').append(form);

            document.getElementById("propriedade").innerHTML = "";
            if (tipo === '1') {
                $('#propriedade').append('<label for="provedor" class="col-form-label">IP de Provedores:</label><select class="custom-select" id="provedor" name="provedor"><?php criaComboboxProvedor($connect, 2) ?></select>'); // ADICIONA OS ELEMENTOS NA DIV
            } else if (tipo === '2') {
                $('#propriedade').append('<label for="ativo" class="col-form-label">Porta a vincular:</label><div class="row"><div class="col-9"><select class="custom-select" name="ativo"><?php criaComboboxAtivos($connect, 1) ?></select></div><div class="col-3"><input type="number" class="form-control" id="vinculaPorta" name="vinculaPorta" placeholder="Porta"/></div></div>'); // ADICIONA OS ELEMENTOS NA DIV
            } else if (tipo === '3') {
                $('#propriedade').append('<label for="outros" class="col-form-label">Outros:</label><input type="text" id="outros" name="outros"  class="form-control" placeholder="Outros"/>'); // ADICIONA OS ELEMENTOS NA DIV
            }

            $('#titulo').append('<h5 class="modal-title" id="numero" value="' + porta + '">Porta ' + porta + '</h5>');
            document.getElementById('tipo').value = tipo;
            document.getElementById('vlans').value = vlans;
            document.getElementById('outros').value = obs;
            document.getElementById('mac').value = mac;
            document.getElementById('ipPorta').value = ipPorta;
            document.getElementById('ativo').value = atiId;
            document.getElementById('vinculaPorta').value = portaVincula;
        }
    </script>



    <script type="text/javascript" language="javascript">
        function adicionarVlan() {
            num_vlans = document.getElementById('num_vlans').value;
            vlans = document.getElementById('vlans').value;

            if (vlans === "") {
                document.getElementById('vlans').value = num_vlans;
            } else {
                if (vlans.indexOf(num_vlans + ",") == -1) {
                    if (vlans.indexOf(num_vlans) == -1) {
                        document.getElementById('vlans').value = vlans + "," + num_vlans;
                    } else
                        alert("Vlan já foi escolhida!");
                } else {
                    document.getElementById('vlans').value = vlans + "," + num_vlans;
                }
            }
        }
    </script>

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables -->
    <script src="plugins/datatables/jquery.dataTables.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
    <!-- page script -->
    <script>
        $(function() {
            $("#example1").DataTable();
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
            });
        });
    </script>

</body>

</html>