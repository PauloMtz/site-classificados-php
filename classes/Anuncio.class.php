<?php
class Anuncio {

	public function getMeusAnuncios() {

		global $pdo;

		// criar um array vazio, porque se não entrar no if, o array continua vazio
		$array = array();

		$sql = $pdo->prepare("SELECT *,
			/* seleciona uma imagem na tabela de imagens */
			(SELECT url FROM anuncios_imagens WHERE anuncios_imagens.anuncio_id = anuncios.id_anuncio LIMIT 1) AS url 
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
}
?>