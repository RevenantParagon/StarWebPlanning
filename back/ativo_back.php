<?php
require_once('../config.php');

if (!isset($_SESSION["id"])) {
    echo "<script>window.location.href='../src/login.php';';</script>";
}

if (!isset($_SESSION['tipo'])) {
    if (isset($_GET['funcao'])) {
        if ($_GET['funcao'] == "cadastrar") {
            $local = $_POST['local'];
            $ip = $_POST['ip'];
            $nome = $_POST['nome'];
            $usuario = $_POST['usuario'];
            $senha = $_POST['senha'];
            $equip = $_POST['equip'];
            $campus = $_GET['campus'];

            if ($local != "" && $ip != "" && $nome != "" && $usuario != "" && $senha != "") {
                $insert = "INSERT INTO tb_ativo(atiLocal, atiIP, atiNome, atiUsuario, atiSenha, camId, equId) VALUES(:alocal,:ip,:nome,:usuario,:senha ,:campus, :equip)";

                $stmt = $pdo->prepare($insert);

                $stmt->bindValue(":alocal", $local);
                $stmt->bindValue(":ip", $ip);
                $stmt->bindValue(":nome", $nome);
                $stmt->bindValue(":usuario", $usuario);
                $stmt->bindValue(":senha", $senha);
                $stmt->bindValue(":equip", $equip);
                $stmt->bindValue(":campus", $campus);

                $stmt->execute();

                if ($stmt->rowcount() > 0) {
                    $p = mysqli_query($connect, "SELECT max(atiId) 'atiId' FROM tb_ativo");
                    $atiId = mysqli_fetch_array($p);
                    $q = mysqli_query($connect, "SELECT equQtdePorta 'qtde' FROM tb_equipamento WHERE equId = '$equip'");
                    $qtdePorta = mysqli_fetch_array($q);
                    for ($i = 0; $i < $qtdePorta['qtde']; $i++) {

                        $insert = "INSERT INTO tb_porta(porNumero, atiId, porTipo) VALUES(:numero,:atiId,0)";

                        $stmt = $pdo->prepare($insert);

                        $stmt->bindValue(":numero", $i);
                        $stmt->bindValue(":atiId", $atiId['atiId']);

                        $stmt->execute();
                    }
                    echo "<script>alert('Ativo inserido com sucesso');window.location
            .href='../src/ativo.php?funcao=" . $_GET['funcao'] . "&campus=" . $_GET['campus'] . "';</script>";
                    die();
                } else {
                    echo "<script>
        alert('Houve um erro na inserção!');window.location
        .href='../src/ativo.php?funcao=" . $_GET['funcao'] . "&campus=" . $_GET['campus'] . "';</script>";
                    die();
                }
            } else {
                echo "<script>
    alert('Algum Campo está em branco!');window.location
    .href='../src/ativo.php?funcao=" . $_GET['funcao'] . "&campus=" . $_GET['campus'] . "';</script>";
                die();
            }
        } else if ($_GET['funcao'] == "editar") {
            if (isset($_GET['id'])) {
                $local = $_POST['local'];
                $ip = $_POST['ip'];
                $nome = $_POST['nome'];
                $usuario = $_POST['usuario'];
                $senha = $_POST['senha'];
                $equip = $_POST['equip'];
                $id = $_GET['id'];

                if ($local != "" && $ip != "" && $nome != "" && $usuario != "" && $senha != "") {
                    $alterar = "UPDATE tb_ativo set atiLocal = :alocal, atiIP = :ip, atiNome = :nome, atiUsuario = :usuario, atiSenha = :senha, equId=:equip where atiId = :id;";

                    $stmt = $pdo->prepare($alterar);

                    $stmt->bindValue(":alocal", $local);
                    $stmt->bindValue(":ip", $ip);
                    $stmt->bindValue(":nome", $nome);
                    $stmt->bindValue(":usuario", $usuario);
                    $stmt->bindValue(":senha", $senha);
                    $stmt->bindValue(":id", $id);
                    $stmt->bindValue(":equip", $equip);

                    $stmt->execute();

                    if ($stmt->rowcount() > 0) {
                        echo "<script>
                    alert('Ativo alterado com sucesso!');window.location
                    .href='../src/visualiza_ativo.php?campus=" . $_GET['campus'] . "';</script>";
                        die();
                    } else {
                        echo "<script>
                    alert('Houve um erro na alteração!');window.location
                    .href='../src/ativo.php?funcao=" . $_GET['funcao'] . "&campus=" . $_GET['campus'] . "&id=" . $id . "';</script>";
                        die();
                    }
                } else {
                    echo "<script>
                alert('Algum Campo está em branco!');window.location
                .href='../src/ativo.php?funcao=" . $_GET['funcao'] . "&campus=" . $_GET['campus'] . "&id=" . $id . "';</script>";
                    die();
                }
            }
        } else if ($_GET['funcao'] == "deletar") {
            if (isset($_GET['id'])) {
                $id = $_GET['id'];

                $delete = "delete from tb_ativo where atiId=:id";

                $stmt = $pdo->prepare($delete);

                $stmt->bindValue(":id", $id);

                $stmt->execute();

                if ($stmt->rowcount() > 0) {
                    echo "<script>
            alert('Ativo excluído com sucesso!');window.location
            .href='../src/visualiza_ativo.php?campus=" . $_GET['campus'] . "';</script>";
                    die();
                } else {
                    echo "<script>
                alert('Houve um erro na exclusão!');window.location
                .href='../src/visualiza_ativo.php?campus=" . $_GET['campus'] . "';</script>";
                    die();
                }
            }
        }
    } else {
        echo "<script>window.location
.href='../src/ativo.php?funcao=cadastrar&campus=" . $_GET['campus'] . "';</script>";
        die();
    }
} else {
    echo "<script>window.location
.href='../src/index.php';</script>";
    die();
}
