<?php
session_start();
// Arquivos de conexão com banco e verificação das permissões de tela, respectivamente
require_once('conexao.php');
require_once('permissoes.php');

// Verifica se o usuario tem permissão de adm
if($_SESSION['perfil'] != 1){
    echo "<script>alert('Acesso negado!').window.location.href='principal.php';</script>";
    exit();
}

// Inicializa variáveis
$funcionario = null;
// Se o envio do formulário for via 'POST'
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(!empty($_POST['busca_funcionario'])){
        $busca = trim($_POST['busca_funcionario']);

        // Verifica se a busca é um número(id) ou um nome
        if(is_numeric($busca)){
            // Variável SQL para cadastrar informações no banco de dados
            $sql = "SELECT * FROM funcionario WHERE id_funcionario = :busca ORDER BY nome_funcionario";
            // Statement para proteger a variável sql de ataques
            $stmt = $pdo -> prepare($sql);
            $stmt -> bindParam(':busca',$busca,PDO::PARAM_INT);
        } else{
            // Variável SQL para cadastrar informações no banco de dados
            $sql = "SELECT * FROM funcionario WHERE nome_funcionario LIKE :busca_nome ORDER BY nome_funcionario";
            // Statement para proteger a variável sql de ataques
            $stmt = $pdo -> prepare($sql);
            $stmt -> bindValue(':busca_nome',"$busca%",PDO::PARAM_STR);
        }
        // Executa o comando sql
        $stmt -> execute();
        $funcionario = $stmt -> fetch(PDO::FETCH_ASSOC);

        // Se o funcionário não for encontrado, exibe um alerta
        if(!$funcionario){
            echo "<script>alert('Funcionário não encontrado!');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css"/>
    <!--Certifique-se que o javascript está sendo carregado corretamente-->
    <script src="script.js"></script>
    <title>Alterar funcionário</title>
</head>
<body>

     <h2>Alterar funcionário</h2>

     <form action="alterar_funcionario.php" method="POST">
        <label for="busca_funcionario">Digite o ID ou nome do usuário</label>
        <input type="text" id="busca_funcionario" name="busca_funcionario" required onkeyup="buscarSugestoes()">
        <!--DIV para exibir sugestões de usuários-->
        <div id="sugestoes"></div>

        <button type="submit">Pesquisar</button>
     </form>

     <?php if($funcionario): ?>
       <!--Formulário para alterar usuário-->
       <form action="processa_alteracao_funcionario.php" method="POST">
          <input type="hidden" name="id_funcionario" 
           value="<?= htmlspecialchars($funcionario['id_funcionario']) ?>">

           <label for="nome_funcionario">Nome:</label>
           <input type="text" id="nome_funcionario" name="nome_funcionario" 
           value="<?= htmlspecialchars($funcionario['nome_funcionario']) ?>" required>

           <label for="endereco">Endereco:</label>
           <input type="text" id="endereco "name="endereco" 
           value="<?= htmlspecialchars($funcionario['endereco']) ?>" required>

           <label for="telefone">Telefone:</label>
           <input type="number" id="telefone "name="telefone" 
           value="<?= htmlspecialchars($funcionario['telefone']) ?>" required>

           <label for="email">E-mail:</label>
           <input type="email" id="email "name="email" 
           value="<?= htmlspecialchars($funcionario['email']) ?>" required>

           <button type="submit">Alterar</button>
           <button type="reset">Cancelar</button>
       </form>
     <?php endif; ?>

     <a href="principal.php">Voltar</a>
     <br><br>
     <center>
        <address>Gustavo Fratoni Boeing</address>
     </center>
</body>
</html>

