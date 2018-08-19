<?php require 'temp/header.php';

// verifica se existe sessão
if (empty($_SESSION['clogin'])) {
	?>
	<script type="text/javascript">window.location.href="login.php";</script>
	<?php
	exit;
}

// chama a classe Anuncio
require 'classes/Anuncio.class.php';

// cria objeto
$a = new Anuncio();

// se tiver sido enviado dado do campo titulo
if(isset($_POST['titulo']) && !empty($_POST['titulo'])) {

	// pega os dados e joga nas variáveis
	$categoria = addslashes($_POST['categoria']);
	$titulo = addslashes($_POST['titulo']);
	$valor = addslashes($_POST['valor']);
	$descricao = addslashes($_POST['descricao']);
	$estado = addslashes($_POST['estado']);

	// pega as variáveis e joga no método addAnuncio, que fica na classe Anuncio
	$a->addAnuncio($categoria, $titulo, $descricao, $valor, $estado);
	
	?>
	<div class="alert alert-success">
		Anúncio adicionado com sucesso!
	</div>
	<?php
}
?>
<div class="container">
	<h2>Adicionar Anúncio</h2><hr>
	<form method="POST" enctype="multipart/form-data">
		<div class="form-group">
			<label for="titulo">Titulo</label>
			<input type="text" name="titulo" id="titulo" class="form-control" autofocus="true">
		</div>
		<div class="form-group">
			<label for="descricao">Descrição</label>
			<textarea class="form-control" name="descricao"></textarea>
		</div>
		<div class="row">
			<div class="form-group col-sm-4">
				<label for="estado">Estado de conservação</label>
				<select name="estado" id="estado" class="form-control">
					<option value="1">Ruim</option>
					<option value="2">Bom</option>
					<option value="3">Ótimo</option>
				</select>
			</div>
			<div class="form-group col-sm-4">
				<label for="valor">Valor</label>
				<input type="text" name="valor" id="valor" class="form-control">
			</div>
			<div class="form-group col-sm-4">
				<label for="categoria">Categoria</label>
				<select name="categoria" id="categoria" class="form-control">
					<?php
					require "classes/Categoria.class.php";
					$c = new Categoria();
					$categorias = $c->getList();
					foreach ($categorias as $categoria) {
					?>
					<option value="<?php echo $categoria['id_categorias'] ?>"><?php echo utf8_encode($categoria['nome']) ?></option>
					<?php
					}
					?>
				</select>
			</div>
		</div>
		<input type="submit" value="Cadastrar">
	</form>
</div>
<?php require 'temp/footer.php'; ?>