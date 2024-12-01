<?php
session_start();  // Inicia a sessão

// Verifica se o usuário está logado
if (!isset($_SESSION["user_id"])) {
    header("Location: login.html");  // Redireciona para a página de login se não estiver logado
    exit;
}

// Conectar ao banco de dados
$host   = "localhost";
$bd     = "base_teste02";
$user   = "root";
$pass   = "";

try {
    // Criação da conexão com o banco
    $pdo = new PDO("mysql:host=$host;dbname=$bd", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Recupera o ID do usuário logado da sessão
    $id = $_SESSION["user_id"];

    // Verifica se os dados foram enviados pelo formulário
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtém os dados do formulário
        $nome      = $_POST['nome'];
        $telefone  = $_POST['telefone'];
        $email     = $_POST['email'];
        $senha     = $_POST['senha'];

        // Atualiza os dados no banco de dados
        $sql = "UPDATE usuarios SET nome = :nome, telefone = :telefone, email = :email, senha = :senha WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":telefone", $telefone);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":senha", $senha);
        $stmt->bindParam(":id", $id);

        $stmt->execute();

        // Redireciona para a página de perfil após a atualização
        header("Location: perfil.php");
        exit;
    }

} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>
