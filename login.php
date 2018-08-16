<?php require 'temp/header.php';?>
<div class="container">
	<h2>Entre no sitema</h2><hr>
	<?php

	/*
	* A inserção da classe Usuario e a instanciação do objeto
	* tiveram que ser removidas nesse arquivo porque estavam
	* dando conflito com a chamada no arquivo header, ou seja,
	* estavam chamando a mesma classe duas vezes.
	*/
	
	//require 'classes/Usuario.class.php';

	// cria objeto
	//$u = new Usuario();

	// verifica dados enviados pelo formulário
	if(isset($_POST['email']) && !empty($_POST['email'])) {
		$email = addslashes($_POST['email']);
		$senha = $_POST['senha'];

		if ($u->login($email, $senha)) {
		?><!-- aqui não se pode usar o header location porque já html anteriormente (dá erro) -->
			<script type="text/javascript">window.location.href="index.php";</script>
		<?php
		} else {
		?>
			<div class="alert alert-danger">
				<p>Usuário e/ou senha inválidos.</p>
			</div>
		<?php	
		}
	}
	?>
	<form method="POST">
		<div class="row">
			<div class="form-group col-sm-5">
				<label for="email">E-mail:</label>
				<input type="email" name="email" id="email" class="form-control" />
			</div>
		</div>
		<div class="row">
			<div class="form-group col-sm-5">
				<label for="senha">Senha:</label>
				<input type="password" name="senha" id="senha" class="form-control" />
			</div>	
		</div>
		<input type="submit" value="Login" class="btn btn-default" />
	</form>

</div>
<?php require 'temp/footer.php'; ?>