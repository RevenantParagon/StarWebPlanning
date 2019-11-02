<?php
require_once('../config.php');

function criaCombobox($connect, $campus)
{
    $q = mysqli_query($connect, "SELECT camID, concat(camCampus,'-',camSigla) 'Campus' FROM tb_campus");

    if (mysqli_num_rows($q) > 0) {
        while ($row = mysqli_fetch_array($q)) {
            if(isset($campus)){
                if($campus == $row['camID'])
                    echo "<option value=".$row['camID']." selected>".$row['Campus']."</option>";
                else
                    echo "<option value=".$row['camID'].">".$row['Campus']."</option>";
            }else{
                echo "<option value=".$row['camID'].">".$row['Campus']."</option>";
            }
        }
    }
}


function buscarUsuario($connect, $pdo)
{
    $q = mysqli_query($connect, "SELECT u.usrID 'ID', u.usrNome 'Nome', u.usrLogin 'Login', concat(c.camCampus,'-',c.camSigla) 'Campus' FROM tb_usuario u join tb_campus c on c.camID = u.camID");

    if (mysqli_num_rows($q) > 0) {
        while ($row = mysqli_fetch_array($q)) {
            echo "<tr><td>" . $row['ID'] . "</td>
                <td>" . $row['Nome'] . "</td>
                <td>" . $row['Login'] . "</td>
                <td>" . $row['Campus'] . "</td>
                <td align='center'><a href='../src/users.php?funcao=1&id=" . $row['ID'] . "'><i class='fas fa-edit'></i></a></td>
                <td align='center'><a href='../back/users_back.php?tipo=deletar&id=".$row['ID'] ."'><i class='fas fa-trash-alt'></i></a></td></tr>";
            //<td align='center'><a href='../back/users_back.php?tipo=deletar&id=". $row['ID']."'><i class='fas fa-trash-alt'></i></a></td></tr>";
            //
        }
    }
}


function valida($id)
{
    ?>
    <script>
    if (confirm("Deseja realmente excluir item selecionado?")) {
        <?php echo "../back/users_back.php?tipo=deletar&id=".$id."'"; ?>
    }
    </script>
    <?php
}

function voltarUsuario($pdo, $id)
{
    $select = "select usrLogin 'prontuario', usrNome 'nome', usrEmail 'email', camId 'campus', usrTipo 'tipoUsuario' from tb_usuario where usrId=:id";

    $stmt = $pdo->prepare($select);

    $stmt->bindValue(":id", $id);

    $stmt->execute();

    if ($stmt->rowcount() == 1) {
        return $row = $stmt->fetch();
    }
}
