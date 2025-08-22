<?php
session_start();
require_once('conexao.php');
require_once('permissoes.php');

// Verifica se o usuário tem permissão de adm
if($_SESSION['perfil'] != 1){
    echo "<script>alert('Acesso negado!').window.location.href='principal.php';</script>";
    exit();
}

// Inicializa variáveis
$usuario = null;
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(!empty($_POST['busca_usuario'])){
        $busca = trim($_POST['busca_usuario']);

        // Verifica se a busca é um número(id) ou um nome
        if(is_numeric($busca)){
            $sql = "SELECT * FROM usuario WHERE id_usuario = :busca ORDER BY nome";
            $stmt = $pdo -> prepare($sql);
            $stmt -> bindParam(':busca',$busca,PDO::PARAM_INT);
        } else{
            $sql = "SELECT * FROM usuario WHERE nome LIKE :busca_nome ORDER BY nome";
            $stmt = $pdo -> prepare($sql);
            $stmt -> bindValue(':busca_nome',"$busca%",PDO::PARAM_STR);
        }
        $stmt -> execute();
        $usuario = $stmt -> fetch(PDO::FETCH_ASSOC);

        // Se o usuário não for encontrado, exibe um alerta
        if(!$usuario){
            echo "<script>alert('Usuário não encontrado!');</script>";
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
    <script type="text/javascript" src="valida.js"></script>
    <script src="script.js"></script>
    <title>Alterar usuário</title>
</head>
<body>

     <h2>Alterar usuário</h2>

     <form action="alterar_usuario.php" method="POST">
        <label for="busca_usuario">Digite o ID ou nome do usuário</label>
        <input type="text" id="busca_usuario" name="busca_usuario" required onkeyup="buscarSugestoes()">
        <!--DIV para exibir sugestões de usuários-->
        <div id="sugestoes"></div>

        <button type="submit">Pesquisar</button>
     </form>

     <?php if($usuario): ?>
       <!--Formulário para alterar usuário-->
       <form action="processa_alteracao_usuario.php" method="POST">
          <input type="hidden" name="id_usuario" 
           value="<?= htmlspecialchars($usuario['id_usuario']) ?>">

           <label for="nome">Nome:</label>
           <input type="text" id="nome" name="nome" 
           value="<?= htmlspecialchars($usuario['nome']) ?>" title="Apenas letras" placeholder="Gustavo Boeing" minlength="3" required pattern="[A-Za-zÁ-ÿ\s]+">

           <label for="email">Email:</label>
           <input type="email" id="email "name="email" 
           value="<?= htmlspecialchars($usuario['email']) ?>" title="Coloque um email válido" placeholder="Email@gmail.com" minlength="5" required>

           <label for="id_perfil">Perfil:</label>
           <select id="id_perfil" name="id_perfil">
              <option value="1" <?=$usuario['id_perfil'] == 1 ? 'select':''?>>Administrador</option>
              <option value="2" <?=$usuario['id_perfil'] == 1 ? 'select':''?>>Secretária</option>
              <option value="3" <?=$usuario['id_perfil'] == 1 ? 'select':''?>>Almoxarife</option>
              <option value="4" <?=$usuario['id_perfil'] == 1 ? 'select':''?>>Cliente</option>
           </select>
       <!--Se o usuário logado for adm, exibir opção de alterar senha-->
       <?php if($_SESSION['perfil'] == 1): ?>
           <label for="nova_senha">Nova senha</label>
           <input type="password" id="nova_senha" name="nova_senha" title="Deve conter pelo menos 8 caracteres" placeholder="12345678" minlength="8">
       <?php endif; ?>

           <button type="submit" onclick return="validarFormularioUsuario()">Alterar</button>
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

