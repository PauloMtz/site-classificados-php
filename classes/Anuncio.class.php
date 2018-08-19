<?php
class Anuncio {

	// esse método é utilizado na página para exibir os anúncios do usuário (meus-anuncios.php)
	public function getMeusAnuncios() {

		global $pdo;

		// criar um array vazio, porque se não entrar no if, o array continua vazio
		$array = array();

		$sql = $pdo->prepare("SELECT *,
			(SELECT anuncios_imagens.url FROM anuncios_imagens WHERE anuncios_imagens.anuncio_id = anuncios.id_anuncio LIMIT 1) AS url 
		FROM anuncios WHERE usuario_id = :usuario");
		$sql->bindValue(":usuario", $_SESSION['clogin']);
		$sql->execute();

		// se $sql retornar alguma coisa
		if ($sql->rowCount() > 0) {

			// joga tudo o que encontrar dentro do array
			$array = $sql->fetchAll();
		}

		return $array;
	}

	// esse método será usado para recuperar os dados do formulário quendo da edição
	public function getAnuncio($id) {

		$array = array();

		global $pdo;

		$sql = $pdo->prepare("SELECT * FROM anuncios WHERE id_anuncio = :id");
		$sql->bindValue(":id", $id);
		$sql->execute();

		if ($sql->rowCount() > 0) {
			$array = $sql->fetch();
		}

		return $array;
	}

	// método para inserir anúncio no banco de dados
	public function addAnuncio($categoria, $titulo, $descricao, $valor, $estado) {

		global $pdo;

		$sql = $pdo->prepare("INSERT INTO anuncios SET usuario_id = :usuario, categoria_id = :categoria, titulo = :titulo, descricao = :descricao, valor = :valor, estado = :estado");
		$sql->bindValue(":usuario", $_SESSION['clogin']);
		$sql->bindValue(":categoria", $categoria);
		$sql->bindValue(":titulo", $titulo);
		$sql->bindValue(":descricao", $descricao);
		$sql->bindValue(":valor", $valor);
		$sql->bindValue(":estado", $estado);
		$sql->execute();
	}

	// esse método foi copiado do addAnuncio e apenas adicionado o id
	public function editAnuncio($categoria, $titulo, $descricao, $valor, $estado, $id) {

		global $pdo;

		$sql = $pdo->prepare("UPDATE anuncios SET usuario_id = :usuario, categoria_id = :categoria, titulo = :titulo, descricao = :descricao, valor = :valor, estado = :estado WHERE id_anuncio = :id");
		$sql->bindValue(":usuario", $_SESSION['clogin']);
		$sql->bindValue(":categoria", $categoria);
		$sql->bindValue(":titulo", $titulo);
		$sql->bindValue(":descricao", $descricao);
		$sql->bindValue(":valor", $valor);
		$sql->bindValue(":estado", $estado);
		$sql->bindValue(":id", $id);
		$sql->execute();
	}

	public function excluirAnuncio($id) {

		global $pdo;

		// excluir imagens referentes ao anúncio
		$sql = $pdo->prepare("DELETE FROM anuncios_imagens WHERE id_anuncio_img = :id_anuncio");
		$sql->bindValue(":id_anuncio", $id);
		$sql->execute();

		// excluir o anúncio
		$sql = $pdo->prepare("DELETE FROM anuncios WHERE id_anuncio = :id");
		$sql->bindValue(":id", $id);
		$sql->execute();
	}
}
?>