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

	// joga no método excluirAnuncio, que está na classe Anuncio
	$a->excluirAnuncio($_GET['id']);
}

// redireciona para a página meus-anuncios
header("location: meus-anuncios.php");
?>