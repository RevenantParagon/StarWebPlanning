<?php
require_once('../config.php');

if (!isset($_SESSION["id"])) {
    echo "<script>window.location.href='../src/login.php';';</script>";
}

if (!isset($_SESSION['tipo'])) {
    if (isset($_GET['funcao'])) {
        if ($_GET['funcao'] == "cadastrar") {
            $marca = $_POST['marca'];
            $modelo = $_POST['modelo'];
            $qtde_porta = $_POST['qtde_porta'];
            $tipo = $_POST['tipo'];
            $linha = $_POST['linha'];

            if (!isset($tipo)) {
                if ($tipo > 4 || $tipo < 0) {
                    echo "<script>alert('Foi especificado um tipo de equipamento inexistente!');window.location
            .href='../src/equip.php?funcao=" . $_GET['funcao'] . "';</script>";
                    die();
                }
            }

            if (isset($_POST['lado']))
                $lado = $_POST['lado'];

            if (isset($_POST['ordem']))
                $ordem = $_POST['ordem'];

            if (isset($_POST['direcao']))
                $direcao = $_POST['direcao'];

            if (isset($_POST['linha']))
                $linha = $_POST['linha'];

            if ($qtde_porta % $linha != 0) {
                echo "<script>alert('Foi especificado um equipamento com disposição de portas incorreta!');window.location
                .href='../src/equip.php?funcao=" . $_GET['funcao'] . "';</script>";
                die();
            }

            if ($marca != "" && $modelo != "" && $qtde_porta != "" && $tipo != "" && $linha != "") {
                $insert = "INSERT INTO tb_equipamento(equMarca, equModelo, equTipo, equQtdePorta, equLado, equOrdem, equDirecao, equLinha) VALUES(:marca,:modelo,:tipo,:qtde_porta,:lado,:ordem,:direcao, :linha)";

                $stmt = $pdo->prepare($insert);

                $stmt->bindValue(":marca", $marca);
                $stmt->bindValue(":modelo", $modelo);
                $stmt->bindValue(":tipo", $tipo);
                $stmt->bindValue(":qtde_porta", $qtde_porta);
                $stmt->bindValue(":lado", $lado);
                $stmt->bindValue(":ordem", $ordem);
                $stmt->bindValue(":direcao", $direcao);
                $stmt->bindValue(":linha", $linha);

                $stmt->execute();

                if ($stmt->rowcount() > 0) {
                    echo "<script>alert('Equipamento inserido com sucesso');window.location
            .href='../src/equip.php?funcao=" . $_GET['funcao'] . "';</script>";
                    die();
                } else {
                    echo "<script>
        alert('Houve um erro na inserção!');window.location
        .href='../src/equip.php?funcao=" . $_GET['funcao'] . "';</script>";
                    die();
                }
            } else {
                echo "<script>
    alert('Algum Campo está em branco!');window.location
    .href='../src/equip.php?funcao=" . $_GET['funcao'] . "';</script>";
                die();
            }
        } else if ($_GET['funcao'] == "editar") {
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $marca = $_POST['marca'];
                $modelo = $_POST['modelo'];
                $qtde_porta = $_POST['qtde_porta'];
                $tipo = $_POST['tipo'];
                $linha = $_POST['linha'];

                if (!isset($tipo)) {
                    if ($tipo > 4 || $tipo < 0) {
                        echo "<script>alert('Foi especificado um tipo de equipamento inexistente!');window.location
            .href='../src/equip.php?funcao=" . $_GET['funcao'] . "'&id=" . $_GET['id'] . ";</script>";
                        die();
                    }
                }

                if (isset($_POST['lado']))
                    $lado = $_POST['lado'];

                if (isset($_POST['ordem']))
                    $ordem = $_POST['ordem'];

                if (isset($_POST['direcao']))
                    $direcao = $_POST['direcao'];

                if (isset($_POST['linha']))
                    $linha = $_POST['linha'];

                if ($qtde_porta % $linha != 0) {
                    echo "<script>alert('Foi especificado um equipamento com disposição de portas incorreta!');window.location
                .href='../src/equip.php?funcao=" . $_GET['funcao'] . "&id=" . $_GET['id'] . "';</script>";
                    die();
                }

                if ($marca != "" && $modelo != "" && $qtde_porta != "" && $tipo != "" && $linha != "") {
                    $alterar = "UPDATE tb_equipamento set equMarca = :marca, equModelo = :modelo, equTipo = :tipo, equQtdePorta = :qtde_porta, equLado = :lado, equOrdem = :ordem, equDirecao = :direcao, equLinha = :linha where equId = :id;";

                    $stmt = $pdo->prepare($alterar);

                    $stmt->bindValue(":marca", $marca);
                    $stmt->bindValue(":modelo", $modelo);
                    $stmt->bindValue(":tipo", $tipo);
                    $stmt->bindValue(":qtde_porta", $qtde_porta);
                    $stmt->bindValue(":lado", $lado);
                    $stmt->bindValue(":ordem", $ordem);
                    $stmt->bindValue(":direcao", $direcao);
                    $stmt->bindValue(":linha", $linha);
                    $stmt->bindValue(":id", $id);

                    $stmt->execute();

                    if ($stmt->rowcount() > 0) {
                        echo "<script>
                    alert('Equipamento alterado com sucesso!');window.location
                    .href='../src/visualiza_equip.php';</script>";
                        die();
                    } else {
                        echo "<script>
                    alert('Houve um erro na alteração!');window.location
                    .href='../src/equip.php?funcao=" . $_GET['funcao'] . "&id=" . $_GET['id'] . "';</script>";
                        die();
                    }
                } else {
                    echo "<script>
                alert('Algum Campo está em branco!');window.location
                .href='../src/equip.php?funcao=" . $_GET['funcao'] . "&id=" . $_GET['id'] . "';</script>";
                    die();
                }
            }
        } else if ($_GET['funcao'] == "deletar") {
            if (isset($_GET['id'])) {
                $id = $_GET['id'];

                $delete = "delete from tb_equipamento where equId=:id";

                $stmt = $pdo->prepare($delete);

                $stmt->bindValue(":id", $id);

                $stmt->execute();

                if ($stmt->rowcount() > 0) {
                    echo "<script>
            alert('Equipamento excluído com sucesso!');window.location
            .href='../src/visualiza_equip.php';</script>";
                    die();
                } else {
                    echo "<script>
                alert('Houve um erro na exclusão!');window.location
                .href='../src/visualiza_equip.php';</script>";
                    die();
                }
            }
        }
    } else {
        echo "<script>window.location
.href='../src/equip.php?funcao=cadastrar';</script>";
        die();
    }
} else {
    echo "<script>window.location
.href='../src/index.php';</script>";
    die();
}
