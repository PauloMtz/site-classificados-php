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

// consultar o banco para recuperar os dados preenchidos no formulário
// verifica se foi enviado um id a partir do formulário
if (isset($_GET['id'])) {

	$id = $_GET['id'];

	// pega o id passado e joga no método getAnuncio que está na classe Anuncio
	$dados = $a->getAnuncio($id);
} else {
	?>
	<script type="text/javascript">window.location.href="meus-anuncios.php";</script>
	<?php
	exit;
}

// depois de consultar, receber os dados para atualização no banco
if(isset($_POST['titulo']) && !empty($_POST['titulo'])) {

	// pega os dados e joga nas variáveis
	$categoria = addslashes($_POST['categoria']);
	$titulo = addslashes($_POST['titulo']);
	$valor = addslashes($_POST['valor']);
	$descricao = addslashes($_POST['descricao']);
	$estado = addslashes($_POST['estado']);

	// receber as fotos (se houver)
	if (isset($_FILES['fotos'])) {
		$fotos = $_FILES['fotos'];
	} else {
		$fotos = array();
	}

	// pega as variáveis e joga no método editAnuncio, que fica na classe Anuncio
	$a->editAnuncio($categoria, $titulo, $descricao, $valor, $estado, $fotos, $id);
	
	?>
	<div class="alert alert-success">
		Anúncio atualizado com sucesso!
	</div>
	<?php
}
?>
<div class="container">
	<h2>Editar Anúncio</h2><hr>
	<form method="POST" enctype="multipart/form-data">
		<div class="form-group">
			<label for="titulo">Titulo</label>
			<input type="text" name="titulo" id="titulo" class="form-control" autofocus="true" value="<?php echo $dados['titulo'] ?>">
		</div>
		<div class="form-group">
			<label for="descricao">Descrição</label>
			<textarea class="form-control" name="descricao"><?php echo $dados['descricao'] ?></textarea>
		</div>
		<div class="row">
			<div class="form-group col-sm-4">
				<label for="estado">Estado de conservação</label>
				<select name="estado" id="estado" class="form-control">
					<option value="1"<?php echo ($dados['estado'] == 1) ? 'selected="selected"' : '' ?>>Ruim</option>
					<option value="2"<?php echo ($dados['estado'] == 2) ? 'selected="selected"' : '' ?>>Bom</option>
					<option value="3"<?php echo ($dados['estado'] == 3) ? 'selected="selected"' : '' ?>>Ótimo</option>
				</select>
			</div>
			<div class="form-group col-sm-4">
				<label for="valor">Valor</label>
				<input type="text" name="valor" id="valor" class="form-control" value="<?php echo $dados['valor'] ?>">
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
					<option value="<?php echo $categoria['id_categorias'] ?>"<?php echo ($dados['categoria_id'] == $categoria['id_categorias']) ? 'selected="selected"' : '' ?>><?php echo utf8_encode($categoria['nome']) ?></option>
					<?php
					}
					?>
				</select>
			</div>
		</div>
		<!-- Painel do formulário para adicionar fotos do anúncio -->
		<div class="form-group">
			<label for="add_foto">Adicionar Foto(s) para o anúncio</label>
			<input type="file" name="fotos[]" multiple="true"/><br>

			<div class="panel panel-default">
				<div class="panel-heading"><b>Fotos do Anúncio</b></div>
				<div class="panel-body">
					<?php foreach($dados['fotos'] as $foto): ?>
					<div class="foto_item">
						<img src="assets/img/img-anuncios/<?php echo $foto['url']; ?>" class="img-thumbnail" border="0" /><br/>
						<a href="excluir-foto.php?id=<?php echo $foto['id_anuncio_img']; ?>" class="btn btn-default">Excluir Imagem</a>
					</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>	
		<input type="submit" value="Atualizar">
	</form>
</div>
<?php require 'temp/footer.php'; ?>