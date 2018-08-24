<?php
require 'temp/header.php';

// chama classe e instancia objeto
require 'classes/Anuncio.class.php';
require 'classes/Usuario.class.php';
$a = new Anuncio();
$u = new Usuario();

// inicia variáveis que serão usadas abaixo
$total_anuncios = $a->total_anuncios();
$total_usuarios = $u->total_usuarios();
$anuncios = $a->ultimos_anuncios();

?>
<!-- cria o container jumbotron -->
<div class="container-fluid">
	<div class="jumbotron">
		<h2>Temos <?php echo $total_anuncios; ?> anúncios cadastrados.</h2>
		<p>Temos <?php echo $total_usuarios ?> usuários cadastrados no nosso site.</p>
	</div>
	<!-- cria um grid para o conteúdo do site (uma linha com duas colunas) -->
	<div class="row">
		<div class="col-sm-3">
			<h4>Pesquisa Avançada</h4>
		</div>
		<div class="col-sm-9">
			<h4>Últimos Anúncios</h4>
			<!-- tabela para exibir os anúncios -->
			<table class="table table-striped">
				<tbody>
					<?php foreach($anuncios as $anuncio) : ?>
						<tr>
							<td><!-- na primeira coluna, exibe a imagem do produto -->
								<!-- se tiver uma imagem na url, mostra essa imagem -->
								<?php if (!empty($anuncio['url'])): ?>
								<img src="assets/img/img-anuncios/<?php echo $anuncio['url'] ?>" border="0" height="30" />
								<!-- se não tiver, mostra uma imagem padrão (default.jpg) -->
								<?php else: ?>
								<img src="assets/img/default.png" height="35" />
								<?php endif; ?>
							</td>
							<td><!-- na segunda, exibe o nome conforme titulo e a categoria -->
								<a href="produto.php?id=<?php echo $anuncio['id_anuncio'] ?>"><?php echo $anuncio['titulo'] ?></a><br><!-- essa categoria na linha abaixo é a da consulta, no método ultimos_anuncios() -->
								<?php echo utf8_encode($anuncio['categoria']) ?>
							</td>
							<td>R$ <?php echo number_format($anuncio['valor'], 2) ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<?php
require 'temp/footer.php';
?>