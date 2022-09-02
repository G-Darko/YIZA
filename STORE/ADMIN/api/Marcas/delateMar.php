<?php 
	require '../../require/conexion.php';
	$response = new stdClass();
	//$response->state=true;

	$id_mar = $_POST['id_mar'];

	$sql = "DELETE FROM marcas where id_mar = $id_mar";
	$resultado = mysqli_query($conexion, $sql);

	if ($resultado) {
		$response->state=true;
	}else{
		$response->state=false;
		$response->detail="Error al eliminar";
	}
	

	echo json_encode($response);
?>