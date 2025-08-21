<?php
session_start();
// Arquivos de conexão com banco e verificação das permissões de tela, respectivamente
require_once('conexao.php');
require_once('permissoes.php');

// Verifica se o usuário tem permissão de adm
if($_SESSION['perfil'] != 1){
    echo "<script>alert('Acesso negado!').window.location.href='principal.php';</script>";
    exit();
}

// Inicializa a variável para evitar erros
$funcionario = [];

// Se o formulário for enviado, busca o funcionário pelo ID ou nome
if($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['busca'])){
    $busca = trim($_POST['busca']);

    // Verifica se a busca é um número ou um nome
    if(is_numeric($busca)){
        // Criando o comando sql e protegendo de ataques com stmt
        $sql = "SELECT * FROM funcionario WHERE id_funcionario = :busca ORDER BY nome_funcionario ASC";
        $stmt = $pdo -> prepare($sql);
        $stmt -> bindParam(':busca',$busca, PDO::PARAM_INT);
    } else{
        // Criando o comando sql e protegendo de ataques com stmt
        $sql = "SELECT * FROM funcionario WHERE nome_funcionario LIKE :busca_nome ORDER BY nome_funcionario ASC";
        $stmt = $pdo -> prepare($sql);
        $stmt -> bindValue(':busca_nome',"$busca%", PDO::PARAM_STR);
    }
} else{
    // Criando o comando sql e protegendo de ataques com stmt
    $sql = "SELECT * FROM funcionario ORDER BY nome_funcionario ASC";
    $stmt = $pdo -> prepare($sql);
}

// Executa o comando sql
$stmt -> execute();
$funcionarios = $stmt -> fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css"/>
    <title>Buscar funcionário</title>
</head>
<body>

     <h2>Lista de funcionários</h2>

     <form action="buscar_funcionario.php" method="POST">
        <label for="busca">Digite o ID ou NOME(opcional):</label>
        <input type="text" id="busca" name="busca"/>
        <button type="submit">Pesquisar</button>
     </form>
     <!--Verificando se a tabela 'funcionario' não está vazia-->
     <?php if(!empty($funcionarios)): ?>
     <table class="tabela">
            <tr>
               <th>ID</th>
               <th>Nome</th>
               <th>Endereço</th>
               <th>Telefone</th>
               <th>Email</th>
               <th>Ações</th>
            </tr>
        <!--Percorrendo o array que contém as informações dos funcionários-->
        <?php foreach($funcionarios as $funcionario): ?>
            <tr>
               <td><?= htmlspecialchars($funcionario['id_funcionario']) ?></td>
               <td><?= htmlspecialchars($funcionario['nome_funcionario']) ?></td>
               <td><?= htmlspecialchars($funcionario['endereco']) ?></td>
               <td><?= htmlspecialchars($funcionario['telefone']) ?></td>
               <td><?= htmlspecialchars($funcionario['email']) ?></td>
               <td>
                <a href="alterar_funcionario.php?id=<?= htmlspecialchars
                ($funcionario['id_funcionario'])?>">Alterar</a>

                <a href="excluir_funcionario.php?id=<?= htmlspecialchars
                ($funcionario['id_funcionario'])?>"onclick="return confirm
                ('Tem certeza que deseja excluir este funcionário?')">Excluir</a>

               </td>
            </tr>
        <?php endforeach; ?>
      </table>
      <?php else: ?>
      <p>Nenhum funcionário encontrado</p>
      <?php endif; ?>

      <a href="principal.php">Voltar</a>
      <br><br>
      <center>
        <address>Gustavo Fratoni Boeing</address>
     </center>
</body>
</html>