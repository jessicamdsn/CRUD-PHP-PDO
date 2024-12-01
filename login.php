<?php
session_start(); // Inicializa a sessão

// Função para exibir a página de login com mensagens dinâmicas
function exibirPaginaLogin($mensagemErro = null) {
    echo '<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/login.css">
    <title>Login</title>
</head>

<body>
	<div class="container">
		<form method="post" class="form-signin" action="login.php">
			<img class="mb-4" src="img/logo.png" alt="" width="72" height="72">
			<h1 class="h3 mb-3 font-weight-normal">Faça login</h1>';

        // Exibe a mensagem de erro acima do campo de email, se houver
        if ($mensagemErro) {
            echo '<div class="alert alert-danger">' . htmlspecialchars($mensagemErro) . '</div>';
        }

    echo '
        <label for="inputEmail" class="sr-only">Endereço de email</label>
			<input type="email" id="inputEmail" class="form-control" name="email" placeholder="Seu email" required autofocus>
			<br>
			<label for="inputPassword" class="sr-only">Senha</label>
			<input type="password" id="inputPassword" class="form-control" name="senha" placeholder="Senha" required>
			<div class="checkbox mb-3">
				<label>
					<input type="checkbox" value="remember-me"> Lembrar de mim
				</label>
			</div>
			<button class="btn btn-lg btn-savage btn-block" type="submit">Login</button>
			<p>Ainda não possui uma conta? <a href="formularioCadastro.html"> Crie aqui</a></p>
			<p class="mt-5 mb-3 text-muted">&copy; TrioElegante - 2024</p>
		</form>

		<div class="banner">
			<h2 class="h2 mb-3 font-weight-normal">Descubra coisas incriveis em nossa plataforma</h2>
			<img class="mb-4" src="img/img.png" alt="" width="200" height="200">
		</div>
	</div>';
    echo '</body>
</html>';
}
// Verificar se é uma requisição POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "base_teste02";

    $conn = mysqli_connect($host, $user, $pass, $db);

    // Verificar conexão com o banco de dados
    if (!$conn) {
        exibirPaginaLogin("Falha na conexão: " . mysqli_connect_error());
        exit;
    }

    // Capturar e validar dados do formulário
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    if (empty($email) || empty($senha)) {
        exibirPaginaLogin("Por favor, preencha todos os campos.");
        exit;
    }

    // Consulta SQL segura com prepared statements
    $stmt = mysqli_prepare($conn, "SELECT id, email, nome, senha FROM usuarios WHERE email = ?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Verificar se o email existe
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Validar senha
        if ($senha == $row['senha']) {
            $_SESSION["user_id"] = $row['id'];
            $_SESSION["email"] = $row['email'];
            $_SESSION["nome"] = $row['nome'];

            // Redirecionar para o sistema (menu de opções)
            header("Location: sistema.php");
            exit;
        } else {
            exibirPaginaLogin("Senha incorreta.");
        }
    } else {
        exibirPaginaLogin("Email não encontrado.");
    }

    // Fechar conexão
    mysqli_close($conn);
} else {
    exibirPaginaLogin(); // Exibir página de login padrão
}
