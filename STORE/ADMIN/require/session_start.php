<?php 
	session_start();
	if (!isset($_SESSION['id'])) {
		header('Location: ../ADMIN');
	}
	$id_usu = $_SESSION['id'];
	$id_rol = $_SESSION['rol'];
	
	$nombre = $_SESSION['nombre'];
	$correo = $_SESSION['correo'];
	$usuario = $_SESSION['usuario'];
	$img = $_SESSION['img'];
	$contra = $_SESSION['contra'];
	
	if ($id_rol == 1) {
		$rol = 'Administrador';
	}
?>