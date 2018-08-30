<?php
require 'temp/header.php';

// chama classe e instancia objeto
require 'classes/Anuncio.class.php';
require 'classes/Usuario.class.php';
require 'classes/Categoria.class.php';
$a = new Anuncio();
$u = new Usuario();
$c = new Categoria();

// cria filtros de pesquisa
$filtros = array(
	'categoria' => '',
	'preco' => '',
	'estado' => ''
);

if(isset($_GET['filtros'])) {
	$filtros = $_GET['filtros'];
}

// inicia variáveis que serão usadas abaixo
$total_anuncios = $a->total_anuncios($filtros);
$total_usuarios = $u->total_usuarios();
// $anuncios = $a->ultimos_anuncios(); /* foi lá para baixo, por causa da paginação*/

/* ------------- PAGINAÇÃO ------------------- */
$p = 1; // se estiver na página 1 --> ok
$porPagina = 2; // inicia quantidade de itens por página

// se não estiver na p. 1 --> vai para a página que o usuário clicar
if (isset($_GET['p'])) {
	$p = addslashes($_GET['p']);
}

// pega a quantidade de páginas na paginação
$total_paginas = ceil($total_anuncios / $porPagina); // ceil arredonda para cima

// parâmetros adicionados
$anuncios = $a->ultimos_anuncios($p, $porPagina, $filtros);

// pega categorias
$categorias = $c->getList();

/* a exibição da paginação é feita abaixo da tabela que mostra os itens */
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
			<form method="GET"><!-- formulário para pesquisa avançada -->
				<div class="form-group">
					<label for="categoria">Categoria:</label>
					<select id="categoria" name="filtros[categoria]" class="form-control">
						<option></option>
						<?php foreach($categorias as $cat): ?>
						<option value="<?php echo $cat['id_categorias']; ?>" <?php echo ($cat['id_categorias']==$filtros['categoria'])?'selected="selected"':''; ?>><?php echo utf8_encode($cat['nome']); ?></option>
						<?php endforeach; ?>
					</select>
				</div>

				<div class="form-group">
					<label for="preco">Preço:</label>
					<select id="preco" name="filtros[preco]" class="form-control">
						<option></option>
						<option value="0-50" <?php echo ($filtros['preco']=='0-50')?'selected="selected"':''; ?>>R$ 0 - 50</option>
						<option value="51-100" <?php echo ($filtros['preco']=='51-100')?'selected="selected"':''; ?>>R$ 51 - 100</option>
						<option value="101-200" <?php echo ($filtros['preco']=='101-200')?'selected="selected"':''; ?>>R$ 101 - 200</option>
						<option value="201-500" <?php echo ($filtros['preco']=='201-500')?'selected="selected"':''; ?>>R$ 201 - 500</option>
					</select>
				</div>

				<div class="form-group">
					<label for="estado">Estado de Conservação:</label>
					<select id="estado" name="filtros[estado]" class="form-control">
						<option></option>
						<option value="1" <?php echo ($filtros['estado']=='1')?'selected="selected"':''; ?>>Ruim</option>
						<option value="2" <?php echo ($filtros['estado']=='2')?'selected="selected"':''; ?>>Bom</option>
						<option value="3" <?php echo ($filtros['estado']=='3')?'selected="selected"':''; ?>>Ótimo</option>
					</select>
				</div>

				<div class="form-group">
					<input type="submit" class="btn btn-info" value="Buscar" />
				</div>
			</form><!-- fim do formulário de pesquisa avançada -->
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
								<a href="produto.php?id=<?php echo $anuncio['id_anuncio'] ?>"><?php echo $anuncio['titulo'] ?></a><br>
								<!-- essa categoria na linha abaixo é a da consulta, no método ultimos_anuncios() -->
								<?php echo utf8_encode($anuncio['categoria']) ?>
							</td>
							<td>R$ <?php echo number_format($anuncio['valor'], 2) ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<!-- exibição da paginação (com Bootstrap) -->
			<ul class="pagination">
				<?php for ($i=1; $i <= $total_paginas; $i++) : ?>
					<li class="<?php echo ($p == $i) ? 'active' : '' ?>"><a href="index.php?<?php $w = $_GET; $w['p']=$i;echo http_build_query($w); ?>"><?php echo $i ?></a></li>
				<?php endfor; ?>
			</ul>
		</div>
	</div>
</div>
<?php
require 'temp/footer.php';
?>