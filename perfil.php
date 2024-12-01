<?php
session_start();  // Inicia a sessão

// Verifica se o usuário está logado
if (!isset($_SESSION["user_id"])) {
  header("Location: login.html"); // Redireciona para a página de login se não estiver logado
    exit;
}

// Conectar ao banco de dados
$host   = "localhost";
$bd     = "base_teste02";
$user   = "root";
$pass   = "";

$nome = $telefone = $email = $senha = "";

try {
    // Criação da conexão com o banco
    $pdo = new PDO("mysql:host=$host;dbname=$bd", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Recupera o ID do usuário logado da sessão
    $id = $_SESSION["user_id"];

    // Consulta os dados do usuário no banco
    $sql = "SELECT * FROM usuarios WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $nome     = $row["nome"];
        $telefone = $row["telefone"];
        $email    = $row["email"];
        $senha    = $row["senha"];
    }

} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="css/login.css">
    <title>Perfil - Atualizar Cadastro</title>
    <script>
        function confirmarDelecao() {
    var resposta = confirm("Você tem certeza de que deseja deletar sua conta? Esta ação não pode ser desfeita.");
    if (resposta) {
        document.forms[0].submit();  // Submete o formulário de exclusão
    }
}
    </script>
</head>
<body class="text-center">

<nav class="navbar navbar-dark  bg-savage">
      <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="sistema.php">TrioElegante</a>
      <a class="nav-link active text-light" href="perfil.php">Perfil</a>
      <a class="nav-link active text-light" href="pesquisa.php">Pesquisa</a>
      <a class="nav-link active text-light" href="logout.php">Sair</a>
    </nav>
<div  class="form-atualiza">
    <form method="post" action="atualizar.php">
      <h1 class="h3 mb-3 ">Atualizar Cadastro</h1>
        <input type="hidden" name="id" value="<?php echo $id; ?>">

        <p>
            <label class="sr-only">Nome:</label><br>
            <input class="form-control" type="text" name="nome" value="<?php echo $nome; ?>">
        </p>

        <p>
            <label class="sr-only">Telefone:</label><br>
            <input class="form-control" type="text" name="telefone" value="<?php echo $telefone; ?>">
        </p>

        <p>
            <label class="sr-only">E-mail:</label><br>
            <input class="form-control" type="email" name="email" value="<?php echo $email; ?>">
        </p>

        <p>
            <label class="sr-only">Senha:</label><br>
            <input class="form-control" type="password" name="senha" value="<?php echo $senha; ?>">
        </p>

        <p>
            <input class="btn btn-lg btn-savage btn-block" type="submit" value="Atualizar cadastro">
        </p>
        
    </form>
    <form method="post" action="deletar.php" id="formDeletar">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <button type="button" class="btn btn-lg btn-danger btn-block" onclick="confirmarDelecao()">Deletar Conta</button>
</form>
</div>
    
<script>
    function confirmarDelecao() {
        // Exibe o popup de confirmação
        var resposta = confirm("Você tem certeza que deseja excluir sua conta? Esta ação não pode ser desfeita.");
        if (resposta) {
            // Se o usuário confirmar, envia o formulário de exclusão
            document.getElementById("formDeletar").submit();
        } else {
            // Caso o usuário cancele, nada acontece
            return false;
        }
    }
</script>
    <script src="js/jquery-3.3.1.slim.min.js"></script>
		<script src="js/popper.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/script.js"></script>
</body>
</html>
