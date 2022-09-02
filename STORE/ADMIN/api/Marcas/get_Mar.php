<?php 
	require '../../require/conexion.php';
	$response = new stdClass();

	$id_mar = $_POST['id_mar'];

	$sql = "SELECT * FROM marcas where id_mar = $id_mar";
	$res = mysqli_query($conexion, $sql);
	$row = mysqli_fetch_assoc($res);
	$obj = new stdClass();

	$nombre = $row['nombre'];
	$order   = '&quot;';
	$replace = '"';
	$nombre = str_replace($order, $replace, $nombre);
	
	$obj->nombre = $nombre;
	$obj->img = $row['img'];

	$response->mar=$obj;

	echo json_encode($response);
?>