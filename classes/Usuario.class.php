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
}
?>