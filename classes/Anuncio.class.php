<?php
class Anuncio {

	// método que pega o total de anúncios no banco de dados
	public function total_anuncios() {

		 global $pdo;

		 // conta os anúncios no banco
		 $sql = $pdo->query("SELECT COUNT(*) AS c FROM anuncios");
		 $row = $sql->fetch();

		 return $row['c'];
	}

	// método que exibe os anúncios na página inicial
	public function ultimos_anuncios() {

		global $pdo;

		// criar um array vazio, porque se não entrar no if, o array continua vazio
		$array = array();

		$sql = $pdo->prepare("SELECT *,
			(SELECT anuncios_imagens.url FROM anuncios_imagens WHERE anuncios_imagens.anuncio_id = anuncios.id_anuncio LIMIT 1) AS url,
			(SELECT categorias.nome FROM categorias WHERE categorias.id_categorias = anuncios.categoria_id) AS categoria
		FROM anuncios ORDER BY id_anuncio DESC LIMIT 3");
		$sql->execute();

		// se $sql retornar alguma coisa
		if ($sql->rowCount() > 0) {

			// joga tudo o que encontrar dentro do array
			$array = $sql->fetchAll();
		}

		return $array;
	}

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

			// array em branco, para caso não tenha foto
			$array['fotos'] = array();

			// preparar consulta de fotos
			$sql = $pdo->prepare("SELECT id_anuncio_img,url FROM anuncios_imagens WHERE anuncio_id = :id_anuncio");
			$sql->bindValue(":id_anuncio", $id);
			$sql->execute();

			// se tiver alguma foto
			if($sql->rowCount() > 0) {
				// joga no array
				$array['fotos'] = $sql->fetchAll();
			}
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
	public function editAnuncio($categoria, $titulo, $descricao, $valor, $estado, $fotos, $id) {

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

		// ---------- ADICIONA FOTOS -------------------
		// adicionar biblioteca GD --> arquivo php.ini --> descomentar ;extension=gd2
		if (count($fotos) > 0) {
			// laço for para pegar cada foto
			for ($i=0; $i < count($fotos['tmp_name']); $i++) { 
				// pega o tipo da foto
				$tipo = $fotos['type'][$i];
				// se o tipo for jpeg ou png
				if (in_array($tipo, array('image/jpeg', 'image/png'))) {
					// pega a foto, adiciona um nome aleatório para ela, e adiciona a extensão jpg
					$tmpname = md5(time().rand(0, 9999)).'.jpg';
					// move a foto para a pasta de destino, e dá o nome a ela
					move_uploaded_file($fotos['tmp_name'][$i], 'assets/img/img-anuncios/'.$tmpname);

					// redimensionar o tamanho do arquivo
					// primeiro, pega as medidas originais
					list($width_orig, $height_orig) = getimagesize('assets/img/img-anuncios/'.$tmpname);

					// pega a proporção entre lagura e altura da imagem (medidas originais)
					$ratio = $width_orig / $height_orig;

					// definir limites
					$width = 500;
					$height = 500;

					// fazer as proporções entre largura e altura originais
					if ($width / $height > $ratio) {
						$width = $height * $ratio;
					} else {
						$height = $width / $ratio;
					}

					// com as novas medidas, criar nova imagem
					$img = imagecreatetruecolor($width, $height);

					// agora, transformar no tipo de imagem
					if ($tipo == 'image/jpeg') {
						$origin = imagecreatefromjpeg('assets/img/img-anuncios/'.$tmpname);
					} elseif ($tipo == 'image/png') {
						$origin = imagecreatefrompng('assets/img/img-anuncios/'.$tmpname);
					}

					// e, joga a imagem com as novas dimensões
					imagecopyresampled($img, $origin, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

					// agora é só salvar (o último parâmetro é a qualidade, que vai até 100)
					imagejpeg($img, 'assets/img/img-anuncios/'.$tmpname, 80);

					// depois de salvar no servidor, inserir no banco de dados
					$sql = $pdo->prepare("INSERT INTO anuncios_imagens SET anuncio_id = :id_anuncio, url = :url");
					$sql->bindValue(":id_anuncio", $id);
					$sql->bindValue(":url", $tmpname);
					$sql->execute();
				}
			}
		}
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

	public function excluirFoto($id) {

		global $pdo;

		$id_anuncio = 0; // para não dar erro se não tiver nada

		// antes de excluir a foto, pegar qual anúncio ele faz parte
		$sql = $pdo->prepare("SELECT id_anuncio_img FROM anuncios_imagens WHERE id_anuncio_img = :id");
		$sql->bindValue(":id", $id);
		$sql->execute();

		// se tiver resultado...
		if ($sql->rowCount() > 0) {
			$row = $sql->fetch();
			$id_anuncio = $row['id_anuncio_img'];
		}

		// exclui a foto
		$sql = $pdo->prepare("DELETE FROM anuncios_imagens WHERE id_anuncio_img = :id");
		$sql->bindValue(":id", $id);
		$sql->execute();

		return $id_anuncio;
	}
}
?>