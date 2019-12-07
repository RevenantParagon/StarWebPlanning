<?php
require_once('../config.php');

if (!isset($_SESSION["id"])) {
    echo "<script>window.location.href='../src/login.php';';</script>";
}

if (!isset($_SESSION['tipo'])) {
    if (isset($_GET['funcao'])) {
        if ($_GET['funcao'] == "cadastrar") {
            $sigla = strtoupper($_POST['sigla']);
            $campus = $_POST['campus'];
            $ip = $_POST['ip'];

            $select = "SELECT camId FROM tb_campus WHERE camCampus = :campus";

            $stmt = $GLOBALS['pdo']->prepare($select);

            $stmt->bindValue(":campus", $campus);

            $stmt->execute();

            if ($stmt->rowcount() >= 1) {
                echo "<script>
            alert('Já existe um campus com este nome!');window.location
            .href='../src/campus.php?funcao=" . $_GET['funcao'] . "';</script>";
                die();
            }

            if ($sigla != "" && $campus != "" && $ip != "") {
                $insert = "INSERT INTO tb_campus(camSigla, camCampus, camIP) VALUES(:sigla,:campus,:ip)";

                $stmt = $pdo->prepare($insert);

                $stmt->bindValue(":sigla", $sigla);
                $stmt->bindValue(":campus", $campus);
                $stmt->bindValue(":ip", $ip);

                $stmt->execute();

                if ($stmt->rowcount() > 0) {
                    echo "<script>alert('Campus inserido com sucesso');window.location
            .href='../src/campus.php?funcao=" . $_GET['funcao'] . "';</script>";
                    die();
                } else {
                    echo "<script>
        alert('Houve um erro na inserção!');window.location
        .href='../src/campus.php?funcao=" . $_GET['funcao'] . "';</script>";
                    die();
                }
            } else {
                echo "<script>
    alert('Algum Campo está em branco!');window.location
    .href='../src/campus.php?funcao=" . $_GET['funcao'] . "';</script>";
                die();
            }
        } else if ($_GET['funcao'] == "editar") {
            if (isset($_GET['id'])) {

                $sigla = strtoupper($_POST['sigla']);
                $campus = $_POST['campus'];
                $id = $_GET['id'];
                $ip = $_POST['ip'];

                $select = "SELECT camId FROM tb_campus WHERE camCampus = :campus and camId <> :id";

                $stmt = $GLOBALS['pdo']->prepare($select);

                $stmt->bindValue(":campus", $campus);
                $stmt->bindValue(":id", $id);

                $stmt->execute();

                if ($stmt->rowcount() >= 1) {
                    echo "<script>
                alert('Já existe um campus com este nome!');window.location
                .href='../src/campus.php?funcao=" . $_GET['funcao'] . "&id=" . $_GET['id'] . "';</script>";
                    die();
                }

                if ($sigla != "" && $campus != "" && $ip != "") {
                    $alterar = "UPDATE tb_campus set camSigla = :sigla, camCampus = :campus, camIP = :ip where camId = :id;";

                    $stmt = $pdo->prepare($alterar);

                    $stmt->bindValue(":sigla", $sigla);
                    $stmt->bindValue(":campus", $campus);
                    $stmt->bindValue(":id", $id);
                    $stmt->bindValue(":ip", $ip);

                    $stmt->execute();

                    if ($stmt->rowcount() > 0) {
                        echo "<script>
                    alert('Campus alterado com sucesso!');window.location
                    .href='../src/visualiza_campus.php';</script>";
                        die();
                    } else {
                        echo "<script>
                    alert('Houve um erro na alteração!');window.location
                    .href='../src/campus.php?funcao=" . $_GET['funcao'] . "&id=" . $_GET['id'] . "';</script>";
                        die();
                    }
                } else {
                    echo "<script>
                alert('Algum Campo está em branco!');window.location
                .href='../src/campus.php?funcao=" . $_GET['funcao'] . "&id=" . $_GET['id'] . "';</script>";
                    die();
                }
            }
        } else if ($_GET['funcao'] == "deletar") {
            if (isset($_GET['id'])) {
                $id = $_GET['id'];

                $select = "SELECT usrId FROM tb_usuario WHERE camId = :id";

                $stmt = $GLOBALS['pdo']->prepare($select);

                $stmt->bindValue(":id", $id);

                $stmt->execute();
                if ($stmt->rowcount() >= 1) {
                    echo "<script>
                alert('Este campus não pode ser excluído, pois, tem um usuário associado!');
                window.location.href='../src/visualiza_campus.php';</script>";
                    die();
                }

                $delete = "delete from tb_campus where camId=:id";

                $stmt = $pdo->prepare($delete);

                $stmt->bindValue(":id", $id);

                $stmt->execute();

                if ($stmt->rowcount() > 0) {
                    echo "<script>
            alert('Campus excluído com sucesso!');window.location
            .href='../src/visualiza_campus.php';</script>";
                    die();
                } else {
                    echo "<script>
                alert('Houve um erro na inserção!');window.location
                .href='../src/visualiza_campus.php';</script>";
                    die();
                }
            }
        }
    } else {
        echo "<script>window.location
.href='../src/campus.php?funcao=cadastrar';</script>";
        die();
    }
} else {
    echo "<script>window.location
.href='../src/index.php';</script>";
    die();
}

