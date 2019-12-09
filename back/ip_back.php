<?php

require_once('../config.php');
require_once('../ipv4.php');
session_start();

if (!isset($_SESSION["id"])) {
    echo "<script>window.location.href='../src/login.php';</script>";
}

if (isset($_SESSION['tipo'])) {
    if (isset($_GET['funcao'])) {
        if ($_GET['funcao'] == "cadastrar") {
            if (isset($_GET['campus'])) {
                $nome = $_POST['nome'];
                $ip = $_POST['ip'];
                $mascara = $_POST['cidr'];
                $camId = $_GET['campus'];

                $select = "SELECT proIP FROM tb_provedor WHERE proIP = :ip";

                $stmt = $GLOBALS['pdo']->prepare($select);
        
                $stmt->bindValue(":ip", $ip); 
        
                $stmt->execute();
        
                if ($stmt->rowcount() >= 1) {
                    echo "<script>
                alert('Já existe uma provedor com este ip!');window.location
                .href='../src/ip.php?campus=" . $_GET['campus'] . "';</script>";
                    die();
                }

                $insert = "INSERT INTO tb_provedor(proNome, proIp, proMascara,camId) VALUES(:nome,:ip,:mascara,:camId)";

                $stmt = $pdo->prepare($insert);

                $stmt->bindValue(":nome", $nome);
                $stmt->bindValue(":ip", $ip);
                $stmt->bindValue(":mascara", $mascara);
                $stmt->bindValue(":camId", $camId);

                $stmt->execute();

                $provedor = mysqli_query($connect, "SELECT proId 'id' FROM tb_provedor order by proId desc limit 1 ");

                while ($row = mysqli_fetch_array($provedor)) {

                    $ip = new calc_ipv4($_POST['ip'] . "/" . $mascara);

                    $primeiro = new calc_ipv4($ip->primeiro_ip() . "/" . $mascara);
                    $ultimo = new calc_ipv4($ip->ultimo_ip() . "/" . $mascara);

                    $primeiro = $primeiro->endereco();
                    $ultimo = $ultimo->endereco();

                    $var_primeiro = explode(".", $primeiro);
                    $var_ultimo = explode(".", $ultimo);

                    $insert = "";

                    while ($var_primeiro[0] <= $var_ultimo[0]) {
                        while ($var_primeiro[1] <= $var_ultimo[1]) {
                            while ($var_primeiro[2] <= $var_ultimo[2]) {
                                while ($var_primeiro[3] <= $var_ultimo[3]) {
                                    $ips = $var_primeiro[0] . "." . $var_primeiro[1] . "." . $var_primeiro[2] . "." . $var_primeiro[3];

                                    if ($ip != $primeiro && $ip != $ultimo)
                                        mysqli_query($connect, "INSERT INTO tb_ip(ipIP,proId) VALUES('" . $ips . "'," . $row['id'] . ")");

                                    $var_primeiro[3]++;
                                }
                                $var_primeiro[2]++;
                            }
                            $var_primeiro[1]++;
                        }
                        $var_primeiro[0]++;
                    }
                    echo "<script>alert('Ips Inseridos');window.location.href='../src/ip.php?campus=" . $_GET['campus'] . "';</script>";
                    die();
                }
            }
        } else if ($_GET['funcao'] == "editar") {
            if (isset($_GET['id']) && isset($_GET['campus'])) {
                $nome = $_POST['nome'];
                $ip = $_POST['ip'];
                $mascara = $_POST['cidr'];
                $camId = $_GET['campus'];
                $id = $_GET['id'];

                $select = "SELECT proIP FROM tb_provedor WHERE proIP = :ip and proId<> :id";

                $stmt = $GLOBALS['pdo']->prepare($select);
        
                $stmt->bindValue(":ip", $ip);               
                $stmt->bindValue(":id", $id);
        
                $stmt->execute();
        
                if ($stmt->rowcount() >= 1) {
                    echo "<script>
                alert('Já existe uma provedor com este ip!');window.location
                .href='../src/ip.php?campus=" . $_GET['campus'] . "';</script>";
                    die();
                }

                $insert = "UPDATE tb_provedor set proNome = :nome, proIp = :ip, proMascara = :mascara where proID = :id";

                $stmt = $pdo->prepare($insert);

                $stmt->bindValue(":nome", $nome);
                $stmt->bindValue(":ip", $ip);
                $stmt->bindValue(":mascara", $mascara);
                $stmt->bindValue(":id", $_GET['id']);

                $stmt->execute();

                $insert = "delete from tb_ip where proId = :id";

                $stmt = $pdo->prepare($insert);

                $stmt->bindValue(":id", $_GET['id']);

                $stmt->execute();

                $provedor = mysqli_query($connect, "SELECT proId 'id' FROM tb_provedor where proId=".$_GET['id']);

                while ($row = mysqli_fetch_array($provedor)) {

                    $ip = new calc_ipv4($_POST['ip'] . "/" . $mascara);

                    $primeiro = new calc_ipv4($ip->primeiro_ip() . "/" . $mascara);
                    $ultimo = new calc_ipv4($ip->ultimo_ip() . "/" . $mascara);

                    $primeiro = $primeiro->endereco();
                    $ultimo = $ultimo->endereco();

                    $var_primeiro = explode(".", $primeiro);
                    $var_ultimo = explode(".", $ultimo);

                    $insert = "";

                    while ($var_primeiro[0] <= $var_ultimo[0]) {
                        while ($var_primeiro[1] <= $var_ultimo[1]) {
                            while ($var_primeiro[2] <= $var_ultimo[2]) {
                                while ($var_primeiro[3] <= $var_ultimo[3]) {
                                    $ips = $var_primeiro[0] . "." . $var_primeiro[1] . "." . $var_primeiro[2] . "." . $var_primeiro[3];

                                    if ($ip != $primeiro && $ip != $ultimo)
                                        mysqli_query($connect, "INSERT INTO tb_ip(ipIP,proId) VALUES('" . $ips . "'," . $row['id'] . ")");

                                    $var_primeiro[3]++;
                                }
                                $var_primeiro[2]++;
                            }
                            $var_primeiro[1]++;
                        }
                        $var_primeiro[0]++;
                    }
                    echo "<script>alert('Provedor Alterado com sucesso');window.location.href='../src/ip.php?campus=" . $_GET['campus'] . "';</script>";
                    die();
                }
                die();
            }
        } else if ($_GET['funcao'] == "deletar") {
            if (isset($_GET['id'])) {
                $id = $_GET['id'];

                $delete = "delete from tb_provedor where proId=:id";

                $stmt = $pdo->prepare($delete);

                $stmt->bindValue(":id", $id);

                $stmt->execute();

                if ($stmt->rowcount() > 0) {
                    echo "<script>
            alert('Provedor excluído com sucesso!');window.location
            .href='../src/ip.php?campus=" . $_GET['campus'] . "';</script>";
                    die();
                } else {
                    echo "<script>
                alert('Houve um erro na exclusão!');window.location
                .href='../src/ip.php?campus=" . $_GET['campus'] . "';</script>";
                    die();
                }
            }
        } else {
            echo "<script>window.location
.href='../src/visualiza_campus.php';</script>";
            die();
        }
    } else {
        echo "<script>window.location
.href='../src/index.php';</script>";
        die();
    }
}
