<?php
session_start();
unset($_SESSION['clogin']);
header("location: index.php");
?>