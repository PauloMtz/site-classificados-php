<?php 
require 'temp/header.php';

// verifica se existe sessão
if (empty($_SESSION['clogin'])) {
	?>
	<script type="text/javascript">window.location.href="login.php";</script>
	<?php
	exit;
}
?>
<div class="container">
	<h2>Meus Anúncios</h2>
	<!-- adiciona botão para adicionar anúncio -->
	<div align="right">
		<a href="add-anuncio.php" class="btn btn-default">Adicionar Anúncio</a>
	</div>
	<table class="table table-striped">
		<thead>
			<th>Foto</th>
			<th>Título</th>
			<th>Valor</th>
			<th>Opções</th>
		</thead>
		<?php
		// instancia classe
		require 'classes/Anuncio.class.php';

		// cria objeto
		$a = new Anuncio();

		// chama método
		$anuncios = $a->getMeusAnuncios();

		// lista os itens do banco de dados
		foreach ($anuncios as $anuncio) {
		?>
		<tr>
			<td><img src="assets/img/img-anuncios/<?php echo $anuncio['url'] ?>" border="0"/></td>
			<td><?php echo $anuncio['titulo'] ?></td>
			<td>R$ <?php echo number_format($anuncio['valor'], 2) ?></td>
			<td>Opções</td>
		</tr>
		<?php
		} // finaliza foreach
		?>
	</table>
</div>
<?php require 'temp/footer.php'; ?>