<?php

class Usuario {

	public function cadastrar($nome, $email, $senha, $telefone) {

		global $pdo;

		// verifica se o usuário já existe no banco de dados
		$sql = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE email = :email");
		$sql->bindValue(":email", $email);
		$sql->execute();

		// se não existir --> então cadastra
		if($sql->rowCount() == 0) {

			$sql = $pdo->prepare("INSERT INTO usuarios SET nome = :nome, email = :email, senha = :senha, telefone = :telefone");
			$sql->bindValue(":nome", $nome);
			$sql->bindValue(":email", $email);
			$sql->bindValue(":senha", md5($senha));
			$sql->bindValue(":telefone", $telefone);
			$sql->execute();

			return true;

		} else {
			return false;
		}

	}

	public function login($email, $senha) {

		global $pdo;

		$sql = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE email = :email AND senha = :senha");
		$sql->bindValue(":email", $email);
		$sql->bindValue(":senha", md5($senha));
		$sql->execute();

		if ($sql->rowCount() > 0) {
			$dados = $sql->fetch(); // aqui se usa fetch porque são dados de um usuário (uma linha)
			$_SESSION['clogin'] = $dados['id_usuario']; // aqui, atribui-se o id do usuário à sessão
			return true;
		} else {
			return false;
		}
	}

	public function getUsuario() {

		global $pdo;

		$sql = $pdo->prepare("SELECT nome FROM usuarios WHERE id_usuario = :id");
		$sql->bindValue(":id", $_SESSION['clogin']);
		$sql->execute();

		if ($sql->rowCount() > 0) {
			$dados = $sql->fetch();
			$_SESSION['clogin'] = $dados['nome'];
		}

		return $_SESSION['clogin'];
	}
}
?>