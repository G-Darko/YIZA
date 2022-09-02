<?php 
	require '../ADMIN/require/conexion.php';
	session_start();
	unset($_SESSION['id_c']);
	header('Location: ../');
	mysql_close($conexion);
	exit();
?>