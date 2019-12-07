<?php
require_once('../config.php');

function buscarEquip($connect, $pdo)
{
    $select = "SELECT equId 'ID', equMarca 'Marca', equModelo 'Modelo', if(equTipo=0,'Switch',if(equTipo=1,'Pabx',if(equTipo=2,'Controlador de Wifi',if(equTipo=3,'Roteador','Firewall')))) 'Tipo', equQtdePorta 'Porta'  from tb_equipamento ";

    $q = mysqli_query($connect, $select);

    if (mysqli_num_rows($q) > 0) {
        while ($row = mysqli_fetch_array($q)) {
            echo "<tr><td>" . $row['ID'] . "</td>
                <td>" . $row['Marca'] . "</td>
                <td>" . $row['Modelo'] . "</td>
                <td>" . $row['Tipo'] . "</td>
                <td>" . $row['Porta'] . "</td>
                <td align='center'><a href='../src/equip.php?funcao=editar&id=" . $row['ID'] . "'><i class='fas fa-edit'></i></a></td>
                <td align='center'><a href='../back/equip_back.php?funcao=deletar&id=" . $row['ID'] . "'><i class='fas fa-trash-alt'></i></a></td>";
        }
    }
}

function voltarEquip($pdo, $id)
{
    $select = "select equMarca 'marca', equModelo 'modelo', equTipo 'tipo', equQtdePorta 'porta', equLado 'lado', equOrdem 'ordem', equDirecao 'direcao', equLinha 'linha' from tb_equipamento where equId=:id";

    $stmt = $pdo->prepare($select);

    $stmt->bindValue(":id", $id);

    $stmt->execute();

    if ($stmt->rowcount() == 1) {
        return $row = $stmt->fetch();
    }
}
