<?php
session_start(); // Inicializa a sessão

// Verificar se o usuário está logado
if (!isset($_SESSION["user_id"])) {
  header("Location: login.html"); // Redireciona para a página de login se não estiver logado
    exit;
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Sistema web</title>

    <link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/login.css">
  </head>

  <body class="text-center">
    <nav class="navbar navbar-dark  bg-savage">
      <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">TrioElegante</a>
      <a class="nav-link active text-light" href="perfil.php">Perfil</a>
      <a class="nav-link active text-light" href="pesquisa.php">Pesquisa</a>
      <a class="nav-link active text-light" href="logout.php">Sair</a>
    </nav>
    <div class="conteudo" >
      <h1 class="h1 mb-3 c-savage">Bem-vindo(a) a nossa plataforma</h1>
    <section class="py-5">
      <div class="tamanho">
        <h2>TrioElegante!</h2>
      <p>Aqui você pode explorar todos os usuários registrados e gerenciar informações de maneira simples e eficiente. Use o menu de navegação para acessar funcionalidades como visualizar perfis, editar dados ou adicionar novos usuários. Sinta-se à vontade para explorar e aproveitar tudo o que nossa plataforma tem a oferecer!</p>
      </div>
      
    </section>
    </div>


  <footer class=" text-white text-center py-3">
    <div class="container1">
    <p class="mt-5 mb-3 text-muted">&copy; TrioElegante - 2024</p>
    </div>
  </footer>

  
    <script src="js/jquery-3.3.1.slim.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/jquery-slim.min.js"><\/script>')</script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

  </body>
</html>
