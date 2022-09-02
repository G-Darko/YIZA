<?php 
	require '../../require/conexion.php';
	$response = new stdClass();
	//$response->state=true;

	$id_prod = $_POST['id_prod'];

	$sql = "DELETE FROM productos where id_prod = $id_prod";
	$resultado = mysqli_query($conexion, $sql);

	if ($resultado) {
		$response->state=true;
	}else{
		$response->state=false;
		$response->detail="Error al eliminar";
	}
	

	echo json_encode($response);
?>