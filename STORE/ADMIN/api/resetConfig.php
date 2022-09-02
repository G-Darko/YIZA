<?php 
	require '../require/conexion.php';
	$response = new stdClass();

	$sql = "UPDATE config SET itemsAdmin = 20, itemsStore = 10, showStock = 'SI', leyendaStock = 'Stock no disponible', logo = 'img/logo.jpg' WHERE id = 1;";
	$resultado = mysqli_query($conexion, $sql);
	if ($resultado) {
		$response->state=true;
	}else{
		$response->state=false;
		$response->detail="Error al actualizar";
	}

	echo json_encode($response);

?>