<?php

// como não está chamando o cabeçalho da página, precisa chamar o config
require 'config.php';

// verifica se a sessão não está vazia
if (empty($_SESSION['clogin'])) {
	header("location: login.php");
	exit;
}

// chama a classe Anuncio
require 'classes/Anuncio.class.php';

// cria objeto
$a = new Anuncio();

// se tiver sido enviado um id a partir do formulário
if (isset($_GET['id'])) {

	// joga no método excluirFoto, que está na classe Anuncio
	$id_anuncio = $a->excluirFoto($_GET['id']);
}

// se excluir a foto redireciona para uma das páginas
if (isset($id_anuncio)) {
	header("location: editar-anuncio.php?id_anuncio_img=".$id_anuncio);
} else {
	header("location: meus-anuncios.php");
}
?>