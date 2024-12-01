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

    // Verifica se o ID do usuário foi passado via POST
    if (isset($_POST['id'])) {
        $id = $_POST['id'];  // Recebe o ID via POST

        // Deleta o usuário do banco de dados
        $sql = "DELETE FROM usuarios WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        // Destrói a sessão após excluir o usuário
        session_destroy();

        // Redireciona para a página de login após a exclusão
        header("Location: login.html");
        exit;
    } else {
        echo "ID do usuário não encontrado.";
    }

} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>
