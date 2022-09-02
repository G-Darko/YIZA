<?php 
	session_start();
	$id_usu = $_SESSION['id_c'];
	$id_rol = $_SESSION['rol'];
	
	$nombre = $_SESSION['nombre_c'];
	$correo = $_SESSION['correo_c'];
	$usuario = $_SESSION['usuario_c'];
	$img = $_SESSION['img_c'];
	$contra = $_SESSION['contra_c'];

	if (!isset($_SESSION['id_c'])) {
		$img = "img/predeterminado.png";
	}
?>