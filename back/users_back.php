<?php
require_once('../config.php');


if (isset($_GET['funcao'])) {
    if ($_GET['funcao'] == "cadastrar") {
        $prontuario = strtoupper($_POST['prontuario']);
        $select = "SELECT usrId FROM tb_usuario WHERE usrLogin = :prontuario";

        $stmt = $GLOBALS['pdo']->prepare($select);

        $stmt->bindValue(":prontuario", $prontuario);

        $stmt->execute();

        if ($stmt->rowcount() >= 1) {
            echo "<script>
                alert('Já existe um usuário com este prontuário!');window.location
                .href='../src/users.php?funcao=" . $_GET['funcao'] . "';</script>";
            die();
        }

        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $campus = $_POST['campus'];
        $senha = $_POST['senha'];
        $senha2 = $_POST['senha2'];

        if (isset($_POST['tipo_usuario']))
            $tipoUsuario = $_POST['tipo_usuario'];
        else {
            echo "<script>alert('Não foi informado o tipo de usuário!');window.location.href='../src/users.php?funcao=" . $_GET['funcao'] . "';</script>";
        }

        if ($prontuario != "" && $nome != "" && $email != "" && $campus != "" && $senha != "" && $senha2 != "") {

            if ($senha == $senha2) {
                $senha = $prontuario . "//" . $senha;

                $senha = hash('sha256', $senha);

                $insert = "INSERT INTO tb_usuario(usrLogin, usrSenha, usrNome, usrEmail, camId, usrTipo) VALUES(:usuario,:senha,:nome,:email,:campus, :tipoUsuario)";

                $stmt = $pdo->prepare($insert);

                $stmt->bindValue(":usuario", $prontuario);
                $stmt->bindValue(":senha", $senha);
                $stmt->bindValue(":nome", $nome);
                $stmt->bindValue(":email", $email);
                $stmt->bindValue(":campus", $campus);
                $stmt->bindValue(":tipoUsuario", $tipoUsuario);

                $stmt->execute();

                if ($stmt->rowcount() > 0) {
                    echo "<script>alert('Usuário inserido com sucesso');
                    window.location.href='../src/users.php?funcao=" . $_GET['funcao'] . "';</script>";
                    die();
                } else {
                    echo "<script>alert('Houve um erro na inserção!');window.location.href='../src/users.php?funcao=" . $_GET['funcao'] . "';</script>";
                }
            } else {
                echo "<script>alert('As senha são divergentes!');window.location.href='../src/users.php?funcao=" . $_GET['funcao'] . "';</script>";
            }
        } else {
            echo "<script> alert('Algum Campo está em branco!');window.location.href='../src/users.php?funcao=" . $_GET['funcao'] . "';</script>";
        }
    } else if ($_GET['funcao'] == "editar") {
        if (isset($_GET['id'])) {
            $prontuario = strtoupper($_POST['prontuario']);

            $select = "SELECT usrId FROM tb_usuario WHERE usrLogin = :prontuario and usrId <> :id";

            $stmt = $GLOBALS['pdo']->prepare($select);

            $stmt->bindValue(":prontuario", $prontuario);            
            $stmt->bindValue(":id", $_GET['id']);

            $stmt->execute();

            if ($stmt->rowcount() >= 1) {
                echo "<script>
                alert('Já existe um usuário com este prontuário!');window.location
                .href='../src/users.php?funcao=" . $_GET['funcao'] . "&id=" . $_GET['id'] . "';</script>";
                die();
            }

            $nome = $_POST['nome'];
            $email = $_POST['email'];
            $campus = $_POST['campus'];
            $senha = $_POST['senha'];
            $senha2 = $_POST['senha2'];
            $id = $_GET['id'];

            if (isset($_POST['tipo_usuario']))
                $tipoUsuario = $_POST['tipo_usuario'];
            else {
                echo "<script>alert('Não foi informado o tipo de usuário!');window.location.href='../src/users.php?funcao=" . $_GET['funcao'] . "';</script>";
            }
            if ($prontuario != "" && $nome != "" && $email != "" && $campus != "" && $senha != "" && $senha2 != "") {
                if ($senha == $senha2) {
                    $senha = $prontuario . "//" . $senha;

                    $senha = hash('sha256', $senha);

                    $update = "UPDATE tb_usuario set usrLogin=:usuario, usrNome=:nome, usrSenha= :senha, usrEmail=:email, camID=:campus, usrTipo=:tipoUsuario where usrId=:id";

                    $stmt = $pdo->prepare($update);

                    $stmt->bindValue(":id", $id);
                    $stmt->bindValue(":usuario", $prontuario);
                    $stmt->bindValue(":senha", $senha);
                    $stmt->bindValue(":nome", $nome);
                    $stmt->bindValue(":email", $email);
                    $stmt->bindValue(":campus", $campus);
                    $stmt->bindValue(":tipoUsuario", $tipoUsuario);

                    $stmt->execute();

                    if ($stmt->rowcount() > 0) {
                        echo "<script>alert('Usuário alterado com sucesso');
                        window.location.href='../src/visualiza_users.php';</script>";
                        die();
                    } else {
                        echo "<script>
                        alert('Houve um erro na alteração!');window.location
                        .href='../src/users.php?funcao=" . $_GET['funcao'] . "&id=" . $_GET['id'] . "';</script>";
                        die();
                    }
                } else {
                    echo "<script>
                alert('As senha são divergentes!');window.location
                .href='../src/users.php?funcao=" . $_GET['funcao'] . "&id=" . $_GET['id'] . "';</script>";
                    die();
                }
            } else {
                echo "<script>
            alert('Algum Campo está em branco!');window.location
            .href='../src/users.php?funcao=" . $_GET['funcao'] . "&id=" . $_GET['id'] . "';</script>";
                die();
            }
        }
    } else if ($_GET['funcao'] == "deletar") {
        if (isset($_GET['id'])) {
            if ($_GET['id'] != 1) {

                $id = $_GET['id'];

                $delete = "delete from tb_usuario where usrId=:id";

                $stmt = $pdo->prepare($delete);

                $stmt->bindValue(":id", $id);

                $stmt->execute();

                if ($stmt->rowcount() > 0) {
                    echo "<script>
                    alert('Usuário excluído com sucesso!');window.location
                    .href='../src/visualiza_users.php';</script>";
                    die();
                } else {
                    echo "<script>
                        alert('Houve um erro na inserção!');window.location
                        .href='../src/visualiza_users.php';</script>";
                    die();
                }
            } else {
                echo "<script>alert('Este usuário não pode ser excluído, pois, é o adminstrador!');window.location.href='../src/visualiza_users.php';</script>";
                die();
            }
        }
    }
} else {
    echo "<script>window.location
    .href='../src/users.php';</script>";
    die();
}
