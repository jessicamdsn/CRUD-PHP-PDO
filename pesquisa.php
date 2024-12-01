<?php

session_start(); // Inicializa a sessão

// Verificar se o usuário está logado
if (!isset($_SESSION["user_id"])) {
  header("Location: login.html"); // Redireciona para a página de login se não estiver logado
    exit;
}

$nome = $telefone = $email = $senha = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $host   =   "localhost";
    $bd     =   "base_teste02";
    $user   =   "root";
    $pass   =   "";


    try {

        $pdo = new PDO("mysql:host=$host;dbname=$bd", $user, $pass);

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $id = $_POST["id"];

        $sql = "SELECT * FROM usuarios WHERE id = :id";

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $nome         = $row["nome"];
            $telefone     = $row["telefone"];
            $email         = $row["email"];
            $senha         = $row["senha"];
        } else {
            $nome = $telefone = $email = $senha = "";
        }

    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }

}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Atualização cadastral</title>

    <link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/login.css">
</head>
<body >

<nav class="navbar navbar-dark  bg-savage">
      <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="sistema.php">TrioElegante</a>
      <a class="nav-link active text-light" href="perfil.php">Perfil</a>
      <a class="nav-link active text-light" href="pesquisa.php">Pesquisa</a>
      <a class="nav-link active text-light" href="logout.php">Sair</a>
    </nav>
    <div  class="form-atualiza">
    <h2>Atualizar cadastro</h2>
    <br>

    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        ID: <input type="text" name="id">
        <input  class="btn btn-savage " type="submit" value="pesquisar">
    </form>

    <hr>

    <form method="post" action="atualizar.php">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <p>
            <label>Nome:</label><br>
            <input type="text" name="nome" value="<?php echo $nome; ?>">
        </p>
        <p>
            <label>Telefone:</label><br>
            <input type="number" name="telefone" value="<?php echo $telefone; ?>">
        </p>
        <p>
            <label>E-mail:</label><br>
            <input type="email" name="email" value="<?php echo $email; ?>">
        </p>

    </form>
    <script src="js/jquery-3.3.1.slim.min.js"></script>
		<script src="js/popper.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/script.js"></script>
</body>
</html>