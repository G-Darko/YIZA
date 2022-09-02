<?php 
	require '../../require/conexion.php';
	$response = new stdClass();
	//$response->state=true;

	$id_cat = $_POST['id_cat'];
	
	$sqlP = "SELECT * FROM cPadre where id_padre = $id_cat";
	$resP=mysqli_query($conexion,$sqlP);
	while ($rowP=mysqli_fetch_assoc($resP)){
		$id_catD = $rowP['id_cat'];

		$sql = "DELETE FROM categorias where id_cat = $id_catD";
		$resultado = mysqli_query($conexion, $sql);
	
		if ($resultado) {
			$response->state=true;
		}else{
			$response->state=false;
			$response->detail="Error al eliminar";
		}
	}
	$sql2 = "SELECT * FROM cPadre where id_padre != $id_cat AND id_cat = $id_cat";
	$res2=mysqli_query($conexion,$sql2);
	while ($row2=mysqli_fetch_assoc($res2)){

		$sql = "DELETE FROM categorias where id_cat = $id_cat";
		$resultado = mysqli_query($conexion, $sql);
	
		if ($resultado) {
			$response->state=true;
		}else{
			$response->state=false;
			$response->detail="Error al eliminar";
		}
	}

	echo json_encode($response);
?>