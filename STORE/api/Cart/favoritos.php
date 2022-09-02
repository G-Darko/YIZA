<?php 
	require '../../ADMIN/require/conexion.php';
	require '../../require/session_start.php';
	$response = new stdClass();
	//$response->state=true;

	if (!isset($_SESSION['id_c'])) {
		$response->state=false;
		$response->sesion=true;
		$response->detail="Inicia Sesión para poder añadir productos a favoritos";
	}else{
		$id_prod = $_POST['id_prod'];
		
				
		$sqlC = "SELECT * FROM favoritos WHERE id_usu = '$id_usu' AND id_prod = '$id_prod'";

		$resultado = $conexion->query($sqlC);
		$num = $resultado->num_rows;

		if ($num == 1) {
			$response->state=false;
			$response->detail="El producto ya existe en favoritos";
		}else{
			$sql = "INSERT INTO favoritos VALUES (null, $id_prod, $id_usu)";
			$res = mysqli_query($conexion, $sql);

			if ($res) {
				$response->state=true;
			}else{
				$response->state=false;
				$response->detail="Error al agregar en favoritos";
			}
		}

			
	}

	echo json_encode($response);
?>