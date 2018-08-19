<?php require 'temp/header.php'; ?>
<div class="container">
	<h2>Cadastre-se</h2><hr>
	<?php

	require 'classes/Usuario.class.php';

	// cria objeto
	$u = new Usuario();

	// verifica dados enviados pelo formulário
	if(isset($_POST['nome']) && !empty($_POST['nome'])) {
		$nome = addslashes($_POST['nome']);
		$email = addslashes($_POST['email']);
		$senha = $_POST['senha'];
		$telefone = addslashes($_POST['telefone']);

		// se os campos não estiverem vazios --> cadastrar
		if(!empty($nome) && !empty($email) && !empty($senha)) {

			// testa se consegue cadastrar
			if($u->cadastrar($nome, $email, $senha, $telefone)) {
				?>
				<div class="alert alert-success">
					<p>Usuário cadastrado com sucesso!</p>
					<a href="login.php" class="alert-link">Entrar no sistema</a>
				</div>
				<?php
			} else { // caso o usuário já esteja cadastrado
				?>
				<div class="alert alert-warning">
					<p>Usuário já cadastrado</p>
					<a href="login.php" class="alert-link">Entrar no sistema</a>
				</div>
				<?php
			}
		} else { // caso o usuário tente enviar os campos em branco
			?>
			<div class="alert alert-warning">
				Preencha os campos do formulário.
			</div>
			<?php
		}
	}
	?>
	<form method="POST">
		<div class="form-group">
			<label for="nome">Nome:</label>
			<input type="text" name="nome" id="nome" class="form-control" autofocus="true" />
		</div>
		<div class="form-group">
			<label for="email">E-mail:</label>
			<input type="email" name="email" id="email" class="form-control" />
		</div>
		<div class="form-group">
			<label for="senha">Senha:</label>
			<input type="password" name="senha" id="senha" class="form-control" />
		</div>
		<div class="form-group">
			<label for="telefone">Telefone:</label>
			<input type="text" name="telefone" id="telefone" class="form-control" />
		</div>
		<input type="submit" value="Cadastrar" class="btn btn-default" />
	</form>

</div>
<?php require 'temp/footer.php'; ?>