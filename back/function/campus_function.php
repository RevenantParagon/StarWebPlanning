<?php
require_once('../config.php');

function buscarCampus($connect, $pdo)
{
    $select = "SELECT camId 'ID', camCampus 'Campus', camSigla 'Sigla' from tb_campus ";
    
    if($_SESSION['tipo'] == 0)
        $select = $select." where camId = ".$_SESSION["campus"]; 
    $q = mysqli_query($connect, $select);
    
    if (mysqli_num_rows($q) > 0) {
        while ($row = mysqli_fetch_array($q)) {
            echo "<tr><td>" . $row['ID'] . "</td>
                <td>" . $row['Campus'] . "</td>
                <td>" . $row['Sigla'] . "</td>
                <td align='center'><a href='../src/campus.php?funcao=editar&id=". $row['ID']."'><i class='fas fa-edit'></i></a></td>";  
            if($_SESSION['tipo'] == 1)
                echo "<td align='center'><a href='../back/campus_back.php?funcao=deletar&id=". $row['ID']."'><i class='fas fa-trash-alt'></i></a></td>";
                echo "<td align='center'><a href='../src/ip.php?campus=".$row['ID']."'><i class='fas fa-network-wired'></i></a>   <a href='../src/visualiza_vlan.php?campus=".$row['ID']."'><i class='fas fa-ethernet'></i></a>   <a href='../src/visualiza_ativo.php?campus=".$row['ID']."'><i class='fas fa-wifi'></i></a></td>";
                
                //<td align='center'><a href='#' onclick='javascript: if (confirm('Você realmente deseja excluir esta mensagem?'))location.href='../back/users_back.php?tipo=deletar&id=". $row['ID']."''
        }
    }
}

function voltarCampus($pdo, $id)
{
    $select = "select camCampus 'campus', camSigla 'sigla', camIP 'ip' from tb_campus where camId=:id";

    $stmt = $pdo->prepare($select);

    $stmt->bindValue(":id", $id);

    $stmt->execute();
    
    if ($stmt->rowcount() == 1) {
        return $row =$stmt->fetch();
    }
}
?>