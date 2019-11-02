<?php
require_once('../config.php');

if (isset($_POST['criar'])) {
    $prontuario = strtoupper($_POST['prontuario']);
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $senha2 = $_POST['senha2'];

    if($prontuario != "" && $nome != "" && $email != "" && $senha != "" && $senha2 != "")
    {
        if($senha == $senha2)
        {
            $verifica = mysqli_query($GLOBALS['connect'], "SELECT * FROM tb_usuario") or die("erro ao selecionar");

            if (mysqli_num_rows($verifica)==0)
            {
                $senha = $prontuario."//".$senha;
        
                $senha = hash('sha256', $senha);            

                $insert = "INSERT INTO tb_usuario(usrId, usrLogin, usrSenha, usrNome, usrEmail, camId, usrTipo) VALUES(1,:usuario,:senha,:nome,:email,3, '1')";

                $stmt = $pdo->prepare($insert);
            
                $stmt->bindValue(":usuario", $prontuario);
                $stmt->bindValue(":senha", $senha);
                $stmt->bindValue(":nome", $nome);
                $stmt->bindValue(":email", $email);
            
                $stmt->execute();

                if ($stmt->rowcount()>0)
                    header("Location:../src/login.php");
                else
                {
                    echo"<script>
                    alert('Houve um erro na inserção!');window.location
                    .href='../src/register.php';</script>";
                    die();
                }
            }
            else
            {
                echo"<script>
                alert('Já existe um usuário cadastrado!');window.location
                .href='../src/register.php';</script>";
                die();
            }     
        }
        else
            {
                echo"<script>
                alert('As senha são divergentes!');window.location
                .href='../src/register.php';</script>";
                die();
            }
    }
    else
    {
        echo"<script>
        alert('Algum Campo está em branco!');window.location
        .href='../src/register.php';</script>";
        die();                
    }
}
