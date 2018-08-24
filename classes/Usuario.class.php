<?php

class Usuario {

	// método que pega o total de usuários no banco de dados
	public function total_usuarios() {

		 global $pdo;

		 // conta os anúncios no banco
		 $sql = $pdo->query("SELECT COUNT(*) AS u FROM usuarios");
		 $row = $sql->fetch();

		 return $row['u'];
	}

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

		$sql = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email AND senha = :senha");
		$sql->bindValue(":email", $email);
		$sql->bindValue(":senha", md5($senha));
		$sql->execute();

		if ($sql->rowCount() > 0) {
			$dados = $sql->fetch(); // aqui se usa fetch porque são dados de um usuário (uma linha)
			$_SESSION['clogin'] = $dados['id_usuario']; // aqui, atribui-se o id do usuário à sessão
			$_SESSION['usuario'] = $dados['nome']; // para pegar o nome do usuário na sessão 
			return true;
		} else {
			return false;
		}
	}
}
?>