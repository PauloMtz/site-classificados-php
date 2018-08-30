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
			<th colspan="2">Opções</th>
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
			<td>
				<!-- se tiver uma imagem na url, mostra essa imagem -->
				<?php if (!empty($anuncio['url'])): ?>
				<img src="assets/img/img-anuncios/<?php echo $anuncio['url'] ?>" border="0" height="30" />
				<!-- se não tiver, mostra uma imagem padrão (default.jpg) -->
				<?php else: ?>
				<img src="assets/img/default.png" height="35" />
				<?php endif; ?>
			</td>
			<td><?php echo $anuncio['titulo'] ?></td>
			<td>R$ <?php echo number_format($anuncio['valor'], 2) ?></td>
			<td><a href="editar-anuncio.php?id=<?php echo $anuncio['id_anuncio'] ?>"><img src="assets/img/editar.png" height="23" data-toggle="tooltip" title="editar anúncio"></a></td>
			<td><a href="excluir-anuncio.php?id=<?php echo $anuncio['id_anuncio'] ?>"><img src="assets/img/excluir.png" height="23" data-toggle="tooltip" title="excluir anúncio" onClick="return confirm('Deseja realmente excluir registro?')"></a></td>
		</tr>
		<?php
		} // finaliza foreach
		?>
	</table>
</div>
<?php require 'temp/footer.php'; ?>