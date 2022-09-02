<?php 
	$sql_Configuracion = "SELECT * FROM config WHERE id = 1";
	$res_Config = $conexion->query($sql_Configuracion);
	$_config = $res_Config->fetch_assoc();

	$comercio = $_config['nomCom'];
	$mTitle = $_config['metaNom'];
	$metaDes = $_config['metaDes'];
	$metaClave = $_config['metaClave'];
	$iAdmin = $_config['itemsAdmin'];
	$iStore = $_config['itemsStore'];
	$showStock = $_config['showStock'];
	$leyenda = $_config['leyendaStock'];
	$icon = $_config['logo'];
?>