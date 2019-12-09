<?php
require_once('../config.php');

if (!isset($_SESSION["id"])) {
    echo "<script>window.location.href='../src/login.php';';</script>";
}

if (!isset($_SESSION['tipo'])) {
    $numero = $_GET['porta'];
    $id = $_GET['id'];
    $tipo = $_POST['tipo'];
    $mac = $_POST['mac'];
    $ip = $_POST['ipPorta'];
    $vlans = explode(",", $_POST['vlans']);
    $outros = null;
    $atiId = null;
    $proId = null;

    if (isset($_GET['atiId']))
        $atiId = $_GET['atiId'];

    if (isset($_POST['outros']))
        $outros = $_POST['outros'];

    if (isset($_POST['provedor']))
        $proId = $_POST['provedor'];

    if (isset($_POST['ativo'])) {
        $ativo = $_POST['ativo'];
        $vinculaPorta = $_POST['vinculaPorta'];

        $select = "select porId 'id' from tb_porta where porNumero=:vinculaPorta and atiId=:ativo";

        $stmt3 = $pdo->prepare($select);

        $stmt3->bindValue(":ativo", $ativo);
        $stmt3->bindValue(":vinculaPorta", $vinculaPorta);

        $stmt3->execute();

        if ($stmt3->rowcount() == 1) {
            $row = $stmt3->fetch();
            $insert = "update tb_porta set porTipo=2, porObs=null, proId=null where porId=:idVincula;delete from tb_porta_porta where porId=:id or porIdVinculada=:idVincula or porId=:idVincula or porIdVinculada=:id;insert into tb_porta_porta values(:id, :idVincula);insert into tb_porta_porta values(:idVincula, :id);update tb_porta set porNumero=:numero, porTipo=:tipo, porMac=:mac, porIP=:ip, porObs=:outros, proId=:proId where porId=:id;";

            $stmt = $pdo->prepare($insert);

            $stmt->bindValue(":id", $id);
            $stmt->bindValue(":idVincula", $row['id']);
            $stmt->bindValue(":numero", $numero);
            $stmt->bindValue(":tipo", $tipo);
            $stmt->bindValue(":mac", $mac);
            $stmt->bindValue(":ip", $ip);
            $stmt->bindValue(":proId", $proId);
            $stmt->bindValue(":outros", $outros);
        } else
            echo "<script>alert('Não foi encontrada a porta para vínculo!');window.location.href='../src/visualiza_ativo.php?campus=" . $_GET['campus'] . "';</script>";
    } else {
        $update = "update tb_porta set porNumero=:numero, porTipo=:tipo, porMac=:mac, porIP=:ip, porObs=:outros, proId=:proId where porId=:id";

        $stmt = $pdo->prepare($update);

        $stmt->bindValue(":id", $id);
        $stmt->bindValue(":numero", $numero);
        $stmt->bindValue(":tipo", $tipo);
        $stmt->bindValue(":mac", $mac);
        $stmt->bindValue(":ip", $ip);
        $stmt->bindValue(":proId", $proId);
        $stmt->bindValue(":outros", $outros);
    }
    $stmt->execute();

    foreach ($vlans as $vlan) {
        $update = "delete from tb_porta_vlan where porId=:porId and vlanId=:vlansId";

        $stmt = $pdo->prepare($update);

        $stmt->bindValue(":porId", $id);
        $stmt->bindValue(":vlansId", $vlan);

        $stmt->execute();

        $update = "insert tb_porta_vlan values(:porId, :vlansId)";

        $stmt = $pdo->prepare($update);

        $stmt->bindValue(":porId", $id);
        $stmt->bindValue(":vlansId", $vlan);

        $stmt->execute();
    }
    echo "<script>alert('Porta vinculada com sucesso com sucesso!');window.location.href='../src/visualiza_ativo.php?campus=" . $_GET['campus'] . "';</script>";
    die();
} else {
    echo "<script>window.location
.href='../src/index.php';</script>";
    die();
}
