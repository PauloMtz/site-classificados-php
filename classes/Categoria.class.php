<?php
class Categoria {

	public function getList() {

		$array = array();
		global $pdo;

		$sql = $pdo->query("SELECT * FROM categorias");

		if ($sql->rowCount() > 0) {
			$array = $sql->fetchAll();
		}

		return $array;
	}
}
?>