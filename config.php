<?php
session_start();

global $pdo;

try {
	$pdo = new PDO("mysql:dbname=classificados;host=localhost", "root", "toor.971");
} catch(PDOException $e) {
	echo 'Falha ao conectar com o banco de dados.<br>'/* . $e->getMessage() */;
}
?>