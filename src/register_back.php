<?php
require_once('conexao.php');

if (isset($_POST['criar'])) {
    $prontuario = $_POST['prontuario'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $senha2 = $_POST['senha2'];

    if($prontuario != "" && $nome != "" && $email != "" && $senha != "" && $senha2 != "")
    {
        if($senha == $senha2)
        {
            $senha = $prontuario."//".$senha;
    
            $senha = hash('sha256', $senha);            

            if(Inserir("tb_usuario","usrLogin, usrSenha, usrNome, usrEmail","'".$prontuario."', '".$senha."', '".$nome."', '".$email."'"));
                header("Location:login.php");
        }
    }
}
?>