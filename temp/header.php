<?php
require 'config.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Classificados</title>
	<!-- Carregar primeiro o css para estilizar a página -->
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css"/>
	<link rel="stylesheet" type="text/css" href="assets/css/estilo.css"/>
	<!-- Carregar primeiro o jQuery e depois o Booststrap, pois este precisa que aquele esteja carregado -->
	<script type="text/javascript" src="assets/js/jquery-3.3.1.js"></script>
	<script type="text/javascript" src="assets/js/bootstrap.min.css"></script>
</head>
<body>
<nav class="navbar navbar-inverse">
	<div class="container-fluid">
		<!-- cria a barra de navegação no topo da tela -->
		<div class="navbar-header">
			<a href="index.php" class="navbar-brand">Classificados</a>
		</div>
		<!-- cria os botões de navegação na barra de navegação -->
		<ul class="nav navbar-nav navbar-right">
			<!-- verifica se o usuário está logado (se tem uma sessão) -->
			<?php if(isset($_SESSION['clogin']) && !empty($_SESSION['clogin'])) : ?>
				<li><a href="meus-anuncios.php">Meus Anúncios</a></li>
				<li><a href="sair.php">Sair</a></li>
			<!-- se não tiver usuário logado, mostrar esses botões abaixo -->
			<?php else : ?>
				<li><a href="cadastro.php">Cadastre-se</a></li>
				<li><a href="login.php">Login</a></li>
			<?php endif; ?><!-- finaliza bloco if/else -->
		</ul>
	</div>
</nav>