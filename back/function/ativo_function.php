<?php
require_once('../config.php');

function criaCombobox($connect, $equip)
{
    $q = mysqli_query($connect, "SELECT equID, equMarca, equModelo FROM tb_equipamento order by equMarca asc");

    if (mysqli_num_rows($q) > 0) {
        while ($row = mysqli_fetch_array($q)) {
            if(isset($equip)){
                if($equip == $row['equID'])
                    echo "<option value=".$row['equID']." selected>".$row['equMarca']."-".$row['equModelo']."</option>";
                else
                    echo "<option value=".$row['equID'].">".$row['equMarca']."-".$row['equModelo']."</option>";
            }else{
                echo "<option value=".$row['equID'].">".$row['equMarca']."-".$row['equModelo']."</option>";
            }
        }
    }
}

function voltarAtivo($pdo, $id)
{
    $select = "select atiLocal 'local',atiIP 'ip', atiNome 'nome', atiUsuario 'usuario', atiSenha 'senha'  from tb_ativo where atiId=:id";

    $stmt = $pdo->prepare($select);

    $stmt->bindValue(":id", $id);

    $stmt->execute();
    
    if ($stmt->rowcount() == 1) {
        return $row =$stmt->fetch();
    }
}

function buscaAtivos($pdo, $campus)
{
    $select = "select atiId 'id', atiMarca 'marca', atiLocal 'local',atiIP 'ip', atiNome 'nome', atiUsuario 'usuario', atiSenha 'senha'  from tb_vlan where camId=:id";

    $stmt = $pdo->prepare($select);

    $stmt->bindValue(":id", $campus);

    $stmt->execute();
    
    if ($stmt->rowcount() == 1) {
        return $row =$stmt->fetch();
    }
}

function criaComboboxAtivos($connect, $ativo)
{
    $q = mysqli_query($connect, "SELECT atiId, atiNome FROM tb_ativo");

    if (mysqli_num_rows($q) > 0) {
        while ($row = mysqli_fetch_array($q)) {
            if(isset($ativo)){
                if($ativo == $row['atiId'])
                    echo "<option value=".$row['atiId']." selected>".$row['atiNome']."</option>";
                else
                    echo "<option value=".$row['atiId'].">".$row['atiNome']."</option>";
            }else{
                echo "<option value=".$row['atiId'].">".$row['atiNome']."</option>";
            }
        }
    }
}

function criaComboboxProvedor($connect, $ip)
{
    $q = mysqli_query($connect, "SELECT proId, proNome FROM tb_provedor");

    if (mysqli_num_rows($q) > 0) {
        while ($row = mysqli_fetch_array($q)) {
            if(isset($ip)){
                if($ip == $row['proId'])
                    echo "<option value=".$row['proId']." selected>".$row['proNome']."</option>";
                else
                    echo "<option value=".$row['proId'].">".$row['proNome']."</option>";
            }else{
                echo "<option value=".$row['proId'].">".$row['proNome']."</option>";
            }
        }
    }
}

function verificaVlan($pdo, $vlan, $campus)
{
    $verifica = "select vlanId from tb_vlan where camId=:campus and vlanId=:vlan";

    $stmt = $pdo->prepare($verifica);

    $stmt->bindValue(":vlan", $vlan);
    $stmt->bindValue(":campus", $campus);

    $stmt->execute();
    
    

    if ($stmt->rowcount() >= 1) {
        return 1;
    }
    return 0;
}

?>