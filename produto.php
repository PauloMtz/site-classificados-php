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

// verifica se foi enviado um id pelo formulário
if (isset($_GET['id'])) {
	$id = addslashes($_GET['id']);
} else {
	?> <!-- se não, manda para a página index -->
	<script type="text/javascript">window.location.href="index.php";</script>
	<?php
	exit;
}

// se pegar o id, vai para o próximo passo
$dados = $a->getAnuncio($id);

?>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-5">
			<!-- exibição do produto com carousel do Bootstrap -->
			<div class="carousel slide" data-ride="carousel" id="meuCarousel">
				<div class="carousel-inner" role="listbox">
					<?php foreach($dados['fotos'] as $chave => $foto): ?>
					<div class="item <?php echo ($chave=='0')?'active':''; ?>">
						<img src="assets/img/img-anuncios/<?php echo $foto['url'] ?>" />
					</div>
					<?php endforeach; ?>
				</div>
				<a class="left carousel-control" href="#meuCarousel" role="button" data-slide="prev"><span></span></a>
				<a class="right carousel-control" href="#meuCarousel" role="button" data-slide="next"><span></span></a>
			</div>
		</div>
		<div class="col-sm-7">
			<h2><?php echo $dados['titulo']; ?></h2>
			<h4><?php echo utf8_encode($dados['categoria']); ?></h4>
			<p><?php echo $dados['descricao']; ?></p>
			<br/>
			<h3>R$ <?php echo number_format($dados['valor'], 2); ?></h3>
			<h4>Telefone: <?php echo $dados['telefone']; ?></h4>
		</div>
	</div>
</div>
<?php require 'temp/footer.php'; ?>