<?php 
	require '../../require/conexion.php';
	$response = new stdClass();
	//$response->state=true;

	$id_ped = $_POST['id_ped'];

	$sql = "UPDATE pedidos SET id_statusPed = 4 WHERE id_ped = $id_ped";
				
	$resultado = mysqli_query($conexion, $sql);

	if ($resultado) {
			$response->state=true;
	}else{
		$response->state=false;
		$response->detail="Error al cancelar el pedido";
	}
			

	

	echo json_encode($response);
?>