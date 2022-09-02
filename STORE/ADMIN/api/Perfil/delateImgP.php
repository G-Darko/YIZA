<?php 
	require '../../require/conexion.php';
	require '../../require/session_start.php';
	$response = new stdClass();
	//$response->state=true;
	$file = $_FILES['img'];
	if (is_file($file)) {
		chmod($file, 0777);
		if (!unlink($file)) {
			$response->state=false;
			$response->detail="falso";
		}
	}
	$img = 'img/predeterminado.png';
	$sql = "UPDATE usuarios set img = '$img' where id_usu = $id_usu";
	$resultado = mysqli_query($conexion, $sql);
		if ($resultado) {
			$response->state=true;
			$_SESSION['img'] = $img;
		}else{
			$response->state=false;
			$response->detail="Error al eliminar";
		}
	echo json_encode($response);

?>