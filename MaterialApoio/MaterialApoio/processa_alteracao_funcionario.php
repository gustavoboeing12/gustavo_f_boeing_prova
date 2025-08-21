<?php
session_start();
// Arquivos de conexão com banco e verificação das permissões de tela, respectivamente
require ('conexao.php');
require ('permissoes.php');

// Verifica se o usuario tem permissão de adm
if($_SESSION['perfil'] != 1){
    echo "<script>alert('Acesso negado!');window.location.href='principal.php';</script>";
    exit();
}

// Se o método de envio do formulário for via 'POST'
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $id_funcionario = $_POST['id_funcionario'];
    $nome_funcionario = $_POST['nome_funcionario'];
    $endereco = $_POST['endereco'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    
    // Faz o comando sql no banco e o  protege de ataques
    $sql = "UPDATE funcionario SET nome_funcionario=:nome_funcionario, endereco=:endereco, telefone=:telefone, email=:email
            WHERE id_funcionario = :id";
    $stmt = $pdo -> prepare($sql);
    $stmt -> bindParam(':id',$id_funcionario);
    $stmt -> bindParam(':nome_funcionario',$nome_funcionario);
    $stmt -> bindParam(':endereco',$endereco);
    $stmt -> bindParam(':telefone',$telefone);
    $stmt -> bindParam(':email',$email);

    // Se o comando for executado
    if($stmt -> execute()){
        echo "<script>alert('Usuário atualizado com sucesso!');window.location.href='buscar_funcionario.php';</script>";
    } else{
        echo "<script>alert('Erro ao atualizar usuário!');window.location.href='alterar_funcionario.php?id=$id_funcionario';</script>";
    }
}

?>