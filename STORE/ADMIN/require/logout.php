<?php 
	require 'conexion.php';
	session_start();
	unset($_SESSION['id']);
	header('Location: ../');
	mysql_close($conexion);
	exit();
?>