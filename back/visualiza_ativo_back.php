<?php
require_once('../config.php');

if (!isset($_SESSION["id"])) {
    echo "<script>window.location.href='../src/login.php';';</script>";
}

if (!isset($_SESSION['tipo'])) {
    $numero = $_SESSION['numPorta'];
    $tipo = $_POST['tipo'];
    $num_vlans = $_POST['num_vlans'];
    $mac = $_POST['mac'];
    $ip = $_POST['ipPorta'];    
    $obs = $_POST['outros'];
    
    if(isset($atiId))
        $atiId = null;

    if(isset($proId))
        $proId = null;

    $insert = "INSERT INTO tb_porta(porNumero, porTipo, porMac, porIP, atiId, proId, porObs) VALUES(:numero, :tipo, :mac, :ip, :atiId, :proId, :obs)";

    $stmt->bindValue(":numero", $numero);
    $stmt->bindValue(":tipo", $tipo);
    $stmt->bindValue(":mac", $mac);
    $stmt->bindValue(":ip", $ip);    
    $stmt->bindValue(":atiId", $atiId);
    $stmt->bindValue(":proId", $proId);
    $stmt->bindValue(":obs", $obs);

    $stmt = $pdo->prepare($insert);

    $stmt->execute();

    if ($stmt->rowcount() > 0) {
        echo "<script>alert('Porta vinculada com sucesso com sucesso!');window.location.href='../src/visualiza_ativo.php?campus=" . $_GET['campus'] . "';</script>";
        die();
    } else {
        echo "<script>
alert('Houve um erro no vinculo!');window.location.href='../src/visualiza_ativo.php?campus=" . $_GET['campus'] . "';</script>";
        die();
    }
    
} else {
    echo "<script>window.location
.href='../src/index.php';</script>";
    die();
}
