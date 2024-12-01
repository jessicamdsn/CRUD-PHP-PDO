<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
	// enviar os parâmetros de conexão para as variáveis
	$host 	= "localhost";
	$db 	= "base_teste02";
	$user 	= "root";
	$pass 	= "";

	try {
		$pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);

		// definir tratamento de erros
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$nome 		= $_POST['nome'];
		$telefone 	= $_POST['telefone'];
		$email 		= $_POST['email'];
		$senha 		= $_POST['senha'];

		$sql = "INSERT INTO usuarios (nome, telefone, email, senha) VALUES (:nome, :telefone, :email, :senha)";

		$stmt = $pdo->prepare($sql);

		$stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
		$stmt->bindParam(':telefone', $telefone, PDO::PARAM_STR);
		$stmt->bindParam(':email', $email, PDO::PARAM_STR);
		$stmt->bindParam(':senha', $senha, PDO::PARAM_STR);

		$stmt->execute();

		$message = "Usuário inserido com sucesso!";
		
	} catch (PDOExeption $e) {
		echo "Erro: " . $e->getMessage();
	}

} else {
	echo "Você não tem permissão para acessar o site!";
}

?>
<!-- Passo 2: Exibir a mensagem usando JavaScript -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Sucesso!</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="modalMessage">
        Usuário inserido com sucesso!
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>

<!-- Script para exibir o modal e redirecionar para a página de login -->
<script type="text/javascript">
    window.onload = function() {
        var message = "<?php echo $message; ?>";  // Recebe a mensagem PHP
        if (message != "") {
            document.getElementById("modalMessage").innerHTML = message;  // Define a mensagem no modal
            var modal = new bootstrap.Modal(document.getElementById('successModal'));
            modal.show();  // Exibe o modal

            // Após o fechamento do modal, redireciona para a página de login
            setTimeout(function() {
                window.location.href = "login.php";  // Redireciona para a página de login
            }, 3000);  // Atraso de 3 segundos para mostrar o modal antes de redirecionar
        }
    }
</script>

<!-- Incluindo os arquivos do Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>