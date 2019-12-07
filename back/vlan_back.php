<?php
require_once('../config.php');

session_start();

if (!isset($_SESSION["id"])) {
    echo "<script>window.location.href='../src/login.php';';</script>";
}

if (isset($_GET['funcao'])) {
    if ($_GET['funcao'] == "cadastrar") {
        $id = $_POST['id'];
        $ip = $_POST['ip'];
        $mascara = $_POST['cidr'];
        $descricao = $_POST['descricao'];
        $cor = $_POST['cor'];
        $camId = $_GET['campus'];

        $select = "SELECT vlanIP FROM tb_vlan WHERE vlanIP = :ip";

        $stmt = $GLOBALS['pdo']->prepare($select);

        $stmt->bindValue(":ip", $ip);

        $stmt->execute();

        if ($stmt->rowcount() >= 1) {
            echo "<script>
        alert('Já existe uma vlan com este ip!');window.location
        .href='../src/vlan.php?funcao=" . $_GET['funcao'] . "&campus=" . $_GET['campus'] . "';</script>";
            die();
        }

        if (isset($_POST['dhcp']))
            $dhcp = $_POST['dhcp'];
        else
            echo "<script>alert('Não foi informado se terá DHCP!');window.location.href='../src/vlan.php?funcao=" . $_GET['funcao'] . "&campus=" . $_GET['campus'] . "';</script>";

        if (isset($_POST['vpn']))
            $vpn = $_POST['vpn'];
        else
            $vpn = 0;

        if ($id != "" && $ip != "" && $mascara != "" && $descricao != "" && $cor != "") {
            $insert = "INSERT INTO tb_vlan(vlanId, vlanIP,vlanDescricao, vlanMascara, vlanDHCP, vlanVPN, vlanCor, camId) VALUES(:id,:ip, :descricao, :mascara, :dhcp, :vpn, :cor, :camId)";

            $stmt = $pdo->prepare($insert);

            $stmt->bindValue(":id", $id);
            $stmt->bindValue(":ip", $ip);
            $stmt->bindValue(":descricao", $descricao);
            $stmt->bindValue(":mascara", $mascara);
            $stmt->bindValue(":dhcp", $dhcp);
            $stmt->bindValue(":vpn", $vpn);
            $stmt->bindValue(":cor", $cor);
            $stmt->bindValue(":camId", $camId);

            $stmt->execute();

            if ($stmt->rowcount() > 0) {
                echo "<script>alert('Vlan inserida com sucesso!');window.location.href='../src/visualiza_vlan.php?campus=" . $_GET['campus'] . "';</script>";
                die();
            } else {
                echo "<script>
        alert('Houve um erro na inserção!');window.location
        .href='../src/vlan.php?funcao=" . $_GET['funcao'] . "&campus=" . $_GET['campus'] . "';</script>";
                die();
            }
        } else {
            echo "<script>
    alert('Algum Campo está em branco!');window.location
    .href='../src/vlan.php?funcao=" . $_GET['funcao'] . "&campus=" . $_GET['campus'] . "';</script>";
            die();
        }
    } else if ($_GET['funcao'] == "editar") {
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $ip = $_POST['ip'];
            $mascara = $_POST['cidr'];
            $descricao = $_POST['descricao'];
            $cor = $_POST['cor'];
            $camId = $_GET['campus'];

            $select = "SELECT vlanIP FROM tb_vlan WHERE vlanIP = :ip and vlanId <> :id";

            $stmt = $GLOBALS['pdo']->prepare($select);

            $stmt->bindValue(":ip", $ip);
            $stmt->bindValue(":id", $id);

            $stmt->execute();

            if ($stmt->rowcount() >= 1) {
                echo "<script>
        alert('Já existe uma vlan com este ip!');window.location
        .href='../src/vlan.php?funcao=" . $_GET['funcao'] . "&campus=" . $_GET['campus'] . "';</script>";
                die();
            }

            if (isset($_POST['dhcp']))
                $dhcp = $_POST['dhcp'];
            else
                echo "<script>alert('Não foi informado se terá DHCP!');window.location.href='../src/vlan.php?funcao=" . $_GET['funcao'] . "&campus=" . $_GET['campus'] . "&id=" . $_POST['id'] . "';</script>";

            if (isset($_POST['vpn']))
                $vpn = $_POST['vpn'];
            else
                $vpn = 0;

            if ($id != "" && $ip != "" && $mascara != "" && $descricao != "" && $cor != "") {
                $insert = "update tb_vlan set vlanIP = :ip, vlanDescricao = :descricao, vlanMascara = :mascara, vlanDHCP = :dhcp, vlanVPN = :vpn, vlanCor = :cor where vlanId=:id";

                $stmt = $pdo->prepare($insert);

                $stmt->bindValue(":id", $id);
                $stmt->bindValue(":ip", $ip);
                $stmt->bindValue(":descricao", $descricao);
                $stmt->bindValue(":mascara", $mascara);
                $stmt->bindValue(":dhcp", $dhcp);
                $stmt->bindValue(":vpn", $vpn);
                $stmt->bindValue(":cor", $cor);

                $stmt->execute();

                if ($stmt->rowcount() > 0) {
                    echo "<script>alert('Vlan alterado com sucesso');window.location
            .href='../src/visualiza_vlan.php?campus=" . $_GET['campus'] . "';</script>";
                    die();
                } else {
                    echo "<script>
        alert('Houve um erro na alteração!');window.location
        .href='../src/vlan.php?funcao=" . $_GET['funcao'] . "&campus=" . $_GET['campus'] . "&id=" . $_POST['id'] . "';</script>";
                    die();
                }
            } else {
                echo "<script>
    alert('Algum Campo está em branco!');window.location
    .href='../src/vlan.php?funcao=" . $_GET['funcao'] . "&campus=" . $_GET['campus'] . "&id=" . $_POST['id'] . "';</script>";
                die();
            }
        }
    } else if ($_GET['funcao'] == "deletar") {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $delete = "delete from tb_vlan where vlanId=:id";

            $stmt = $pdo->prepare($delete);

            $stmt->bindValue(":id", $id);

            $stmt->execute();

            if ($stmt->rowcount() > 0) {
                echo "<script>
            alert('Vlan excluído com sucesso!');window.location
            .href='../src/visualiza_vlan.php?campus=" . $_GET['campus'] . "';</script>";
                die();
            } else {
                echo "<script>
                alert('Houve um erro na exclusão!');window.location
                .href='../src/visualiza_vlan.php?campus=" . $_GET['campus'] . "';</script>";
                die();
            }
        }
    }
} else {
    echo "<script>window.location
.href='../src/vlan.php?funcao=cadastrar';</script>";
    die();
}
