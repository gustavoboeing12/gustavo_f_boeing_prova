<?php
session_start();
// Arquivos de conexão com banco e verificação das permissões de tela, respectivamente
require_once('conexao.php');
require_once('permissoes.php');

// Verifica se o usuario tem permissão de adm
if($_SESSION['perfil'] != 1){
    echo "Acesso negado!";
}

// Se o método de envio do formulário for via 'POST'
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $nome_funcionario = $_POST['nome_funcionario'];  
    $endereco = $_POST['endereco'];  
    $telefone = $_POST['telefone'];  
    $email = $_POST['email'];  
    
    // Variável SQL para cadastrar informações no banco de dados
    $sql = "INSERT INTO funcionario(nome_funcionario,endereco,telefone,email)
            VALUES (:nome_funcionario,:endereco,:telefone,:email)";
    // Statement para proteger a variável sql de ataques
    $stmt = $pdo -> prepare($sql);
    $stmt -> bindParam(":nome_funcionario",$nome_funcionario);
    $stmt -> bindParam(":endereco",$endereco);
    $stmt -> bindParam(":telefone",$telefone);
    $stmt -> bindParam(":email",$email);
    
    // Caso o cadastro seja bem-sucedido
    if($stmt -> execute()){
        echo "<script>alert('Funcionário cadastrado com sucesso!');</script>";
    } else{
        echo "<script>alert('Erro ao cadastrar funcionário');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css"/>
    <script src="validacoes.js"></script>
    <title>Cadastrar funcionário</title>
    <style>
        .phone{
            width: 400px;
        }
    </style>
</head>
<body>
     
     <h2>Cadastrar funcionário</h2>

     <form action="cadastro_funcionario.php" method="POST">
        <label for="nome_funcionario">Nome: </label>
        <input type="text" id="nome_funcionario" name="nome_funcionario" minlength="3" required/>

        <label for="endereco">Endereço: </label>
        <input type="text" id="endereco" name="endereco" minlength="5" required/>

        <label for="telefone">Telefone:</label>
        <input type="text" id="telefone" name="telefone" class="phone" size="15" maxlength="15" required/>

        <label for="email">Email: </label>
        <input type="email" id="email" name="email" minlength="5" required/>

        <button type="submit" onclick return="validarCadastroFuncionario()">Salvar</button>
        <button type="reset">Cancelar</button>
     </form>
     <a href="principal.php">Voltar</a>
     <br><br>
     <center>
        <address>Gustavo Fratoni Boeing</address>
     </center>
     
     <script type="text/javascript" src="valida.js"></script>
</body>
</html>